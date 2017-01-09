<?php
namespace Home\Controller;
use Think\Controller;

class CommunityController extends Controller {
	// Author: 李浩龙and潘洪亮
	// Date:2017-1-7
	//分页显示我的社区
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
		
    $community = M("community");
	$userId=$_SESSION['id'];
    $map['comm_name'] = array("LIKE","%{$_GET['comm_name']}%");
    //$map['status'] = 1;
    //$map['id'] = array("LIKE","%{$_GET['id']}%");
    $count = $community -> where($map) -> count();
	
    $Page = new \Think\Page($count,6);
    $show  = $Page  ->show();
    $communitys = $community -> join('user_community uc ON uc.commid=community.id') ->where($map) -> where("uc.user_id={$userId}")->  order("id DESC") -> limit($Page->firstRow.','.$Page -> listRows) -> select();
     foreach($communitys as &$i){
      $i['create_time'] = date('Y-m-d H:i:s',$i['create_time']);
     }

    $num = ($Page -> nowPage -1)*($Page ->listRows) +1;
    $this -> assign("num",$num);
     //dump($infos);

    $this ->assign("page",$show);

    $this -> assign("communitys",$communitys);
        $this->display();

    }
}
