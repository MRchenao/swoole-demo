<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/12
 * Time: 21:07
 */
$redisClient = new swoole_redis;//Swoole\Redis
$redisClient->connect('127.0.0.1', 6379,
    function (swoole_redis $redisClient, $result) {
        echo "connect" . PHP_EOL;
        var_dump($result);

        //同步 redis （new Redis()）->set('key',2);下面的异步的执行场景
        $redisClient->set('chendongdong_1', time(),
            function (swoole_redis $redisClient, $result) {
                var_dump($result);
            });

        //获取某个key的值
        $redisClient->get('chendongdong_1',
            function (swoole_redis $redisClient, $result) {
                var_dump($result);
            });

        //获取所有的键
        $redisClient->keys('*',
            function (swoole_redis $redisClient, $result) {
                var_dump($result);
            });

        $redisClient->close();
    });

echo "start" . PHP_EOL;