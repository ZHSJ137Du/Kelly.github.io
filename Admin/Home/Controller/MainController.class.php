<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/12/30
 * Time: 22:20
 */

namespace Home\Controller;
use Think\Controller;

class MainController extends Controller{

    public function index(){
        $this -> display();
    }

}