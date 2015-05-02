<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Catalog\Category;

class CategorySeeder extends Seeder {

    public static $categories = array(
        "Mask and Fins",
        "Wet Suits",
        "Dry Suits",
        "Regulators",
        "Buoyancy Compensators",
        "Tanks",
        "Lights",
        "Cameras"
    );
    public static $categoryCnt;

    public function run() {
         $faker = \Faker\Factory::create();
        foreach (self::$categories as $name)
        {
            $category = new Category();
            $category->name = $name;
            $category->description = $faker->text(mt_rand(100, 300));
            $category->save();
        }
    }
    
    public static function determineCategory($product) {
        return (($product->id) % self::$categoryCnt) + 1;
    }

}

// Init the static since it can't be done in the the declaration initializer;
CategorySeeder::$categoryCnt = count(CategorySeeder::$categories);
