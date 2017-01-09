<?php
namespace Home\Controller;
use Think\Controller;
header("content-type:text/html;charset=utf-8");
class UserController extends Controller {
	// Author: 张芳
	// Date:2017-1-7
	//显示用户设置
    public function index(){
			//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		
		
		// 判断session
		if($_SESSION){
			$this->assign("lo",$_SESSION);
		}else{
			$this->assign("lo",'');
		}
		
		$this -> assign("configs",$configs);
					
			$user = M("user");
			
			
			if($user->where("id={$_GET['id']}")->find()){
				$data['id']=$_GET['id'];
			}else{
				$user->add($_GET);
				$data['id']=$_GET['id'];
			}
			
			$data1=$user->where("id={$data['id']}")->find();
			$this -> assign("data",$data1);
			$this -> assign("configs",$configs);
			$this -> display();
		}
		
		// Author: 张芳
		// Date:2017-1-7
		//修改用户设置
		public function mol(){	
			// 修改的时候才会调用此方法
						
			$user = M("user");
			// 修改信息然后更新数据库
			if($_POST['id']){
				$d2=$_POST['id'];
				$d['user_name']=$_POST['user_name'];
				$_SESSION['user_name']=$_POST['user_name'];
				
				$d['phone']=$_POST['phone'];
				$d['email']=$_POST['email'];
				$d['power']=$_POST['power'];
				$user->where("id={$d2}")->save($d);
				
				
				// 判断是否上传文件
				if($_FILES['pic']['name']){
					$da['user_icon']=$this->upload();
					$user->where("id={$_POST['id']}")->save($da);
					$_SESSION['pic']=$da['user_icon'];
				}
			}
			$this->redirect("User/personal");
		}
		
		// Author: 莫文诺
		// Date:2017-1-7
		// 查看个人信息personal
		public function personal(){
		//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		
		
		// 判断session
		if($_SESSION){
			$this->assign("lo",$_SESSION);
		}else{
			$this->assign("lo",'');
		}
		
		$this -> assign("configs",$configs);
			
			
			$user = M("user");
			
			
			
			if(!$_SESSION['id']){
				$this->redirect("index/index");
			}
			$id = $_SESSION['id'];
			$data = $user -> find($id);
			$this -> assign("data",$data);
			$this -> assign("configs",$configs);
			$this -> display();
		}
		
		// Author: 张芳
		// Date:2017-1-7
		// 上传图片
		private function upload(){
			$config = array(
				"maxSize" => 10240000,	
				"exts" => array("jpg","jpeg","png","gif","bmp"),
				"rootPath" => "./Public/Home/Upload/"
				);
			$upload = new \Think\Upload($config);
			$info = $upload -> uploadOne($_FILES['pic']);
			if($info){
				$data = $info['savepath'].$info['savename'];
				return $data;
			}else{
				$data = $info['savepath'].$info['savename'];
				return $data;
			}	
		}
}