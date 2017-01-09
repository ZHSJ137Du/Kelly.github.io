<?php
namespace Home\Controller;
use Think\Controller;
//use Think\Upload;


class CourseController extends Controller {
    // 列表
    private $course;
    public function __construct(){
        parent::__construct();
        $this->course =  M('course');
    }
    public function index(){
        
        $tid = $_GET['tid'];

        $Page = new \Think\Page($count,25);
        if ($tid) {
            $where = "type_id={$tid}";
            
        }
        $count = $this->course->where($where)->count();
        $data = $this->course->where($where)->limit($Page->firstRow.','.$Page->listRows)->select();
        $show = $Page -> show();
        $type = $this->getType();
        foreach ($data as $key => $val) {
            $user[$val['create_user']] = 0;
            if (!empty($type)) {
                $data[$key]['tname'] = $type[$val['type_id']];
            }
            
        }
        if ($user) {
            $ukey = implode(",", array_keys($user));
            $sql = "select id,user_name from user where id in ({$ukey})";
            $Model = new \Think\Model() ;
            $u =$Model->query($sql);
            foreach ($data as $key => $val) {
                foreach ($u as $k => $v) {
                    if ($v['id']==$val['create_user']) {
                        $data[$key]['man']=$v['user_name'];
                        continue;
                    }
                }
            }
        }

        $this->assign('list',$data);

        $this->assign("page",$show);
        $this->display();
    }

    public function add()
    {
        $type = $this->getType();
        $this->assign("courseType",$type);
    	$this->display();
    }
    //保存信息,添加
    public function save()
    {
       // 图片（文件）数据保存？
       // 路径从哪里获取？
       //1、把这个的文件保存到我们的项目目录中
        if ($_FILES['thumb']['size']) {
            
                $upload = new Upload();
                $upload->maxSize  = 3145728 ;
                $upload -> autoSub = false;
                $upload->exts  = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath="./Public/upload/news/";
                $up=$upload->upload();

               // 2、数据表里需要保存的是路径
                $data['course_icon']=str_replace('./Public/', "", $upload->rootPath).$up['thumb']['savename'];

                if(!$up) {
                    $this->error($upload->getError());
                }
        }

        // 3、把标题和内容保存到数据表
        $data['course_name']=I('course_name');
        
        $data['course_info']=I('course_info');
        $data['type_id']=I('type_id');
        $data['video_url']=I('video_url');
        // $data['create_user']=$_SESSION['id'];
        $data['create_user']=1;

        // $data['create_time']=time();
        $data['score']=100;
        $data['status']=1;

        $this->course->add($data);

        $this->success('添加成功！',U('Course/index'));

    }
    public function edit()
    {
        $id=I('id');

        // 查询一条信息
        $info=$this->course->where("id=$id")->find();
        // echo $article_m->getLastSql();
       
        $this->assign('info',$info);
        $this->assign('courseType',$this->getType());
    	$this->display();
    }
    public function update()
    {
         if ($_FILES['thumb']['size']) {
            
                $upload = new Upload();
                $upload->maxSize  = 3145728 ;
                $upload -> autoSub = false;
                $upload->exts  = array('jpg', 'gif', 'png', 'jpeg');
                $upload->rootPath="./Public/upload/news/";
                $up=$upload->upload();

               // 2、数据表里需要保存的是路径
                $data['course_icon']=str_replace('./Public/', "", $upload->rootPath).$up['thumb']['savename'];

                if(!$up) {
                    $this->error($upload->getError());
                }
        }

        // 3、把标题和内容保存到数据表
        $data['course_name']=I('course_name');
        
        $data['course_info']=I('course_info');
        $data['type_id']=I('type_id');
        $data['video_url']=I('video_url');
        // $data['create_user']=$_SESSION['id'];

        // $data['create_time']=time();
        $data['score']=100;
        $id=I('id');
        $this->course->where("id=$id")->save($data);

        $this->success('修改成功！',U('Course/index'));
    }

    public function del(){
        $id = I('id');
        $where = "id={$id}";
        $this->course->where($where)->delete();
        echojson("success",true);
    }

    public function show(){
        $id = I('id');
        $a = M('course');
        $data = $this->checkCourse($id);
        if (!$data) {
            echo "404";die;
        }
        $man = M('user')->where("id={$data['create_user']}")->find();
        $data['man'] = $man['user_name'];
        $data['usercourse']=$this->getUserCourse($id);
        $this->assign("data",$data);
        $this->display();

    }

    private function checkCourse($id){
        return $this->course->where("id={$id}")->find();
    }

    private function getUserCourse(){
        $u = M('user_course')->where("courser_id={$id}")->field('user_id')->select();

        foreach ($u as $key => $val) {
            $k[]=$val['user_id'];
        }
        if ($k) {
           $key = implode(',', $k);
           $sql = "select id,user_name from user where id in ({$ukey})";
           $Model = new \Think\Model() ;
           $u =$Model->query($sql);
           return $u;
        }else{
            return false;
        }
    }

    private function getType(){
        $t = M('course_type')->field("id,type_name")->select();
        $type = array();
        foreach ($t as $key => $val) {
            $type[$val['id']]=$val['type_name'];
        }
        return $type;
    }
}
