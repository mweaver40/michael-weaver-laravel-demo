<?php
namespace Mweaver\Store\Catalog;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Rturns a we compatable alias that replaces spaces with - char
 */
trait WebModelTrait {
   
    public function getAlias() {
            return str_replace(" ", "-", $this->name);   
    }
}