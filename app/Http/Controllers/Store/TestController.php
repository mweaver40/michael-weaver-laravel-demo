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

class TestController extends Controller {
    //put your code here
    public function getDoit($name = null)
    {
    $input = Request::all();
    //var_dump($input);
    return view('store.test_1');
    }
}