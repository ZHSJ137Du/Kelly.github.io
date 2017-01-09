<?php
namespace Home\Controller;
use Think\Controller;
class ArticleTypeController extends Controller {

//构造器,登录过滤
	function __construct()
	{
		parent::__construct();
		session_start();
		if( !isset($_SESSION['userid'])  )
		{
			if( !isset($_SESSION['id']) )
			{
				//未登录或session失效，跳转首页
				Header('HTTP/1.1 303 See Other'); 
				Header('Location: /');
				return;
			}
			else
			{
				$userid = (int)$_SESSION['id'];
			}
		}
		else
		{
			$userid = (int)$_SESSION['userid'];
		}
		$data = M('user')->where('id='.$userid)->select();
		if(!$data[0]['power'])
		{
			//权限不足，跳转首页
			Header("HTTP/1.1 303 See Other"); 
			Header("Location: /");
			return;
		}
	}

//首页显示
    public function index()
    {
		$page = I('page');
		if( $page <= 0 )
			$page = 1;
		$count = M('article_type')->count();
		$max_page = ceil($count/10);
		$start = ($page-1)*10;
		if($start > $count)
		{
			$start = 0;
			$page = 1;
		}
		$data = M('article_type')->limit($start,10)->select();
		$this->data = $data;
		$this->count = $count;
		$this->page = $page;
		$this->maxpage = $max_page;
		$this->display();
    }


//添加类型页面
	public function add()
	{
		$name = I('name');
		$data =['type_name' => $name];
		$ret = M('article_type')->add($data);
		if($ret <= 0)
			$this->ret = 'error';
		else
			$this->ret = 'success';
		$this->display();
	}

//删除类型页面
	public function delete()
	{
		$id = (int)I('id');
		
		if(!$id)
		{
			$this->ret = 'error';
			$this->display;
			return;
		}
		$ret = M('article_type')->delete($id);
		if($ret <= 0)
			$this->ret = 'error';
		else
			$this->ret = 'success';
		$this->display();
	}

//修改类型页面
	public function alter()
	{
		$id = I('id');
		$data = M('article_type')->where('id='.$id)->select();	
		$this->data = $data[0];
		$this->display();
	}

//更新类型内容页面
	public function update()
	{
		$id = (int)I('id');
		$name = I('name');
		
		if(!$id | !strlen($name))
		{
			$this->ret = 'error';
			$this->display;
			return;
		}

		$ret = M('article_type')->where('id='.$id)->save(['type_name'=>$name]);
		if($ret <= 0)
			$this->ret = 'success';
		else
			$this->ret = 'error';
		$this->display();
	}

	
}
