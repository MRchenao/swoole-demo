<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/3
 * Time: 23:00
 */
$server = new swoole_websocket_server("0.0.0.0", 9501);

//$server->set([]);//参见配置选项
$server->set([
    'enable_static_handler' => true,
    'document_root' => "/dnmp/www/site1/demo/html",//设置静态文件的根目录  http://47.106.133.191:9501/index.html
]);


// 监听websocket连接打开事件
$server->on('open', function (swoole_websocket_server $server, $request) {
    echo "server: handshake success with fd{$request->fd}\n";
});

// 监听websocker的消息事件
$server->on('message', function (swoole_websocket_server $server, $frame) {
    echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
    $server->push($frame->fd, "this is server");
});

$server->on('close', function ($ser, $fd) {
    echo "client {$fd} closed\n";
});

$server->start();