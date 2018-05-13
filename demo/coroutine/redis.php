<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/13
 * Time: 12:04
 */


$http = new swoole_http_server('0.0.0.0', 9501);
$http->on('request', function ($request, $response) {
    //获取redis 里面的内容 ，然后输出到浏览器

    //协程只能在 onRequest,onReceive,onConnect这些的回调里面使用
    $redis = new Swoole\Coroutine\Redis();
    $redis->connect('127.0.0.1', 6379);
    $value = $redis->get($request->get['a']);

    //mysql

    //time=max（redis，mysql） io
    $response->header("Content-Type", "text/plain");
    $response->end($value);
});

$http->start();

/**
 * 1 redis io 时间
 * 2 mysql io 时间
 * redis+mysql 时间
 */