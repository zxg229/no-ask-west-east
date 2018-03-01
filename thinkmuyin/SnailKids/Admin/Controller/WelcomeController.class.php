<?php
namespace Admin\Controller;
use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class WelcomeController extends Controller
{
    public function welcome(){

        $this->assign('md5', md5('68730172``~~'));
        $this->assign('time', time());
        $this->display();
    }
}