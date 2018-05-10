<?php

/**
 * ws 优化 基础类库
 * User: chendongdong
 * Date: 2018/5/8
 * Time: 21:53
 */
class Ws
{
    const HOST = "0.0.0.0";
    const PORT = 9501;

    public $ws = null;

    public function __construct()
    {
        $this->ws = new swoole_websocket_server(self::HOST, self::PORT);

        $this->ws->set([
            'worker_num' => 2,
            'task_worker_num' => 2,
        ]);

        // 异步回调函数的另一种写法
        $this->ws->on('open', [$this, 'onOpen']);
        $this->ws->on('message', [$this, 'onMessage']);
        $this->ws->on('task', [$this, 'onTask']);
        $this->ws->on('finish', [$this, 'onFinish']);
        $this->ws->on('close', [$this, 'onClose']);

        $this->ws->start();
    }

    /**
     * 监听ws连接事件
     * @param $ws
     * @param $request
     */
    public function onOpen($ws, $request)
    {
        var_dump($request->fd);
        //定时器场景处理
        if ($request->fd == 1) {
            //当客户端id等于1的时候，每2s执行一次
            swoole_timer_tick(2000, function ($timer_id) {
                echo "2s: timerId:{$timer_id}\n";
            });
        }

    }

    /**
     * 监听ws消息事件
     * @param $ws
     * @param $frame
     */
    public function onMessage($ws, $frame)
    {
        echo "ser-push-message:{$frame->data}\n";

        //todo 6s
        $data = [
            'task' => 1,
            'fd' => $frame->fd
        ];
        $ws->task($data);

        //5s之后执行
        swoole_timer_after(5000, function () use ($ws, $frame) {
            echo "5s-after\n";
            $ws->push($frame->fd, "server-time-after:");
        });

        $ws->push($frame->fd, "server-push:" . date('Y-m-d H:i:s'));
    }

    /**
     * 耗时任务开始
     * @param $serv
     * @param $taskId
     * @param $workerId
     * @param $data
     * @return string
     */
    public function onTask($serv, $taskId, $workerId, $data)
    {
        print_r($data);
        //耗时场景
        sleep(6);
        return "on task finish";// 告诉worker
    }

    /**
     * 耗时任务结束
     * @param $serv
     * @param $taskId
     * @param $data
     */
    public function onFinish($serv, $taskId, $data)
    {
        echo "taskId:{$taskId}\n";
        echo "finish-data-success:{$data}\n";//这里的$data为上面的onTask的返回值：on task finish
    }

    /**
     * close
     * @param $ws
     * @param $fd
     */
    public function onClose($ws, $fd)
    {
        echo "clientid:{$fd}\n";
    }

}

$obj = new Ws();