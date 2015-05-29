<?php

namespace Mweaver\Util;
use DateTime;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Time
 *
 * @author MIchael
 */
class Time {
    public static function getDateTimeStr($inTime = null) {
        if (!isset($inTime) || $inTime == null)
            $inTime = new DateTime();
        return $inTime->format('Y-m-d H:i:s');
    }
}
