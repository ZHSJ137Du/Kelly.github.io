<?php
namespace Home\Controller;
use Think\Controller;
class BbsController extends Controller {
    public function __construct(){
      parent::__construct();
      if (isset($_SESSION['id'])) {
        $this->assign('islogin',1);
      }else{
        $this->assign('islogin',0);
      }
      $this->assign('active','bbs');
    }
    public function index(){
       $ct = @$_GET['ctid'];
       
       $c = M('community');
       $count = $c->count();
       $Page = new \Think\Page($count,25);
       $show = $Page -> show();
       $cts = $this->getClassify();
       if ($ct) {
       		$data=$c->where('comm_type='.$ct)->limit($Page->firstRow.','.$Page->listRows)->select();
       }else{
       		$data = $c->limit($Page->firstRow.','.$Page->listRows)->select();
       }
      
       $this->assign('hotBbs',$this->getHotBbs());

       $this->assign('page',$show);
       
       $this->assign("cts",$cts);
       $this->assign("community",$data);
       $this->display();
    }
    public function joinComunity(){
    	$uid = $_SESSION['id'];
    	if (!$uid) {
    		echojson("未登录",false,1);
    	}
    	$cid = $_POST['id'];
    	if (!$this->checkComunity($cid)) {
    		echojson("不存在该社区",false,2);
    	}
      $where = "user_id={$uid} and commid={$cid}";
      $uc = M("user_community");
      $r=$uc->where($where)->find();

      if ($r) {
        echojson("成功加入",true);
      }else{
      	$arr = array(
      		'user_id'=>$uid,
      		'commid'=>$cid,
      		'create_time'=>date('Y-m-d H:i:s',time()),
      		'status'=>1,
      		'power'=>1
      	);
      	$uc = M("user_community");
      	$a=$uc->add($arr);
      	if ($a) {
      		echojson("成功加入",true);
      	}else{
      		echojson("加入失败",false,2);
      	}
      }
    }
    public function quitComunity(){
    	$uid = $_SESSION['id'];
    	if (!$uid) {
    		echojson("未登录",false,1);
    	}
    	$cid = $_POST['id'];
    	if (!$this->checkComunity($cid)) {
    		echojson("不存在该社区",false,2);
    	}
    	$uc = M("user_community")->where("user_id={$uid} and commid={$id}")->delete();
    	if ($uc) {
    		echojson("成功退出",true);
    	}else{
    		echojson("退出失败",false,2);
    	}
    }
    private function checkComunity($id){
    	$c = M('community');
    	$f = $c->where("id={$id}")->find();
    	if ($f) {
    		return true;
    	}else{
    		return false;
    	}
    }
    private function getClassify(){
    	$ct = M('community_type');
    	$arr = $ct->select();
    	return $arr;
    }
    private function getHotBbs(){
      $c = M('community');
      $f = $c->where("hot=1")->limit(0,10)->select();
      return $f;
    }

}