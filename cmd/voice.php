<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace cmd;

use robot\translate as Trans;

/**
 * Description of cmd
 *
 * @author Ciara Li
 */
class voice {

    private $tmpdir;
    private $tmpfile;
    private $trans;
    private $info;

    function __construct() {
        $this->tmpdir = "/tmp/carDemo/";
        $this->tmpfile = 'tmp.wav';
        $this->trans = new Trans();
    }

    //put your code here
    function record() {
        exec('sudo arecord -D "plughw:0" -f S16_LE -r 16000 -d 3 ' . $this->tmpdir . $this->tmpfile);
        usleep(30000);

        $this->info = $this->trans->transVoice($this->tmpdir . $this->tmpfile);
        return trim($this->info);
    }

    function say($txt) {
        $url = $this->trans->transVoice($this->tmpdir . $this->tmpfile);
        exec('mpg123 "' . $url . '"');
    }

    function check($check) {
        return preg_match("/$check/iSU", $this->info);
    }

}
