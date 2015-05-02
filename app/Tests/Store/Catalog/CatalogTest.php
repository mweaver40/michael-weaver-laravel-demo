<?php

//namespace Mweaver\Test\Store\Catalog\Catalog;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Category;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Catalog\Description;
use Mweaver\Store\Product\Price;
use Illuminate\Support\Facades\DB;
use Mweaver\Events\Event;

class StoreBasicDBTest extends TestCase
{
    public function testCanCreateAndQueryCatalog()
    {
        $catalog = new Catalog();
        $catalog->effective = date('Y-m-d H:i:s');
        $catalog->name = 'Test';
        $category = new Category();
        $category->name = 'Test Category';
        $category->description = 'Test category';
        $category->save();
        $product = new Product();
        $product->name = "Test product";
        $product->effective = date('Y-m-d H:i:s');
        $product->description = "A test product";
        $product->save();
        $description = new Description();
        $description->description = "Test description";
        $description->save();
        $catalog->product()->associate($product);
        $catalog->category()->associate($category);
        $catalog->description()->associate($description);
        $catalog->save();
        $catalog2 = $catalog->find($catalog->id);
        $this->assertEquals($catalog->name, $catalog2->name);
        $this->assertEquals($catalog->product->name, $catalog2->product->name);
        $this->assertEquals($catalog->category->name, $catalog2->category->name);
        $this->assertEquals($catalog->description->description, $catalog2->description->description);
    }
    /**
     * 
     */
     public function testCanCreateAndQueryPrice()
     {
         $product = new Product();
         $product->name = "Price Test";
         $product->effective = date('Y-m-d H:i:s');   
         $product->save();
         $price1 = new Price();
         $price1->effective = date('Y-m-d H:i:s');
         $price1->price = 10.00;
         $price1->product()->associate($product);
         $price2 = new Price();
         $price2->effective = date('Y-m-d H:i:s');
         $price2->price = 20.00;
         $price2->product()->associate($product);
         $price1->save();
         $price2->save();
         $priceQ1 = $price1->find($price1->id);
         $priceQ2 = $price2->find($price2->id);
         $this->assertEquals($price1->price, $priceQ1->price);
         $this->assertEquals($price2->price, $priceQ2->price);   
         $this->assertEquals($priceQ1->product->id, $priceQ2->product->id );
         $this->assertEquals($priceQ1->price,$price1->price);
         $this->assertEquals($priceQ2->price,$price2->price);
         $prices = $product->prices;
         $this->assertTrue(count($prices) == 2);
     }
     
     public function testCanGetCatalog()
     {
         $catalog = new Catalog();
         DB::connection()->enableQueryLog();
         $items = $catalog->getCatalogPage(1,1,1);
         $queries = DB::getQueryLog();
         $last_query = end($queries);
         echo "query count = " . count($queries);
         echo "query = " + dump($last_query);
         
        
         echo "count items = " . count($items);
         foreach ($items as $item)
         {
             echo "item->description";
         }
         $this->assertTrue(1 == 1);
     }
}