<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
        $this->display();
	}

    public function do_login(){
        $user_name=I("user_name");
        $password=MD5(I("password"));
        $userM=D('user');
        $info=$userM->where(array('user_name' => $user_name, 'user_pwd' => $password))->find();
        if (empty($info)) {
            $this->error('用户名或密码错误',U('Login/index'));
        }else if($info['power'] == 0){
        	$this->error('该用户不是管理员',U('Login/index'));
        }else{
            session("auth_info",$info);
            $this->success('登录成功！',U('Main/index'));
        }
    }
    
    public function out(){
    	session('auth_info',null);
		session(null);
    	$this->error('退出成功',U('Login/index'));
    }
}
