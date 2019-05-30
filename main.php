<?php

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
    ot($info);
    if ($voice->check("(你好|您好|hello)?.*("._ROBOT_NAME_.")")) {
        $voice->say('小主人我在呀');
        $robot->listen();
    }
//    $exit = true;
} while ($exit != true);

