<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/10
 * Time: 22:26
 */
/**
 * 异步读取文件
 * __DIR__
 */
$result = swoole_async_readfile(__DIR__ . "/1.txt", function ($filename, $fileContent) {
    echo "filename:" . $filename . PHP_EOL;//根据不同的操作系统使用换行符 /n /r/n
    echo "fileContent:" . $fileContent . PHP_EOL;
});


var_dump($result);
echo "start" . PHP_EOL;