<?php

namespace Mweaver\Store;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Address extends Model {
    
  
    
  
    protected $table = 'address';
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('Mweaver\User');
    }
}
