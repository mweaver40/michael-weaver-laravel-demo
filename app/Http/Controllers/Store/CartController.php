<?php

namespace Mweaver\Http\Controllers\Store;

use Mweaver\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Cookie;
use Mweaver\Util\Time;
use Mweaver\Store\Order\Order;
use \Exception;
use Mweaver\Store\Order\ItemOrdered;
use Illuminate\Support\Facades\DB;
use \Illuminate\Contracts\Auth\Registrar;

const CART_COOKIE = 'scubaCart';

class CartController extends Controller {

    protected $registrar;

    public function __construct(Registrar $registrar)
    {
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
        //$count = ItemOrdered::where('order_id', '=', $cart)->where('status', '=', Order::PENDING)->count();
        $count = ItemOrdered::where('order_id', '=', $cart)->count();
        return (!isset($count)) ? 0 : $count;
    }

    public function getCart($orderId = null, $cart = null) {

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

        return view('store.cart', $data);
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
        $data = CatalogController::getCatalogPageBasicInformation();
        return view("store.checkout", $data);
    }

    protected function getOrder($orderId) {
        $order = Order::with('items.catalog.product')->where('id', '=', $orderId)->where('status', '=', Order::PENDING)->first();
        //echo ("XXXXXXXXX $order->items");
        return $order;
        //return Order::with('items.catalog.product')->where('id', '=', $orderId)->where('status', '=', Order::PENDING);
        /*
          return Order::with(['items.catalog.product.prices' => function($q) {
          $q->where('')
          }])->where('id', '=', $orderId)->where('status', '=', Order::PENDING)->first();

         */
    }

}
