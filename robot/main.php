<?php

namespace robot;

use cmd\voice as Voice;
use robot\chat as Chat;

/**
 * Description of control
 * 语音识别控制模块
 * @author Ciara Li
 */
class main {

    //put your code here
    function listen() {
        $exit = false;

        $voice = new Voice();
        $chat = new Chat();
        $err = 0;
        do {

            od('.');
            $info = $voice->record();
            od($info);
            if (strpos('你好小幽', $info) !== false) {
                $err = 0;
                $voice->say('你好!小主人!');
            } elseif ('再见' == $info) {
                $err = 0;
                $voice->say('下次再聊');
                $exit = true;
            }elseif (strpos('几点了', $info) !== false) {
                $err = 0;
                $voice->say('现在是'.date('Y').'年'.date('m').'月'.date('d').'日'.
                        date('H').'点'.date('i').'分');
                $exit = true;
            } elseif (empty($info)) {
                $err++;
                if ($err >= 5) {
                    $voice->say('下次再聊');
                    $exit = true;
                }
            } else {
                $err = 0;
                $reply = $chat->reply($info);
                $voice->say($reply);
            }
        } while ($exit != true);
    }

}
