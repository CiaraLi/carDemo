<?php

define("_OPENDEBUG_", true);

require_once 'autoload.php';

use robot\main as Robot;
use cmd\voice as Voice;

/**
 * Description of main
 * 主程序
 * @author CiaraLi
 */
$exit = false;

$robot = new Robot();
$voice = new Voice();
do {

    od('.');
    $info = $voice->record();
    od($info);
    if('你好小幽'==$info){
        $robot->listen();
    } 
    $exit=true;
} while ($exit != true);

