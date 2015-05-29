<?php
namespace Mweaver\Util;
class Url {
    public static function cleanPath($inString) {
        return str_replace([" ", ".", "&"], ["-"], $inString);
    }

}
