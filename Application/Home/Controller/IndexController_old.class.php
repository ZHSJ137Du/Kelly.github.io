<?php
// Author: 黄汉杰
// Date:2017-1-7
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {

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

		$banners = M('index_banner');
		$data = $banners->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
		$this -> assign('banners', $data);
		
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
}
