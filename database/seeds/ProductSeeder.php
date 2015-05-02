<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Product\Image;
use Mweaver\Store\Product\Price;

class ProductSeeder extends Seeder {

    public $companyNames = array(
        'Scuba Dog',
        'Scuba Duba',
        'Mr Scuba',
        'Salty Dog',
        'Mermaid',
        'Sea Stuff',
        'Dive Deep',
        'Technical Divers',
        'Go Dive',
        'Sea Foam',
        'Overboard',
        'Scuba Smo',
        'Underwater Stuff',
        'Aqua Mung'
    );

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
        $faker = \Faker\Factory::create();

        $companyCnt = count($this->companyNames);
        $images = ImageHelper::getImageKeyArrary();
        /*
          foreach (range(1, 5000) as $id) {
          $product = new Product();
          $product->name = $faker->text(mt_rand(15, 30));
          $product->description = $faker->text(mt_rand(75, 200));
          $product->company_product_id = $faker->randomNumber(5);
          $product->company = $this->companyNames[mt_rand(0, $companyCnt - 1)];
          $now = new DateTime();
          $product->effective = $now->format('Y-m-d H:i:s');
          $product->save();
          //$image = new Image();
          //$this->createImage($product, 1);
          //$this->createImage($product, 2);


         */
        $now = new DateTime();
        $effStr = $now->format('Y-m-d H:i:s');
        foreach (range(1, 5000) as $id) {
            $product = new Product();
            $product->name = "dog";
            $product->description = "BLah Blah";
            $product->company = "woof";
            $product->effective = $effStr;
            $product->save();
            //$image = new Image();
            //$this->createImage($product, 1);
            //$this->createImage($product, 2);
        }
    }

    private function createImage($product, $importance) {
        $image = new Image();

        $image->type = "thumb";
        $image->product()->associate($product);
        $image->location = "/image/store/products/small";
        $image->name = $product->id . "_$importance.jpg";
        $image->importance = $importance;
        $image->save();
    }

}
