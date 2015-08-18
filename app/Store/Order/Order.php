<?php

namespace Mweaver\Store\Order;

use Illuminate\Database\Eloquent\Model;
use \ReflectionClass;
use \Exception;
use Mweaver\Store\Order\ItemOrdered;

/**
 * Order model
 */
class Order extends Model {

    protected $table = 'order';
    public $timestamps = false;

    const PENDING = 'pending';
    const TIMEDOUT = 'timedout';
    const CANCELED = "canceled";
    const PROCESSING = "processing";
    const COMPLETE = "complete";
    const SUBMITED = "submited";

    static protected $statusStates = NULL;

    /**
     * 
     * @param type $status
     * Beacuse PHP has no overloaded methods and because Laravel depends
     * on the default constructor (yes the constructor can be altered but it 
     * seems to not be a good idea) we create this semi factory method
     * 
     */
    public static function build($status, $time) {
        $order = new Order();
        $order->created = $time;
        $order->setStatus($status);
        $order->last_status_change = $time;
        return $order;
    }

    public function items() {
        return $this->hasMany('Mweaver\Store\Order\ItemOrdered');
    }

    /**
     * Make sure we get a good status in the order. 
     * @throws Exception
     */
    public function setStatus($inStatus) {
        if (!isset(self::$statusStates)) {
            /*
             * OK normally we would want to protect this from muti thread 
             * concurrency issues but since plain PHP is not share nothing
             * we don' do it here. Probably no harm anyway since worse 
             * case it we reset the orderstates
             */
            $rc = new ReflectionClass(__CLASS__);
            Self::$statusStates = $rc->getConstants();
        }

        if (!in_array($inStatus, self::$statusStates)) {
            // We would like to force the use of correct type but unless we
            // build a true enum object and type hint we can't. Maybe build 
            // true enum later
            throw new Exception("Unknown state " . $inStatus);
        }
        $this->attributes['status'] = $inStatus;
    }

    public function billingAddress() {
        return $this->hasOne('Mweaver\Store\Address', 'id', 'billing_address');
    }

    public function shippingAddress() {
        return $this->hasOne('Mweaver\Store\Address', 'id', 'shipping_address');
    }
    
    /**
     * 
     * @param type $id
     * @param type $state
     * @return type
     * Return the number of items for the the order. 
     */
    public static function getItemCntByState($id, $state)
    {
               /* 
         * This demonstrates why I am NOT fond of the query builder
         * It takes somehting simple like SQL and makes it difficult 
         * to write and understand while adding no extra value. 
         * This is why I often use raw where statements.
         */
        
        $count = ItemOrdered::where('order_id', '=', $id)
                ->where('status', '=', $state)
                ->join('order', 'order.id', '=', 'order_id')
                ->sum('quantity');
        return (!isset($count)) ? 0 : $count;
    }

}
