<?php

namespace Mweaver\Store\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

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
    
    /* 
     * I truley dislike the elequent query builder as it tends to make things
     * far more complicated then a simple query needs to be. But here I 
     * demonstrate I can use the framework
     */
    public static function getImagesByTypeMostImportanceOrdered($productId, $type)
    {
        return self::where('product_id', '=', $productId)
                ->where('type', '=', $type)
                ->orderBy('importance', 'asc')
                ->get();
    }
    
    public function getUrl()
    {
        //var_dump($this);
        return URL::asset("$this->location/$this->name");
    }

}
