<?php

namespace Mweaver\Store\Catalog;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Catalog\Category;
use Mweaver\Store\Product\Product;
use Illuminate\Support\Facades\DB;

class Catalog extends Model {

    protected $table = 'catalog';
    public $timestamps = false;

    public function category() {
        return $this->belongsTo('Mweaver\Store\Catalog\Category');
    }

    public function product() {
        return $this->belongsTo('Mweaver\Store\Product\Product');
    }

    public function description() {
        return $this->belongsTo('Mweaver\Store\Catalog\Description');
    }

    public function getCatalogPage($effective, $fromCnt, $toCnt) {


        /* ->where(DB::raw('c.product_id = p.id'))
          ->from(DB::raw('catalog c , product p'))
          ->select(DB::raw('c.*'))
          ->get() */

        //->join('product', 'catalog.product_id', '=', 'product.id')       
        $catalog = Catalog::query()
                ->whereRaw('c.product_id = p.id')
                ->from(DB::raw('catalog c , product p'))
                ->select(DB::raw('c.*'))
                /*
                  ->join('product', 'catalog.product_id', '=', 'product.id')
                  ->select('catalog.*') */
                ->get();
        return $catalog;
    }

}
