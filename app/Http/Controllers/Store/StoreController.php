<?php namespace Mweaver\Http\Controllers\Store;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Mweaver\Http\Controllers\Controller;
use Mweaver\Store\Order\Order;
use Mweaver\Store\Catalog\Category;
use Cookie;
use Illuminate\Support\Facades\URL;
 
const CART_COOKIE = 'scubaCart';



class StoreController extends Controller
{
    // TODO: OK Nnot fond of this but we don't want to deal with the issues around 
    // session storage of a dynamic redirect path which is what Laravel does. Add this
    // as an improvement on the todo list.
    public $redirectTo ;
   
    public function __construct()
    {
        $this->redirectTo = URL::route('storeMain');
    }
    
     /**
     * 
     * @param type $cart
     * @return int
     * Return the number of items in a pending order. All other orderss return 0
     *      
     */
    public function getCartCnt($cart = null) {
        if (!isset($cart)) {
            $cart = Cookie::get(CART_COOKIE);
            if (!isset($cart)) {
                return 0;
            }
        }
        return Order::getItemCntByState($cart, Order::PENDING);
    }
    
    
     public function getCatalogPageBasicInformation() {
        $data = array();
        $categories = Category::orderBy('id')->get();
        $data['categories'] = $categories;
        $cartCnt = $this->getCartCnt();
        $data['cartCnt'] = $cartCnt;
        return $data;
    }
    
}