<?php

namespace robot;

use lib\Curl;

/**
 * Description of translate
 * 语音识别-音频转换模块
 * @author Ciara Li
 */
class translate {

    private $token;

    function __construct() {
        $this->setToken();
    }

    private function setToken() {
        $curl = new Curl();
        $url = "https://openapi.baidu.com/oauth/2.0/token";
        $parm = [
            'grant_type' => 'client_credentials',
            'client_id' => BAIDU_CLIENT_ID,
            'client_secret' => BAIDU_CLIENT_SECRET,
        ];
        $data = $curl->run($url, $parm);
        $data = json_decode($data, true);
        $this->token = empty($data['access_token']) ? '' : $data['access_token'];
    }

    //put your code here
    function transVoice($file) {
        try {
            $content = false;
            if (is_file($file)) {
                $content = file_get_contents($file);
                $content = base64_encode($content);
            }
            if ($content) {

                $curl = new Curl();
                $url = "http://vop.baidu.com/server_api";
                $parm = [
                    'format' => 'wav',
                    'rate' => 16000,
                    'channel' => 1,
                    'cuid' => BAIDU_YUYIN_CUID,
                    'token' => $this->token,
                    'speech' => $content,
                    'len' => filesize($file)
                ];
//		od($parm);
                ot('正在识别...');
                $data = $curl->run($url, json_encode($parm));
                $data = json_decode($data, true);
                if (!empty($data['result']) && $data['err_no'] == 0) {
                    return $data['result'][0];
                }
                od($data);
            }
            ot('识别失败');
        } catch (Exception $e) {
            ot('识别失败');
            od($e);
        }
        return '';
    }

    function transTxt($txt) {
        $cuid = "b8:27:eb:35:73:e4";
        $spd = "4";
        $url = "http://tsn.baidu.com/text2audio?lan=zh&ie=UTF-8&tex=" . urlencode($txt) . "&cuid={$cuid}" .
                "&ctp=1&tok={$this->token}&spd={$spd}&per=0&pit=8";
//        od($url);
        $ch = new Curl();
        $file = "/tmp/carDemo/".  md5($txt).".mp3";
        $filename=$ch->saveFile($url, $file);
        return $filename?$filename:false;
    }

}
