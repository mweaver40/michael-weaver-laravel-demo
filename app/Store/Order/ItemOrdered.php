<?php


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mweaver\Store\Order;

use Illuminate\Database\Eloquent\Model;

/**
 * Description of ItemOrdered
 *
 * @author MIchael
 */
class ItemOrdered extends Model {

    protected $table = 'item_ordered';
    public $timestamps = false;

    public function catalog() {
        return $this->belongsTo('Mweaver\Store\Catalog\Catalog');
    }

}
