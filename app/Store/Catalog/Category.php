<?php

namespace Mweaver\Store\Catalog;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'catalog_category';
    
    public $timestamps = false;
}
