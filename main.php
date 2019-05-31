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
    od('待机中……');
    $info = $voice->record(); 
    if ($voice->match("(你好|您好|hello)?.*("._ROBOT_NAME_.")")) {
        $voice->play('小主人我在呀');
        $robot->awake();
        $time=$robot->getWakeTime();
        ot('本次互动'.($time/60).'分钟');
    }
//    $exit = true;
} while ($exit != true);

