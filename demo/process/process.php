<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/12
 * Time: 21:34
 */
/**
 * $redirect_stdin_stdout，重定向子进程的标准输入和输出。启用此选项后，
 * 在子进程内输出内容将不是打印屏幕，而是写入到主进程管道。
 * 读取键盘输入将变为从管道中读取数据。默认为阻塞读取。
 * true 不输出111，改为false后输出111
 */
$process = new swoole_process(function (swoole_process $process) {
    //todo
    echo 111;
    // php http_server.php
    $process->exec("/usr/bin/php", [__DIR__ . '/../server/http_server.php']);
}, false);

//主进程查看 ps -aux|grep process.php
//子进程 pstree -p 主进程号
$pid = $process->start();
echo $pid . PHP_EOL;

//回收子进程
swoole_process::wait();