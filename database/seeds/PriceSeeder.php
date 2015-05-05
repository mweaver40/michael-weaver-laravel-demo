<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Product\Price;

class PriceSeeder extends DrivenSeeder {

    public function run() {
        Model::unguard();

        $now = new DateTime();
        $nowString = $now->format('Y-m-d H:i:s');

        $productModel = new Product();
        $productBuilder = $productModel->active($now);
        $data = [ 'now' => $nowString];


        $this->populateTableFromDrivingTable($productBuilder, 'price', 100, $data, function (&$product, &$prices, &$data) {
           
            $now = $data['now'];
            $price = $this->randomFloat(1, 1000);
            $prices[] = ['price' => $price,
                'product_id' => $product->id, 'effective' => $now,
            ];
        });
    }

    protected function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }

}
