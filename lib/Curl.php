<?php

namespace lib;

class Curl {

    protected $ch;
    protected $timeout = 5;
    static $instance;

    function run($url, $data, $json = true) {
        try {
            $this->ch = curl_init();
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
            if ($json) {
                $headers['Content-Type'] = 'application/json';
                curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
            }
            curl_setopt($this->ch, CURLOPT_URL, $url);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($this->ch, CURLOPT_POST, true);
            curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);

            $file_content = curl_exec($this->ch);
            curl_close($this->ch);
            RETURN $file_content;
        } catch (Exception $e) {
            ot('请求失败');
            od([$url, $data, $e]);
            return '';
        }
    }

    function sendStreamFile($url, $file) {
        if (empty($url) || empty($file)) {
            return false;
        }
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/x-www-form-urlencoded',
                'content' => $file
            )
        );
        $context = stream_context_create($opts);
        $response = file_get_contents($url, false, $context);
        return $response;
    }

    function saveFile($url, $file) {
        if (!file_exists($file)) {
 
            //获取语语音数据 并生成 本地mp3文件
            $data = file_get_contents($url);

            if (json_decode($data,true)) {
                return false;
            }

            file_put_contents($file, $data);
        }

        if ($file) {
            return $file; //返回本地音源路径 
        }
    }

}
