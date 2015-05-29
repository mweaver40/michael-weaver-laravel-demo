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


class CartController extends Controller
{
    public function addItem()
    {
        $productId = Request::input('productId');
        $quantity = Request::input('quantity');
        $orderId = Request::cookie('scubaCart');
        DB::beginTransaction();
        if (!isset($orderId))
        {           
            $time = Time::getDateTimeStr();
            $order = new Order();
            $order->created = $time;
            $order->setStatus(Order::PENDING);
            $order->last_status_change = $time;
            $order->save();
            Cookie::queue('scubaCart', $order->id, 5);   
        }
        else
        {
            $order = Order::find($orderId);
            if (!isset($order))
            {
                throw new Exception ("Order not found: " . $orderId);
            }
        }
        $item = new ItemOrdered();
        $item->product_id = $productId;
        $item->quantity = $quantity;
        $item->order_id = $order->id;
        $item->save();
        //$order->items()->save($item);
        DB::commit();
        return "$productId  $order->id $item->id";
    }
}