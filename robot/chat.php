<?php

namespace robot;

use lib\Curl;

/**
 * Description of chat
 * 自动对话模块
 * @author Ciara Li
 */
class chat {

    /**
     * 机器人回复,通过图灵接口获取回复内容
     * @param type $info
     * @return type
     */
    function reply($info) {
        if(empty($info)){
            return '';
        }
        $reply = '';

        $curl = new Curl();
        $url = "http://www.tuling123.com/openapi/api/v2";
        $parm = [
            'perception'=>[
                'inputText'=>[
                    'text'=>$info
                ]
            ],
            'userInfo'=>[
                'apiKey'=>TULING_API_KEY,
                'userId'=>TULING_USER_ID
            ], 
        ];
        od($parm);
        $data = $curl->run($url, json_encode($parm));
        $data = json_decode($data, true);
        od($data);
        if(isset($data['results'][0])&&$data['results'][0]['resultType']=='text') {
            $reply=$data['results'][0]['values']['text'];
        }

        return $reply;
    }

    /**
     * 百度机器人对话
     * 发起http post请求(REST API), 并获取REST请求的结果
     * @param string $url
     * @param string $param
     * @return - http response body if succeeds, else false.
     */
    function request_post($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        // 初始化curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // post提交方式
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        // 运行curl
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
    /*

$token = '#####调用鉴权接口获取的token#####';
$url = 'https://aip.baidubce.com/rpc/2.0/unit/service/chat?access_token=' . $token;
$bodys = '{"log_id":"UNITTEST_10000","version":"2.0","service_id":"S10000","session_id":"","request":{"query":"你好","user_id":"88888"},"dialog_state":{"contexts":{"SYS_REMEMBERED_SKILLS":["1057"]}}}';
$res = request_post($url, $bodys);
var_dump($res); 
     */

}
