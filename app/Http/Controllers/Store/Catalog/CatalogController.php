<?php
namespace Mweaver\Http\Controllers\Store\Catalog;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Mweaver\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function getIndex()
    {
        \Log::error("Entering getView");
        return "Start of catalog";
    }
}