<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Product\Image;
use Mweaver\Store\Product\Price;
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Category;
use Mweaver\Store\Catalog\Description;
use Mweaver\Store\Order\ItemOrdered;
use Mweaver\Store\Order\Order;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public static $recordsToSeed = 500;
    
    public function run() {
        
        /*
        $now = new DateTime();
        $nowStr = $now->format('Y-m-d H:i:s');
        $catalogModel = new Catalog();
        $catalogs = $catalogModel->whereRaw(' end is null and effective < ? ', [$nowStr]);
        
        ProductDrivenSeeder::populateTableFromDrivingTable($catalogs, 'description', 
                200, $nowStr, \Faker\Factory::create(),
                function (&$row, &$inserts, $now, &$faker) {
                    echo($row->id);
                    $description = $faker->text(mt_rand(200, 2000));
                    $inserts[] = ['description' => $description];
                });
    exit();
        */

        // Delete all the product and catalog releated table rows. Trunc is more efficant but so what
        Model::unguard();
        
        // Category must go first since other code uses the category
        Category::whereRaw('id is not null')->delete();
        ItemOrdered::whereRaw('id is not null')->delete();
        Order::whereRaw('id is not null')->delete();
        Price::whereRaw('id is not null')->delete(); 
        Image::whereRaw('id is not null')->delete();     
        Catalog::whereRaw('id is not null')->delete();      
        Product::whereRaw('id is not null')->delete();
        Description::whereRaw('id is not null')->delete();
        ImageHelper::deleteAllImageFilesAssociatedWithProducts();
        
           
        // In 5.4 we could use (new ProductSeeder)->run()
        echo "Deletes complete: Starting seed\n";
        $ps = (new ProductSeeder);
        $ps->run();
        echo "Product seeded\n";
        $cg = new CategorySeeder();
        $cg->run();
        echo "Category seeded\n";
        $ct = new CatalogSeeder();
        $ct->run();
        echo "Catalog Seeded\n";
        $pr = new PriceSeeder();
        $pr->run();
        echo "Price Seeded\n";
        ImageHelper::createImageFilesForProducts() ;
        echo "Image files created\n";
    }

}
