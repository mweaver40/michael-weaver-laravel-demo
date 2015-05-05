<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Catalog\Category;

class CategorySeeder extends Seeder {

    public static $categories = array(
        "Wet Suits",
        "Dry Suits",
        "Regulators",
        "Buoyancy Compensators",
        "Tanks",
        "Lights",
        "Cameras",
        "Mask and Fins"

    );
    public static $categoryCnt;
    public static $firstCategory = null;
   
    
    public function run() {
         $faker = \Faker\Factory::create();
        foreach (self::$categories as $name)
        {
             $first = 'null';
            $category = new Category();
            $category->name = $name;
            $category->description = $faker->text(mt_rand(100, 300));
            $category->save();
            if (self::$firstCategory == null)
            {
                self::$firstCategory = $category->id;
            }
        }
    }
    
    public static function determineCategory($product) {
        return (($product->id) % self::$categoryCnt) + self::$firstCategory - 1;
    }
    
    public static function  determineCategoryOffset($product)
    {
        return (($product->id - 1) % self::$categoryCnt) + 1;
    }

   
}

// Init the static since it can't be done in the the declaration initializer;
CategorySeeder::$categoryCnt = count(CategorySeeder::$categories);
