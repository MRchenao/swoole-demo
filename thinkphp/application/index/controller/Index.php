<?php

namespace app\index\controller;
class Index
{
    public function index()
    {
        echo 'asfdsas';
    }

    public function singwa()
    {
        echo 'sdfsaf' . time();
    }

    public function hello($name = 'ThinkPHP5')
    {
        echo 'hessdggsg' . $name . time();
    }

}
