<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/3
 * Time: 21:45
 */
$http = new swoole_http_server("0.0.0.0", 9501);

//静态资源访问设置，如果前端访问的是静态资源则不会走下面的onRequest事件
$http->set([
    'enable_static_handler' => true,
    'document_root' => "/dnmp/www/site1/thinkphp/public/static",
    //设置静态文件的根目录  http://47.106.133.191:9501/index.html
]);

$http->on('request', function ($request, $response) {
    $response->cookie('chendongdong', '最帅！', 120);
    $response->end("<h1>Hello Swoole. #" . rand(1000, 9999) . "</h1>" . json_encode($request->get));
});

$http->start();