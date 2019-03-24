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

    $info = $voice->record();
    od($info);
    if ($voice->check("(你好|您好|hello).*(小幽)")) {
        $voice->say('你好!小主人!');
        $robot->listen();
    }
    $exit = true;
} while ($exit != true);

