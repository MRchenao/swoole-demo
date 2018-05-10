<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/10
 * Time: 22:40
 */
$content = date("Y-m-d H:i:s") . PHP_EOL;
swoole_async_writefile(__DIR__ . "/1.log", $content,
    function ($filename) {
        //todo
        echo "success:" . $filename . PHP_EOL;
    }
    , FILE_APPEND);

echo "start" . PHP_EOL;