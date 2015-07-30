<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Mweaver\Store\Product\Product;
use Mweaver\Store\Product\Image;

class ImageHelper extends Seeder {
    /* PHP can't handle complex init in the declartation, see bottom 
     * of this file for workaround
     */

    
    public static $srcDir;
    public static $destDir;
    public static $imagesPerCategory = 5;
    public static $imageLookup;

    public function run() {
        self::createImageFilesForProducts();
    }
    /**
     * Not strictly speaking part of DB creation but easiset to do it here 
     */
    public static function deleteAllImageFilesAssociatedWithProducts() {

        $imageFiles = scandir(self::$destDir, SCANDIR_SORT_ASCENDING);
        foreach ($imageFiles as $imageFile) {
            if ($imageFile == '.' || $imageFile == '..')
                continue;
            $file = self::$destDir . '\\' . $imageFile;
            if (is_dir($file))
                continue;
            //echo "$imageFile";
            unlink($file);
        }
    }

    /**
     * 
     * @return associative array of image keys and imageFileNames;
     * Really doing this just to mix image types like jpg and png
     */
    public static function getImageKeyArrary() {
        $images = array();
        $imageFiles = scandir(self::$srcDir, SCANDIR_SORT_ASCENDING);


        foreach ($imageFiles as $imageFile) {
            if (($pos = strpos($imageFile, ".")) !== FALSE) {
                if ($imageFile == '.' || $imageFile == '..')
                    continue;
                $key = substr($imageFile, 0, $pos);
                $images[$key] = $imageFile;
                //echo"imageFile = $imageFile key = $key\n";
            }
        }
        return $images;
    }

    /**
     * 
     * @param type $product
     * @param type $importance Importance is only used to create acopy of an 
     *   image under a different name, Allows for mutiple image files per product 
     *   with actually only one image. 
     */
    public static function createImageFileForProduct($product, $importance) {
        $category = CategorySeeder::determineCategory($product);
        $imageKey = $category . "_" . mt_rand(1, self::$imagesPerCategory);
        $src = self::$imageLookup[$imageKey];
        copy(self::$srcDir . "\\$src", self::$destDir . "\\" . $product->id . $importance . strstr($src, '.'));
    }

    public static function createImageFilesForProducts() {
        $product = new Product();
        $products = $product->whereRaw("end is null")->get();
        
        foreach ($products as $product) {
            $category = CategorySeeder::determineCategory($product);
            $images = $product->images;
            $offSet = CategorySeeder::determineCategoryOffset($product);
            $imageKey = $offSet . "_" . mt_rand(1, self::$imagesPerCategory);
            $src = self::$imageLookup[$imageKey];
            foreach ($images as $image) {
                symlink(self::$srcDir . "/$src", self::$destDir . "/" . $image->name);              
            }
        }
    }
}


ImageHelper::$destDir = __DIR__ . "/../../public/images/store/products/small";
ImageHelper::$srcDir = ImageHelper::$destDir . "/master";
ImageHelper::$imageLookup = ImageHelper::getImageKeyArrary();
