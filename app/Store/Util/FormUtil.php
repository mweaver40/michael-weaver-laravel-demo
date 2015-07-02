<?php
namespace Mweaver\Store\Util;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use \Input;
/**
 * Description of FormUtil
 *
 * @author MIchael
 */
class FormUtil{

    // other functions

    public static function oldRadio($name, $value, $default = false) {
        if(empty($name) || empty($value) || !is_bool($default))
            return '';

        if(null !== Input::old($name)) {
            if(Input::old($name) == $value) {
                return 'checked';
            } else {
                return '';
            }
        } else {
            if($default) {
                return 'checked';
            } else {
                return '';
            }
        }
    }
}
