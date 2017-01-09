<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

    public function index(){

    	// 判断session
		if($_SESSION){
			$this->assign("lo",$_SESSION);
		}else{
			$this->assign("lo",'');
		}

		//网站配置
		$config = M('web_config');
		$configs = $config ->field("title,subtitle,logo_url,icp,url_model,web_code_count") ->find();
		$this -> assign("configs",$configs);
		
		$banners = M('index_banner');
		$data = $banners->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this -> assign('banners', $data);		

		//set $active
		$active = @I('get.active');
		if(!$active){
			$active = 'home';
		}
		$this-> assign('active',$active);

		// hot course
		$this->getActiveCourse('activeCourse','',4,'student_num DESC,create_time DESC');
		// hot course left-list
		$this->getActiveCourse('activeListHot','',10,'student_num DESC,create_time DESC');
		// hot course right-list
		$this->getActiveCourse('activeListRec','',10,'click_num DESC,create_time DESC');
		//science list
		//$this->getActiveCourse('scienceList','type_id = 1',6,'click_num DESC,create_time DESC');
		$this->getActiveCourse('scienceList','course_type.type_name LIKE "%科技%"',6,'course.click_num DESC,course.create_time DESC','RIGHT JOIN course_type ON course.type_id =course_type.id','course.id as course_id,course.course_name,course.course_icon,course.click_num,course.student_num');
		
        $this->display();
    }

    public function getActiveCourse($name,$setWhere,$limit_num=4,$setOrder='',$join='',$field=''){
    	$m = M('course');
    	$list = $m->field($field)-> join($join)->where($setWhere)-> order($setOrder)->limit($limit_num)->select();
	    $this->assign($name, $list); // 赋值数据集
    }
}