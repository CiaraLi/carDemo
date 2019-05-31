<?php

namespace robot;

use cmd\voice as Voice;
use robot\chat as Chat;

/**
 * Description of control
 * 语音识别主模块
 * @author Ciara Li
 */
class main {

    private $voice; //活跃时间
    private $chat; //活跃时间
    private $wake_time; //唤醒时间
    private $stadby_time; //唤醒时间
    private $active_time; //活跃时间

    function __construct() {

        $this->voice = new Voice();
        $this->chat = new Chat();
    }

    /**
     * 获取互动时间
     */
    function getWakeTime() {
        return $this->stadby_time - $this->wake_time;
    }

    /**
     * 无操作1分钟进入待机
     * return bool  true:进入待机,false未进入待机
     */
    function standby() {
        if (60 < time() - $this->active_time) {
            $this->stadby_time = time();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 应答
     */
    function reply($txt) {
        $this->voice->play($txt);
        $this->active_time = time();
    }

    /**
     * 监听说话
     * @param type $param
     */
    function listen() {
        $this->voice->record();
        return $this->voice->check();
    }

    /**
     * 唤醒智能对话
     */
    function awake() {
        do {
            if (!$this->listen()) {
                continue;
            }
            //针对不同内容进行应答
            if ($this->voice->match("(你好|您好|hello)?.*(" . _ROBOT_NAME_ . ")")) {
                $this->reply('小主人我在呀');
            } elseif ($this->voice->match("再见")) {
                $this->reply('下次再聊');
            } elseif ($this->voice->match("几点了")) {
                $this->reply('现在是' . date('Y年m月d日 H点i分'));
            } else {
                $reply = $this->chat->reply($this->voice->info());
                if (!empty($reply)) {
                    $this->reply($reply);
                }
            }
        } while (!$this->standby());
        $this->reply('下次再聊');
    }

}
