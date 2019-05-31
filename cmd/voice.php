<?php

/*
 * 处理录音,音频播放操作
 */

namespace cmd;

use robot\translate as Trans;

/**
 * 声音控制模块
 *
 * @author Ciara Li
 */
class voice {

    /**
     * 音频
     * @var type 
     */
    private $tmpdir;
    private $tmpfile;
    private $trans;
    private $info;

    /**
     * 构造函数:
     * 设置临时音频存放路径
     */
    function __construct() {
        $this->tmpdir = "/tmp/carDemo/";
        $this->tmpfile = 'tmp.wav';
        $this->trans = new Trans();
        if (!file_exists($this->tmpdir . $this->tmpfile)) {
            is_dir($this->tmpdir) ? '' : mkdir($this->tmpdir, '0777', true);
            file_put_contents($this->tmpdir . $this->tmpfile, "");
        }
    }

    /**
     * 开始录音 4秒
     * @return string 转化后的音频文本
     */
    function record() {

        ot('请讲话');
        usleep(3000);
        exec('sudo arecord -D "plughw:' . intval(_ARECORD_DEVICE_) . '" -f S16_LE -r 16000 -d 4 ' . $this->tmpdir . $this->tmpfile);
        usleep(4000);

        $this->info = $this->trans->transVoice($this->tmpdir . $this->tmpfile);

        od($this->info);
        return trim($this->info);
    }

    /**
     * 返回录音结果 
     * @return bool 匹配结果
     */
    function info() {
        return ($this->info);
    }

    /**
     * 录音结果 
     * @return bool 匹配结果
     */
    function check() {
        return empty($this->info);
    }

    /**
     * 匹配录音内容
     * @param string $check  正则表达式
     * @param array $matchs  匹配结果
     * @return bool 匹配结果
     */
    function match($check, &$matchs = []) {
        return  preg_match("/$check/iSU", $this->info, $matchs); 
    }

    /**
     * 播放音频 
     * @param string $txt 音频文件全路径或url地址
     */
    function play($txt) {
        $url = $this->trans->transTxt($txt);
        $url ? exec('mpg123 ' . $url) : FALSE;
    }

}
