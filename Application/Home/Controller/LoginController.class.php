<?php
namespace Home\Controller;
use Think\Controller;

//控制登录和注册相关功能
class LoginController extends Controller {

	//操作名称
    public function index(){
		//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		
	
		$this -> assign("configs",$configs);
        $this->display();
    
    }
	// Author: 马得中
	// Date:2017-1-7
    //处理登录的请求
    public function do_login()
    {
        // 第一步：校验，验证码
        // 会话进行验证码操作
        $Verify = new \Think\Verify();
           
        if (!$Verify->check(I('verify_code'))) {

              $this->error('验证码错误！',U('Login/index'));
           }
        // 第二步：校验用户名和密码是否匹配
        $user_name=I("user_name");
        $password=MD5(I("password"));
        //?
        $userM=D('user');
        $info=$userM->where("user_name='$user_name' and user_pwd='$password'")->find();
       
      

       if (empty($info)) {
           $this->error('用户名或密码错误',U('Login/index'));
       }else{
		
         // session怎么保存信息？
        session("auth_info",$info);
		 $_SESSION['id'] = $info['id'];
		 $_SESSION['pic'] = $info['pic'];
        $this->success('登录成功！',U('Index/index'));
       }
    }

    //注册操作模块
    public function register()
    {
		//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		
		
		$this -> assign("configs",$configs);
    	 $this->display();
    }

	// Author: 黄汉杰
	// Date:2017-1-7
    //保存用户信息
    public function save_info()
    {
    	//定义了一个数组，用来保存表单传过来的数据信息
    	$data['user_name']=I('user_name');//input
    	$data['user_pwd']=I('password');
    	$data['password_two']=I('password_two');
		$data['user_icon']='default.jpg';

    	$data['create_time']=time();
    	//怎么和数据库
    	$userM=D('user');
    	// 校验
    	$data=$userM->create($data);

    	$data['user_pwd']=md5($data['user_pwd']);
    	if (!$data) {//非
    		echo $userM->getError();
    	}else{
    		$userM->add($data);
    		$this->success('数据保存成功！',U('Index/index'));
    	}
    	
    	
    }

	// Author: 马得中
	// Date:2017-1-7
      // 单独出来验证码
    public function get_verify()
    {
      $Verify = new \Think\Verify();
      $Verify->useCurve=false;
      $Verify->useNoise=false;

       $Verify->entry();
    } 


	// Author: 黄汉杰
	// Date:2017-1-7
    public function logout()
    {
        //怎么做？
        //判断用户登录情况，根据session
        //注销掉,把session会话给清除掉？
        session('auth_info',null);
		 $_SESSION['id']=null;
		$_SESSION['user']=null;
        $this->success('退出成功！',U('Login/index'));
    }
}