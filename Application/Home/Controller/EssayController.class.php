<?php
namespace Home\Controller;
use Think\Controller;
class EssayController extends Controller {
    private $essay;
    public function __construct(){
      parent::__construct();
      if (isset($_SESSION['id'])) {
        $this->assign('islogin',1);
      }else{
        $this->assign('islogin',0);
      }
      $this->essay = M('article');
      $this->assign('active','essay');
    }
    public function index(){
       $ct = $_GET['cid'];
       $count = $this->essay->count();
       $Page = new \Think\Page($count,25);
       $show = $Page -> show();
       $cts = $this->getClassify();
       if ($ct) {
       		$data=$this->essay->where('article_type='.$ct)->limit($Page->firstRow.','.$Page->listRows)->select();
       }else{
       		$data = $this->essay->limit($Page->firstRow.','.$Page->listRows)->select();
          $ct = 'all';
       }

       $this->assign('act',$ct);
       $this->assign('page',$show);
       $this->assign("hoteassy",$this->getHotEassy());
       $this->assign("type",$cts);
       $this->assign("essay",$data);
       $this->display();
    }
    public function show(){
      $id = $_GET['id'];
      if (!$id) {
        echo '404 not found';die();
      }
      $essay = $this->essay->where("id={$id}")->find();
      if (!$essay) {
        echo '404 not found';die();
      }
      $arr['click_num'] = $essay['click_num']+1;
      $this->essay->where('id='.$id)->save($arr);
      $comment = $this->getComment($id);
      $user = $this->getUser($essay['user']);
      $this->assign('user',$user['user_name']);
      $this->assign('comment',$comment);
      $this->assign("essay",$essay);
      $this->display();
    }
    public function comment(){
      $uid = $_SESSION['id'];
      if (!$uid) {
        echojosn("未登录",false,1);
      }
      $id = $_POST['id'];
      $content = post_check(trim($_POST['content']));
      if (!$content) {
        echojosn("非法参数",false,2);
      }
      if (!$this->checkEssay($id)) {
        echojosn("不存在该社区",false,2);
      }
      $arr = array(
        'user_id'=>$uid,
        'comment_content'=>$cid,
        'comment_type'=>3,
        'src_id'=>$id,
        'create_time'=>time()
      );
      $c = M("comment");
      $a=$c->add($arr);
      if ($a) {
        echojosn("评论成功",true);
      }else{
        echojosn("评论失败",false,2);
      }
    }
    private function getHotEassy(){
      $where = "hot=1";
      $data=$this->essay->where($where)->limit($start*($page+1),15)->select();
      return $data;
    }
    private function getComment($id){
      $c = M("comment")->where("src_id={$id} and comment_type=3")->select();
      return $c;
    }
    private function getClassify(){
    	$ct = M('article_type');
    	$arr = $ct->select();
    	return $arr;
    }
    private function checkEssay($id){
      $f = $this->essay->where("id={$id}")->find();
      if ($f) {
        return true;
      }else{
        return false;
      }
    }
    private function getUser($id){
      $u = M('user')->where('id='.$id)->find();

      return $u;
    }

}