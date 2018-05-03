<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/3
 * Time: 21:17
 */
//连接 swoole tcp 服务
$client = new swoole_client(SWOOLE_SOCK_UDP);
if (!$client->connect('127.0.0.1', 9502)) {
    echo "连接失败";
    exit;
}

//php cli 常量
fwrite(STDOUT, '请输入消息：');
$msg = trim(fgets(STDIN));

// 发送消息给 udp server服务器
$client->sendto('127.0.0.1', 9502, $msg);

// 接受来自server的数据
$result = $client->recv();
echo $result;