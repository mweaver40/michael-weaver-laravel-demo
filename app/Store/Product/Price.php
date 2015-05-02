<?php

namespace Mweaver\Store\Product;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;

class Price extends Model {

    protected $table = 'price';
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('Mweaver\Store\Product\Product');
    }

}
