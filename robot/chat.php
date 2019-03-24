<?php

namespace robot;

use lib\Curl;

/**
 * Description of chat
 * 自动对话模块
 * @author Ciara Li
 */
class chat {

    //put your code here
    function reply($info) {
        $reply = '';

        $curl = new Curl();
        $url = "http://www.tuling123.com/openapi/api";
        $parm = [
            "key" => Tuling_API_KEY, "info" => $info
        ];
        $data = $curl->run($url, $parm);
        $data = json_decode($data, true);
        $reply = empty($data['text']) ? '' : $data['text'];

        return $reply;
    }

}
