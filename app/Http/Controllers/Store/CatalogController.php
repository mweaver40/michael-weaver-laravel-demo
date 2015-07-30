<?php

namespace Mweaver\Http\Controllers\Store;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TestController
 *
 * @author MIchael
 */
use Mweaver\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Request;
use Mweaver\Util\Time;
use Mweaver\Store\Catalog\Catalog;
use Mweaver\Store\Catalog\Category;
use Mweaver\Store\Product\Image;
use Mweaver\Store\Product\Price;

class CatalogController extends Controller {

    //put your code here
    public function getCatalogPage($categoryName = null) {

        $catalog = new Catalog();
        $now = Time::getDateTimeStr();
        $page = Request::input('page');
        $page = isset($page) ? $page : 1;
        $limit = Request::input('limit');
        $limit = isset($limit) ? $limit : 12;
        $offset = ($page - 1) * $limit;
        //$category = new Category();
        // todo! change the categories

        $categories = Category::orderBy('id')->get();
        $category = isset($categoryName) ? $this->getCategoryByName($categories, $categoryName) : $categories[0];
        $data['categories'] = $categories;
        $data['catalogItems'] = $catalog->getCatalogPage($now, 'thumb', $category->id, $offset, $limit);
        $data['totalItems'] = $catalog->getCatalogCategoryItemCnt($category->id, $now);
        $data['limit'] = $limit;
        $data['category'] = $category;
        $data['cartCnt'] = CartController::getCartCnt();
        return view('store.catalogPage', $data);
    }

    protected function getCategoryByName($categories, $name) {
        $result = $categories[0];
        foreach ($categories as $category) {
            if ($category->getAlias() == $name) {
                $result = $category;
                break;
            }
        }
        return $result;
    }

    public function getProductInfo($category, $productSegment) {
        $catalogIdPos = strrpos($productSegment, "-") + 1;
        $catalogId = substr($productSegment, $catalogIdPos);
        $catalog = Catalog::findOrFail($catalogId);
        $images = Image::getImagesByTypeMostImportanceOrdered($catalog->product_id, 'thumb');
        $price = Price::getEffectivePrice($catalog->product_id);
        // Not great idea here. Need to rethink. Get the most important image 
        // to dispaly. 
        // Use thumbnails for now since we don't have any better image
        $categories = Category::orderBy('id')->get();
        $category = isset($categoryName) ? $this->getCategoryByName($categories, $categoryName) : $categories[0];
        $data['categories'] = $categories;
        $cartCnt = CartController::getCartCnt();
        /* TODO: reconsider this, we look for a description associated with catalog and if 
         *  it is null we then go after the description associated with the product. 
         *  This may be overly complicated and unecessary. Maybe catalog should always 
         * have a description even if it is the same as the product description.
         */
        if ($catalog->description_id != null) {
            $description = $catalog->description->description;
        } else {
            $description = $catalog->product->description;
        }
        return view('store.productInfo', ['catalog' => $catalog, 'images' => $images,
            'price' => $price, 'categories' => $categories,
            'cartCnt' => $cartCnt, 'productDescription' => $description]);
    }

    public static function getCatalogPageBasicInformation() {
        $data = array();
        $categories = Category::orderBy('id')->get();
        $data['categories'] = $categories;
        $cartCnt = CartController::getCartCnt();
        $data['cartCnt'] = $cartCnt;
        return $data;
    }

}
