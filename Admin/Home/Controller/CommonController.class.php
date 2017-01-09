<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{
	public function _initialize(){
		if(!session('?auth_info')){
			$this->error('请先登陆',U('Login/index'));
		}
	}
	
    function _empty(){ 
          header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
          $this->display("Public:404"); 
     } 
}