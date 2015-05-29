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
    
  
    
    use WebModelTrait;
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

    public function getCatalogPageExperiment($effective, $fromCnt, $toCnt) {

        
    

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

    /*
     * This method does NOT return a model. It returns a simple array result
     * of the query. The query is too complex to make it an Lavel object
     * easily but it could be done. Might try it later but efficancy could 
     * easily suffer and this is the heart of the catalof system
     */

    public function getCatalogPage($time, $imageType, $categoryId, $offset, $limit) {
        $catalogPageQ = "select c.id catalogId, ifnull(c.name, p.name) name, "
                . " p.company, c.product_id productId,"
                . " i.name imageName , i.location imageLocation, "
                . " pr.price "
                . " from product p, catalog c, product_image i, price pr where "
                . " :time1 > p.effective "
                . " and p.end is null "
                . " and c.product_id = p.id and c.category_id = :categoryId"
                . " and c.effective = "
                . "(select max(effective) from catalog c2 where p.id = c2.product_id and"
                . " c2.end is null and :time2 > c2.effective) "
                . " and p.id = pr.product_id "
                . " and pr.effective = "
                . "(select max(effective) from price pr2 where p.id = pr2.product_id and"
                . " pr2.end is null and :time3 > pr2.effective) "
                . " and p.id = i.product_id  "
                . " and i.type = :imageType  "
                . " and i.importance = (select min(importance) from product_image i2"
                . " where i2.product_id = p.id) "
                . " order by p.id limit :offset, :limit  ";
        // Really lame, PDO requires separte names for each instance of replacement. LAME
        return DB::select($catalogPageQ, ['time1' => $time, 'time2' => $time,
                    'time3' => $time, 'imageType' => $imageType,
                    'categoryId' => $categoryId, 'offset' => $offset, 'limit' => $limit]);
    }

    // OK this coud be done in staight elequent but honestly I think eloquent is 
    // more painfull then helpfull in many situations. Simple access works great 
    // the rest is more trouble then it is worth. You can always write a repository
    // interface to make it easy to change the underlying DB.
    public function getCatalogCategoryItemCnt($category, $time) {
       
                
        $result =  DB::select("select count(c.id)cnt from catalog c, product p where "
                        . " c.category_id = ? "
                        . " and c.effective < ? and c.end is null "
                        . " and  p.id = c.product_id "
                        . " and p.effective < ? and p.end is null", [$category, $time, $time]);
        return (!isset($result)) ? 0 : $result[0]->cnt;
    }

}
