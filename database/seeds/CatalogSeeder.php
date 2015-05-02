<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Description;

class CatalogSeeder extends Seeder {
   
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
        $faker = \Faker\Factory::create();
        $now = new DateTime();
        $nowString = $now->format('Y-m-d H:i:s');
        $products = Product::whereRaw(' end is null and effective < ? ', [$nowString])->get();
        foreach($products as $product)
        {
            
            //echo "product is " . $product->id . "\n";
            $catalog = new Catalog();
            $catalog->effective = $nowString;
            $catalog->name = $faker->text(mt_rand(15, 30));
            // No need to get category obj we only need category id which we have
            $catalog->category_id = CategorySeeder::determineCategory($product);
            $catalog->product()->associate($product);
            /* 1 in 10 probability that we won;t create a catalog decription
                use product description in that case */
            if (rand(1, 10) != 6)
            {
                $catalog->description()->associate( $this->createDescription($faker));
            }
            $catalog->save();
        }
               
    }
    
    public function createDescription($faker)
    {
       $description = new Description();
       $description->description = $faker->text(mt_rand(200, 2000));
       $description->save();
       return $description;
    }

}

