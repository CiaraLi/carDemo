<?php

loadDir(__DIR__);

function loadDir($path, $root = true) {
    $dh = opendir($path);

    if ($dh) {
        while (($file = readdir($dh)) !== false) {
            $tmp = $path . '/' . $file;
//            ot('findfile:' . $tmp);
            if (!$root && preg_match("/[.]php$/i", $file) && is_file($tmp)) {
                require_once $tmp;
//                ot('ok!');
            } elseif ($file != '.' && $file != '..' && is_dir($tmp)) {
                loadDir($tmp, FALSE);
            }
        }
        closedir($dh);
    }
}

function od($str) {
    if (_OPENDEBUG_) {
        echo "----[debug]" . date('Y-m-d H:i:s') . "----\r\n";
        var_dump($str);
    }
}

function ot($str) {
    echo "[提示]" . date('Y-m-d H:i:s') . "\r\n";
    var_dump($str);
}
