<?php

/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/10
 * Time: 22:59
 */
class AysMysql
{
    /**
     * @var string
     */
    public $dbSource = "";
    public $dbConfig = [];

    public function __construct()
    {
        //new swoole_mysql;
        $this->dbSource = new Swoole\Mysql;

        $this->dbConfig = [
            'host' => '127.0.0.1',
            'port' => 3306,
            'user' => 'root',
            'password' => '123456',
            'database' => 'test',
            'charset' => 'utf8',
        ];
    }

    public function update()
    {

    }

    public function add()
    {

    }

    /**
     * mysql的执行逻辑
     * @param $id
     * @param $username
     * @return bool
     */
    public function execute($id, $username)
    {
        //connect
        $this->dbSource->connect($this->dbConfig, function ($db, $result) {
            echo "mysql-connect" . PHP_EOL;
            if ($result === false) {
                var_dump($db->connect_error);
            }

            $sql = "select * from test WHERE id=1";
            //query(add select update delete)
            $db->query($sql, function ($db, $result) {
                //select => 返回结果集 add update delete => bool
                if ($result === false) {
                    //todo
                } elseif ($result === true) {//add update delete
                    //todo
                } else {
                    var_dump($result);
                }
                $db->close();
            });
        });
        return true;
    }
}

// 异步场景解析流程-执行步骤
$obj = new AysMysql();
$flag = $obj->execute(1, 'singwa-11111');
var_dump($flag) . PHP_EOL;
echo "start" . PHP_EOL;

// 详情页 =》 mysql 阅读数 =》 mysql 文章 +1 （异步） =》页面数据呈现出来