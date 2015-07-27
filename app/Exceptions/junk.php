<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class bar
{
    public $barvar;
}

class foo
{
    public $foovar;
}

if (isset($aVar))
    echo "$aVar";
else 
    echo "not set";

$aVar = new foo();
if (isset($aVar))
    echo "$aVar";
else
    echo "not set";
