<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Product\Price;

class PriceSeeder extends Seeder {

    public function run() {
        Model::unguard();
        $faker = \Faker\Factory::create();
        $now = new DateTime();
        $nowString = $now->format('Y-m-d H:i:s');
        $products = Product::whereRaw(' end is null and effective < ? ', [$nowString])->get();
        foreach ($products as $product) {
            $price = new Price();
            // Between $1 and $1000
            $price->price = $this->randomFloat(1, 1000);
            $price->effective = $nowString;
            $price->product()->associate($product);
            $price->save();
        }
    }
    
     function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
}
