<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/13
 * Time: 10:32
 */
//多进程执行
echo "process-start-time:" . date('Y-m-d H:i:s') . PHP_EOL;
$workers = [];
$urls = [
    'http://www.baidu.com',
    'http://www.qq.com',
    'http://www.sina.com.cn',
];

//传统方法
/*foreach ($urls as $url){
    $contents[] = file_get_contents($url);
}*/

for ($i = 0; $i < count($urls); $i++) {
    //子进程
    $process = new swoole_process(function (swoole_process $worker) use ($i, $urls) {
        //curl
        $content = curlData($urls[$i]);
//        echo $content . PHP_EOL;
        $worker->write($content . PHP_EOL);
    }, true);
    $pid = $process->start();
    $workers[$pid] = $process;

}
//输出管道里面的内容
foreach ($workers as $process) {
    echo $process->read();
}

echo "process-end-time:" . date('Y-m-d H:i:s') . PHP_EOL;

/**
 * 模拟请求URL的内容
 * @param $url
 * @return string
 */
function curlData($url)
{
    // curl file_get_content
    sleep(1);
    return $url . "success" . PHP_EOL;
}