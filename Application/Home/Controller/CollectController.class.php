<?php
namespace Home\Controller;
use Think\Controller;

class CollectController extends Controller {
	// Author: 林进雄
	// Date:2017-1-7
	//分页显示我的收藏
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
		
		$userId=$_SESSION['id'];
		$course = M("course");
		$map['course_name'] = array("LIKE","%{$_GET['course_name']}%");
		//$map['status'] = 1;
		$count = $course -> where($map) -> count();
		$Page = new \Think\Page($count,6);
		$show  = $Page  ->show();
		$courses = $course -> join('user_course uc ON uc.course_id=course.id') ->where($map) -> where("uc.user_id={$userId}")-> order("id DESC") -> limit($Page->firstRow.','.$Page -> listRows) -> select();
		 foreach($courses as &$i){		
			$i['create_time'] = date('Y-m-d H:i:s',$i['create_time']);
		 }
		 
		$num = ($Page -> nowPage -1)*($Page ->listRows) +1;
		$this -> assign("num",$num);
		 //dump($infos);
		
		$this ->assign("page",$show);
		
		$this -> assign("courses",$courses);
        $this->display();
    
    }
	
	// Author: 盘志伟
	// Date:2017-1-7
	//收藏和取消收藏
	 public function toggleCollect(){
		 
		$uid = $_SESSION['id'];
    	if (!$uid) {
			$this->error('未登录',U('Login/index'));
    	}
    	$cid = $_GET['id'];
    	if (!$this->checkCourse($cid)) {
    		echo("不存在该课程");
			return;
    	}
      $where = "user_id={$uid} and course_id={$cid}";
      $uc = M("user_course");
      $r=$uc->where($where)->find();

      if ($r) {
       
      	$uc = M("user_course");
      	$uc->where($where)->delete();
      }else{
      	$arr = array(
      		'user_id'=>$uid,
      		'course_id'=>$cid,
      		'create_time'=>date('Y-m-d H:i:s',time()),
      		'status'=>1,
      		'power'=>1
      	);
      	
      	$uc = M("user_course");
      	$uc->add($arr);
		
		 	
      }
		$this->redirect("Course/courseDetail/id/$cid");
	}
	
	private function checkCourse($id){
    	$c = M('course');
    	$f = $c->where("id={$id}")->find();
    	if ($f) {
    		return true;
    	}else{
    		return false;
    	}
    }
}