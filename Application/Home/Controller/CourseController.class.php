<?php
namespace Home\Controller;
use Think\Controller;
 
class CourseController extends Controller {
    //操作名称
    public function index(){
    	//sum click_num
    	$_SESSION['is_newView'] = true;

    	//set $active
		$active = @I('get.active');
		if(!$active){
			$active = '';
		}
		$this-> assign('active',$active);

		//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		$this -> assign("configs",$configs);

	    // 分页设计   join course_type on course
	    $model_courseType = M('course_type');
	    $where = '';
	    $type_name = @I('get.type_name');
	    //可用绝对路进行传值来避免设置与使用这个session
	    $clear_session = @I('get.clear_session');

	    if($type_name){	    	
	    	session("last_typeName",$type_name);
	    	$where = 'course_type.type_name LIKE "%'.$type_name.'%"';
	    }else if(!empty($_SESSION['last_typeName']) && $clear_session!=1){
	    	$type_name = $_SESSION['last_typeName'];
	    	$where = 'course_type.type_name LIKE "%'.$type_name.'%"';
	    }

	    $count = $model_courseType->join('LEFT JOIN course ON course_type.id = course.type_id') ->where($where) ->count();
	    $p = $this->getPage($count,6);

	    //set $active1
	    $order = @I('get.order');
	    
    	if($order){
    		$this->assign('active1',$order);	
    		$order = 'course.'.$order.' DESC';
    	}else{
    		$order = 'click_num';
    		$this->assign('active1',$order);
    	}

    	$field = 'course.id as course_id,course.course_name,course.course_icon,course.click_num,course.student_num';
	    $typeList = $model_courseType->field($field)-> join('LEFT JOIN course ON course_type.id = course.type_id')->where($where)->order($order)->limit($p->firstRow, $p->listRows)->select();
	    $this->assign('select',$typeList);
	    $this->assign('page', $p->show()); // 赋值分页输出



	    $this->display();
    }

    // ThinkPHP自身带有相应的分布操作类
    public function getPage($count, $pagesize = 10) {
	  $p = new \Think\Page($count, $pagesize);
	  $p->setConfig('header', '<li class="pages">第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页  <b>%TOTAL_ROW%</b>个课程</li>');
	  $p->setConfig('prev', '上一页');
	  $p->setConfig('next', '下一页');
	  $p->setConfig('last', '末页');
	  $p->setConfig('first', '首页');
	  $p->rollPage = 4;
	  $p->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');

	  $p->lastSuffix = false;//最后一页不显示为总页数
	  return $p;
	}

	public function courseDetail(){
		//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		$this -> assign("configs",$configs);

		//set $active
		$active = @I('get.active');
		if(!$active){
			$active = '';
		}
		$this-> assign('active',$active);

		// 判断session
		if($_SESSION){
			$this->assign("lo",$_SESSION);
		}else{
			$this->assign("lo",'');
		}

		$userId=$_SESSION['id'];
		$data['id']=$_GET['id'];

		$userCourse = M("user_course");		
		$course = M("course");

		//get course
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
		
		//与上边有重复
		$index = @I('get.id');
    	if(!$index){
    		$index = '';    		
    	}
    	$course_model = M('course');
    	$course_list = $course_model ->where("course.id = $index") ->limit(1)->select();

    	if(empty($course_list)){
    		$course_list = '';
    	}
    	$this->assign('course_detail',$course_list);

    	//sum click_num
    	$temp1['click_num'] = $course_list[0]['click_num'] + 1; 
    	echo($temp1['click_num']);
    	echo($course_list[0]['click_num']);
    	if($_SESSION['is_newView'] == true){
    		$course_model->where("id=$index")->save($temp1);
    		$_SESSION['is_newView'] = false;
    	}

    	// $course_chapter = M('course_chapter');
    	// $id_chapter = $course_chapter->where("course_chapter.course_id =$index")->limit(1)->find();
    	// $this->assign('id_chapter',$id_chapter);


    	$course_content = M('course_content');
    	$id_content = $course_content->where("course_content.course_id =$index")->select();
    	$this->assign('id_content',$id_content);

		$this->display();    // 输出模板  
	}
}