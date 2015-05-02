<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Product\Image;
use Mweaver\Store\Product\Price;
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Category;
use Mweaver\Store\Catalog\Description;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        
        // Delete all the product and catalog releated table rows. Trunc is more efficant but so what
        Model::unguard();
        Price::whereRaw('id is not null')->delete();
        Image::whereRaw('id is not null')->delete();
        Category::whereRaw('id is not null')->delete();
        Catalog::whereRaw('id is not null')->delete();
        Product::whereRaw('id is not null')->delete();
        Description::whereRaw('id is not null')->delete();
        ImageHelper::deleteAllImageFilesAssociatedWithProducts();
           
        // In 5.4 we could use (new ProductSeeder)->run()
        echo "Deletes complete: Starting seed\n";
        $ps = (new ProductSeeder);
        $ps->run();
        exit();
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
