<?php
namespace Home\Controller;
use Think\Controller;
 
class CourseController extends Controller {

	//操作名称
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
		
		//遍历全部课程
		
		$course = M('course');
		$type = M('course_type');
		//$map['click_num'] = array('gt',0);
		
		$courses = $course -> where($map)-> order("click_num DESC")->limit("0,6") -> select();
		foreach($courses as &$v){
			$data = $type -> field('type_name') -> find($v['type_id']);
			$v['type_name'] = $data['type_name'];
		}
		
		$this -> assign('courses',$courses);
		
		
        $this->display();    
    } 

    //操作名称
    public function courseDetail(){
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
		$userCourse = M("user_course");
		$course = M("course");
		$data['id']=$_GET['id'];	
			
		if($course->where("id={$_GET['id']}")->find()){
			$data['id']=$_GET['id'];
		}else{
			$course->add($_GET);
			$data['id']=$_GET['id'];
		}
		$courses = $course -> where("id={$data['id']}") ->find();
		if (!$userId == null) {
    
		$userCourse=$userCourse->where("course_id={$data['id']} and user_id={$userId}") ->find();
		$this -> assign("userCourse",$userCourse);
		}
		$this -> assign("courses",$courses);
	
		
        $this->display();    
    }         
	
}