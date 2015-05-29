<?php

namespace Mweaver\Store\Product;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use DateTime;
use Mweaver\Util\Time;

class Price extends Model {

    protected $table = 'price';
    public $timestamps = false;

    public function product() {
        return $this->belongsTo('Mweaver\Store\Product\Product');
    }

    public static function getEffectivePrice($productId, $dateTime = null) {
        $time = Time::getDateTimeStr($dateTime);
        return Self::whereRaw("product_id = ? and effective = "
                . " (select max(p2.effective) from price p2 "
                . " where p2.product_id = ? "
                . " and p2.effective is not null "
                . " and p2.end is null and p2.effective < ?)", [$productId, $productId, $time])->first();
    }

}
