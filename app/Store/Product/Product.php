<?php

namespace Mweaver\Store\Product;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Price;

class Product extends Model {

    protected $table = 'product';
    public $timestamps = false;

    public function prices() {
        return $this->hasMany('Mweaver\Store\Product\Price');
    }

    public function getEffectivePrice() {
        
    }

     public function images() {
        return $this->hasMany('Mweaver\Store\Product\Image');
    }
    
    public function scopeActive($query, $now)
    {
        return $query->whereRaw(' end is null and effective <= ? ', [$now]);
    }
}
