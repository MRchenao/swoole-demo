<?php
/**
 * Created by PhpStorm.
 * User: chendongdong
 * Date: 2018/5/13
 * Time: 10:56
 */
//多进程数据共享使用
//创建内存表
$table = new swoole_table(1024);

//内存表增加三列
$table->column('id', $table::TYPE_INT, 4);
$table->column('name', $table::TYPE_STRING, 64);
$table->column('age', $table::TYPE_INT, 3);
$table->create();

$table->set('chendongdong', ['id' => 1, 'name' => 'chendongdong_test', 'age' => 30]);
//另一种赋值方式
$table['chendongdong_2'] = [
    'id' => 2,
    'name' => 'ssss',
    'age' => 31
];

//加2
$table->incr('chendongdong_2', 'age', 2);
//减2
$table->decr('chendongdong', 'age', 2);
//删除
//$table->del('chendongdong_2');

print_r($table->get('chendongdong'));
print_r($table['chendongdong_2']);