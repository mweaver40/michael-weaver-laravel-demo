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

const CART_COOKIE = 'scubaCart';

class CartController extends Controller {

    protected $registrar;

    public function __construct(Registrar $registrar) {
        $this->registrar = $registrar;
    }

    public function addItem() {
        $catalogId = Request::input('catalogId');
        $quantity = Request::input('quantity');
        $orderId = Request::cookie('scubaCart');
        DB::beginTransaction();
        if (!isset($orderId)) {
            $time = Time::getDateTimeStr();
            $order = new Order();
            $order->created = $time;
            $order->setStatus(Order::PENDING);
            $order->last_status_change = $time;
            $order->save();
            Cookie::queue(CART_COOKIE, $order->id, 60);
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
//$order->items()->save($item);   
        $cnt = self::getCartCnt($order->id);
        DB::commit();
        return "$cnt";
    }

    public static function getCartCnt($cart = null) {
        if (!isset($cart)) {
            $cart = Cookie::get(CART_COOKIE);
            if (!isset($cart)) {
                return 0;
            }
        }
        /* 
         * This demonstrates why I am NOT fond of the query builder
         * It takes somehting simple like SQL and makes it difficult 
         * to write and understand while adding no extra value. 
         * This is why I often use raw where statements.
         */
        
        $count = ItemOrdered::where('order_id', '=', $cart)
                ->where('status', '=', Order::PENDING)
                ->join('order', 'order.id', '=', 'item_ordered.order_id')
                ->count();
        //$count = ItemOrdered::where('order_id', '=', $cart)->count();
        return (!isset($count)) ? 0 : $count;
    }

    public function getCart($orderId = null, $cart = null) {


        $data = $this->getCartContents($orderId, $cart);
        return view('store.cart', $data);
    }

    protected function getCartContents($orderId = null, $cart = null) {
        if (!isset($orderId)) {
            $orderId = Cookie::get(CART_COOKIE);
        }

        if (isset($orderId) && !isset($cart)) {
            $cart = $this->getOrder($orderId);
        }
        $data = CatalogController::getCatalogPageBasicInformation();
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

    function removeItem($item) {
        $orderId = Cookie::get(CART_COOKIE);
        if (isset($orderId)) {
            ItemOrdered::find($item)->delete();
        }
        return $this->getCart($orderId);
    }

    function updateCart() {
        $orderId = Cookie::get(CART_COOKIE);
        if (isset($orderId)) {
            $cart = $this->getOrder($orderId);
            $items = $cart->items;
            $cnt = 1;
            $done = false;
            while (!$done) {
                $idKey = "item-id-$cnt";
                if (!array_key_exists($idKey, $_POST))
                    break;
                $quantityKey = "quantity-$cnt";
                if (!array_key_exists($quantityKey, $_POST))
                    throw new Exception("param $quatityKey is missing ");
                $requestItem = $_POST[$idKey];
                $requestQuantity = $_POST[$quantityKey];
                if (!isset($requestItem))
                    break;
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

    protected function getOrder($orderId) {
        $order = Order::with('items.catalog.product')->where('id', '=', $orderId)->where('status', '=', Order::PENDING)->first();
        return $order;
    }

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

    public function updateShippingAddress() {
        Log::debug("Entering updateShipping");
        DB::transaction(function () {
            $order = $this->getOrderData();
            if (isset($order)) {
// Set shipping addres same as billing
                if (isset($_POST['useBillingAddress'])) {
                    $useBilling = $_POST['useBillingAddress'];
                    if ($useBilling == "1") {
                        $order->shipping_address = $order->billing_address;
                    }
// Not updating use of billing address so update or create shipping address
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
            $data = CatalogController::getCatalogPageBasicInformation();
            $data['orderId'] = $order->id;
            $cookie = Cookie::forget(CART_COOKIE);
            Cookie::queue($cookie);
            
        } else {
            throw new Exception("Order $orderId not found");
        }
        return view('store.orderConfirm', $data);
    }

    
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
