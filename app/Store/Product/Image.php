<?php

namespace Mweaver\Store\Product;

use Illuminate\Database\Eloquent\Model;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Image extends Model {

    protected $table = 'product_image';
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('Mweaver\Store\Product\Product');
    }

}
