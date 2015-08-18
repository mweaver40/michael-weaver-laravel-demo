<?php

namespace Mweaver\Http\Controllers\Store;

use Mweaver\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Cookie;
use Mweaver\Util\Time;
use Mweaver\Store\Order\Order;
use \Exception;
use Mweaver\Store\Order\ItemOrdered;
use Mweaver\Store\Address;
use Illuminate\Support\Facades\DB;
use \Illuminate\Contracts\Auth\Registrar;
use \Log;


/**
 * Controls the cart and order process. Includes checkout for now
 * 
 */
class CartController extends StoreController {

    protected $registrar;

    public function __construct(Registrar $registrar) {
        $this->registrar = $registrar;
    }

    /**
     * 
     * @return type
     * @throws Exception
     * Adds an item to the order. If the order does not exist it is created
     * and a cookie with the order id is also created
     */
    public function addItem() {
        $catalogId = Request::input('catalogId');
        $quantity = Request::input('quantity');
        $orderId = Request::cookie('scubaCart');
        DB::beginTransaction();
        if (!isset($orderId)) {
            $order = Order::build(Order::PENDING, Time::getDateTimeStr());
            $order->save();
            $this->createCartCookie($order->id);
        } else {
            $order = Order::find($orderId);
            if (!isset($order)) {
                throw new Exception("Order not found: " . $orderId);
            }
        }
        $item = new ItemOrdered();
        $item->catalog_id = $catalogId;
        $item->quantity = $quantity;
        $item->order_id = $order->id;
        $item->save();

        $cnt = self::getCartCnt($order->id);
        DB::commit();
        return "$cnt";
    }

    /*
     * Creates a cookie for the cart containing only the order id
     */
    protected function createCartCookie($value) {
        $timeout = env('CART_TIMEOUT', '10080'); // Default is 1 week
        Cookie::queue(CART_COOKIE, $value, intval($timeout));
    }

   

    /**
     * 
     * @param type $orderId
     * @param type $cart
     * @return type
     * Builds the cart contents page
     */
    public function getCart($orderId = null, $cart = null) {


        $data = $this->getCartContents($orderId, $cart);
        return view('store.cart', $data);
    }

    /**
     * 
     * @param type $orderId
     * @param type $cart
     * @return type
     * Retrun the order and the total price of all items in the cart.
     */
    protected function getCartContents($orderId = null, $cart = null) {
        if (!isset($orderId)) {
            $orderId = Cookie::get(CART_COOKIE);
        }

        if (isset($orderId) && !isset($cart)) {
            $cart = $this->getOrder($orderId);
        }
        $data = $this->getCatalogPageBasicInformation();
        $total = 0;

        if (isset($cart)) {
            foreach ($cart->items as $item) {
                // Currrently only have a single price structure so use only one we have.
                $price = $item->catalog->product->getEffectivePrice();
                $total += ($price->price * $item->quantity);
            }
        }
        $data['cart'] = $cart;
        $data['total'] = $total;
        return $data;
    }

    /**
     * 
     * @param type $item
     * @return type
     * Remove and item from order based on posted id
     */
    function removeItem($item) {
        $orderId = Cookie::get(CART_COOKIE);
        if (isset($orderId)) {
            ItemOrdered::find($item)->delete();
        }
        return $this->getCart($orderId);
    }

    /**
     * 
     * @return type
     * @throws Exception
     * Update any existing item quantities based on the posted values
     */
    function updateCart() {
        $orderId = Cookie::get(CART_COOKIE);
        if (isset($orderId)) {
            $cart = $this->getOrder($orderId);
            $items = $cart->items;
            $cnt = 1;
            $done = false;
            while (!$done) {
                $idKey = "item-id-$cnt";
                // If the posted item key val is null there are no more items to process
                if (!array_key_exists($idKey, $_POST))
                    break;
                $quantityKey = "quantity-$cnt";
                // If there is no quantity associated with the posted item then error
                if (!array_key_exists($quantityKey, $_POST))
                    throw new Exception("param $quatityKey is missing ");
                $requestItem = $_POST[$idKey];
                $requestQuantity = $_POST[$quantityKey];
                if (!isset($requestItem))
                    break;
                // TODO: consider if query each item is better. Probably
                foreach ($items as $item) {
                    if ($requestItem == $item->id && $item->quantity != $requestQuantity) {
                        $item->quantity = $requestQuantity;
                        $item->save();
                    }
                }
                $cnt++;
            }
        }
        return $this->getCart($orderId, $cart);
    }

    /**
     * 
     * @return type
     * Build checkout process page
     */
    function checkout() {
        $data = $this->getCartContents();
        // Set up a billing address to display 
        $billing = isset($data['cart']->billing_address) ?
                ($data['cart']->billingAddress) : new Address();
        $shipping = isset($data['cart']->shipping_address) ?
                ($data['cart']->shippingAddress) : new Address();
        $data['billing'] = $billing;
        $data['shipping'] = $shipping;

        return view("store.checkout", $data);
    }

    /*
     * Get pending order associated with id.
     */
    protected function getOrder($orderId) {
        $order = Order::with('items.catalog.product')->where('id', '=', $orderId)->where('status', '=', Order::PENDING)->first();
        return $order;
    }

    /**
     * Set or update billing address
     */
    public function updateBillingAddress() {
        Log::debug("Entering updateBillingAddress");
        DB::transaction(function () {
            $order = $this->getOrderData();
            if (isset($order)) {
                // update the existing billing adress or create a new one
                $address = $order->billingAddress;
                if (!isset($address))
                    $address = new Address();
                $address = $this->fillOrderAddress($address);
                $address->save();
                $order->billing_address = $address->id;
                $order->save();
            }
        });
    }

    /**
     * Set or update shipping address.
     */
    public function updateShippingAddress() {
        Log::debug("Entering updateShipping");
        DB::transaction(function () {
            $order = $this->getOrderData();
            if (isset($order)) {
                // If set shipping addres same as billing
                if (isset($_POST['useBillingAddress'])) {
                    $useBilling = $_POST['useBillingAddress'];
                    if ($useBilling == "1") {
                        $order->shipping_address = $order->billing_address;
                    }
                    // Not using billing address
                } else {
                    // update the existing billing adress or create a new one
                    $address = $order->shippingAddress;
                    // if no existing address or changing from billing address
                    if (!isset($address) || $order->billing_address == $order->shipping_address)
                        $address = new Address();

                    $address = $this->fillOrderAddress($address);
                    $address->save();
                    $order->shipping_address = $address->id;
                }
                $order->save();
            }
        });
    }

    /**
     * 
     * @return type
     * @throws Exception
     * @throws type
     * Gets the order based on ID in cookie
     */
    private function getOrderData() {

        $order = null;
        $orderId = Cookie::get(CART_COOKIE);
        if (isset($orderId)) {

            $order = $this->getOrder($orderId);
            if (!isset($order)) {
                throw new Exception("Order $orderId not found");
            }
        } else {
            throw (new Exception("Cart cookie not valid"));
        }
        return $order;
    }

    /*
     * Stubbed order process. Order status is updated to SUBMITED and
     * cart cookie is removed. In reality it is likly we would
     * call this after calling a third party service provider 
     */

    public function submitOrder() {
        Log::debug("Entering submitOrder");
        $order = $this->getOrderData();
        if (isset($order)) {
            $order->setStatus(Order::SUBMITED);
            $order->save();
            $data = $this->getCatalogPageBasicInformation();
            $data['orderId'] = $order->id;
            $cookie = Cookie::forget(CART_COOKIE);
            Cookie::queue($cookie);
        } else {
            throw new Exception("Order $orderId not found");
        }
        return view('store.orderConfirm', $data);
    }

    /**
     * 
     * @param type $address
     * @return type
     * Fill in order fields to persist
     */
    protected function fillOrderAddress($address) {
        $address->line_1 = $_POST['line1'];
        $address->line_2 = $_POST['line2'];
        $address->first_name = $_POST['firstName'];
        $address->last_name = $_POST['lastName'];
        $address->company = $_POST['company'];
        $address->telephone = $_POST['telephone'];
        $address->city = $_POST['city'];
        $address->state = $_POST['state'];
        $address->country = $_POST['country'];
        $address->zipcode = $_POST['zipcode'];
        return $address;
    }

}
