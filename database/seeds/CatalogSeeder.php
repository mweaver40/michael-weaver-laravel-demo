<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Description;

class CatalogSeeder extends DrivenSeeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Model::unguard();
        $faker = \Faker\Factory::create();
        $now = new DateTime();
        $effStr = $now->format('Y-m-d H:i:s');
        $inserts = array();
        for ($i = 1; $i <= DatabaseSeeder::$recordsToSeed; $i++) {

            $description = $faker->text(mt_rand(200, 2000));
            $inserts[] = ['description' => $description];
            if ($i % 100 == 0) {
                DB::table('description')->insert($inserts);
                $inserts = array();
            }
        }

        DB::table('description')->insert($inserts);

        $descriptionIds = DB::table('description')->selectRaw('id')->orderByRaw('id desc')->get();


        $this->populateCatalog($descriptionIds, $effStr, $faker);
    }

    protected function populateCatalog($descriptionIds, $now, $faker) {
        $productModel = new Product();
        $productBuilder = $productModel->active($now);
        array_reverse($descriptionIds);
        $data = ['faker' => $faker, 'now' => $now, 'ids' => $descriptionIds];
        
        
        $this->populateTableFromDrivingTable($productBuilder, 'catalog', 100, $data, 
                function (&$product, &$catalogs, &$data) {

            $now = $data['now'];
            $product_id = $product->id;
            $faker = $data['faker'];         
            $description_id = array_pop($data['ids'])->id;
            // One in 10 descriptions empty
            if ($product_id % 10 == 0)
                $description_id = null;
            //echo "description id = " . $description_id;
            $name = $faker->text(mt_rand(15, 30));
            $category_id = CategorySeeder::determineCategory($product);
            $catalogs[] = ['name' => $name, 
                'product_id' => $product_id, 'effective' => $now,
                'category_id' => $category_id, 'description_id' => $description_id];
        });
       
    }

   
}
