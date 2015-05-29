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

    public function items() {
        return $this->belongsTo('Mweaver\Store\Order\ItemOrdered');
    }

    /**
     * Make sure we get a good status in the order. 
     * @throws Exception
     */
    public function setStatus($inStatus)
    {
        echo "In the set status";
        if (!isset(self::$statusStates))
        {
            /*
             * OK normally we would want to protect this from muti thread 
             * concurrency issues but since plain PHP is not share nothing
             * we don' do it here. Probably no harm anyway since worse 
             * case it we reset the orderstates
             */
            echo "building order states ";
            $rc = new ReflectionClass(__CLASS__);
            Self::$statusStates = $rc->getConstants();
        }
        
        if(!in_array( $inStatus, self::$statusStates ))
        {
            // We would like to force the use of correct type but unless we
            // build a true enum object and type hint we can't. Maybe build 
            // true enum later
            throw new Exception("Unknown state " . $inStatus);
        }  
        $this->attributes['status'] = $inStatus;
    }
}
