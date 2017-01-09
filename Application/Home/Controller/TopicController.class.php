<?php
namespace Home\Controller;
use Think\Controller;
class TopicController extends Controller {

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
       $ct = $_GET['ctid'];
       $c = M('Topic');
       $count = $c->count();
       $Page = new \Think\Page($count,25);
       $show = $Page -> show();
       $cts = $this->getClassify();
     	 $data=$c->limit($Page->firstRow.','.$Page->listRows)->select();
       
       $this->assign("page",$show);
       $this->assign("cts",$cts);
       $this->assign("Topic",$data);
       $this->display();
    }
    public function topicList(){
      $id = $_GET['id'];
      $c = M('Topic');
      $Page = new \Think\Page($count,25);
      $show = $Page -> show();
      $data=$c->where('comm_id='.$id)->limit($Page->firstRow.','.$Page->listRows)->select();
      $user = array();
      foreach ($data as $key => $val) {
        $user[$val['user_id']] = 0;
      }
      $key = implode(',', array_keys($user));
      $sql = "select id,user_name from user where id in ({$key})";
      $Model = new \Think\Model() ;
      $i =$Model->query($sql);
        foreach ($data as $key => $val) {
          foreach ($i as $k => $v) {
            if ($val['user_id']==$v['id']) {
              $data[$key]['man'] =$v['user_name'];
            }
          }
        }
      if (isset($_SESSION['id'])) {
         $where = "user_id={$_SESSION['id']} and commid={$id}";
         $uc = M("user_community");
         $r=$uc->where($where)->find();
         if ($r) {
           $this->assign("nojoin",0);
         }else{
           $this->assign("nojoin",1);
         }
       }
      $c = M('community')->field("comm_name")->where("id={$id}")->find();
      $this->assign('hotBbs',$this->getHotBbs());
      $this->assign('cname',$c['comm_name']);
      $this->assign("page",$show);
      $this->assign("Topic",$data);
      $this->assign("id",$id);
      $this->display();
    }
    public function show(){
      $id = $_GET['id'];
      if (!$id) {
        echo '404 not found';die();
      }
      $c = M('Topic');
      $topic = $c->where("id={$id}")->find();
      if (!$topic) {
        echo '404 not found';die();
      }
      $arr['click_num'] = $topic['click_num']+1;
      $c->where('id='.$id)->save($arr);
      $comment = $this->getComment($id);
      $community = $this->getCommunityById($topic['comm_id']);
      $this->assign('comment',$comment);
      $this->assign('community',$community);
      $this->assign("topic",$topic);
      $this->display();
    }
    public function commentTopic(){
      if (!isset($_SESSION['id'])) {
        echojson("请登录后在评论",false);
      }
      $v = post_check($_POST['v']);
      $i = $_POST['i'];
      $arr = array(
        'user_id'=>$_SESSION['id'],
        'comment_content'=>$v,
        'comment_type'=>2,
        'src_id'=>$i,
        'create_time'=>date('Y-m-d H:i:s',time())
      );
     M('comment')->add($arr);
      echojson("评论成功",true);
    }
    public function getCommunityById($id){
      $c = M('community')->where('id='.$id)->find();
      return $c;
    }
    private function getComment($id){
      $c = M("comment")->where("src_id={$id} and comment_type=2")->select();
      return $c;
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