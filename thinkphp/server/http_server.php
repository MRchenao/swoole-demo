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
    'worker_num' => 5,
    'enable_static_handler' => true,
    'document_root' => "/dnmp/www/site1/thinkphp/public/static",
    //设置静态文件的根目录  http://47.106.133.191:9501/index.html
]);

$http->on('WorkerStart', function (swoole_server $server, $worker_id) {
    // 定义应用目录
    define('APP_PATH', __DIR__ . '/../application/');
    // 加载基础文件
    require __DIR__ . '/../thinkphp/base.php';
});

$http->on('request', function ($request, $response) use ($http) {
    $_SERVER = [];
    if (isset($request->server)) {
        foreach ($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if (isset($request->header)) {
        foreach ($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    $_GET = [];
    if (isset($request->get)) {
        foreach ($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }
    $_POST = [];
    if (isset($request->post)) {
        foreach ($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }

    ob_start();
    // 执行应用并响应
    try {
        \think\Container::get('app', [defined('APP_PATH') ? APP_PATH : ''])
            ->run()
            ->send();
    } catch (\Exception $e) {
        //todo
    }
//    echo "-action-" . request()->action() . PHP_EOL;
    $res = ob_get_contents();
    ob_end_clean();
    $response->end($res);
//    $http->close();
});

$http->start();