<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {

//构造器
//查询session做登录过滤
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

//首页
    public function index()
    {
		//实现分页显示，一页10条

		//页码小于等于0时让页码等于1
		$page = I('page');
		if( $page <= 0 )
			$page = 1;
		//查询数据条数总数
		$count = M('article')->count();
		//计算页数
		$max_page = ceil($count/10);
		//计算开始条数
		$start = ($page-1)*10;
		//判断是否最后一页
		if($start > $count)
		{
			$start = 0;
			$page = $max_page;
		}
		//得到对应数据
		$data = M('article')->limit($start,10)->select();
		//传参到模板
		$this->data = $data;
		$this->count = $count;
		$this->page = $page;
		$this->maxpage = $max_page;
		//显示模板
		$this->display();
    }

	public function delete()
	{
		//得到传入的ID
		$id = I('id');
		//查询数据库
		$ret = M('article')->delete($id);
		//判断删除是否成功
		if($ret <= 0)
			$this->ret = 'error';
		else
			$this->ret = 'success';
		$this->display();
	}

//显示添加文章
	public function add()
	{
		//显示添加页面
		$this->display();
	}

//显示修改文章
	public function alter()
	{
		//获取传入的ID
		$id = I('id');
		//根据ID查询数据库
		$data = M('article')->where('id='.$id)->select();
		$data = $data[0];
		//将数据传到模板
		$this->data = $data;
		$this->display();
	}

//更新文章
	public function update()
	{
		//开始异常捕获
		try{
		$id = I('id');
		$title = I('title');
		$type = I('type');
		$keyword = I('keyword');
		$content = I('content');
		//获取传入参数
		//判断标题和内容是否为空
		if(strlen($title) && strlen($content))
		{
			//判断文章类型是否存在
			$tmp = M('ArticleType')->where('id='.$type)->count();
			if( $tmp==0 )
			{
				//抛出异常
				E('Article type error!');
			}
			//构建新数据内容
			$data = ['article_title' => $title, 'article_content' => $content, 'article_type' => $type, 'key_word' => $keyword];
			//判断文件是否上传
			if(!empty($_FILES['photo']['tmp_name']))
			{
				//判断文件上传是否错误
				if($_FILES['photo']['error'] > 0)
				{
					E('Upload error!');
				}
				//获取临时目录
				$tmp_path = $_FILES['photo']['tmp_name'];
				//获取后缀
				$file_type = substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'], '.'));
				//根据文件MD5码得到新文件名和目录
				$path = './Public/img/'.md5_file($tmp_path).$file_type;
				//移动文件
				if( !move_uploaded_file($_FILES['photo']['tmp_name'], $path) )
				{
					E('Move photo error!');
				}
				//将文件路径存到新数据
				$data['img'] = $path;
			}
			//更新数据
			$ret = M('article')->where('id='.$id)->save($data);
			
			//判断插入是否异常
			if( $ret != 1 )
			{
				E('Update database error!');
			}
			$this->ret = 'success';
		}else
			$this->ret = 'error';
		}catch(\Think\Exception $e)
		{
			//捕获异常
			$this->ret = 'error';
		}finally{
			//显示结果
			$this->display();
		}
	}

//add后跳转，添加到数据库，类似update
	public function save()
	{
		try{
		//获取传入参数
		$title = I('title');
		$type = (int)I('type');
		$keyword = I('keyword');
		$content = I('content');
		//判断标题和内容是否为空
		if(strlen($title) && strlen($content))
		{
			//判断文章类型是否正确
			$tmp = M('ArticleType')->where('id='.$type)->count();
			if($tmp!=1)
			{
				E('Article type error!');
			}	
			//判断文件上传是否出错
			if($_FILES['photo']['error'] > 0)
			{
				E('Upload error!');
			}
			//获取文件临时路径
			$tmp_path = $_FILES['photo']['tmp_name'];
			//获取文件类型
			$file_type = substr($_FILES['photo']['name'], strrpos($_FILES['photo']['name'], '.'));
			//得到新文件路径
			$path = './Public/img/'.md5_file($tmp_path).$file_type;
			//移动文件到新路径
			if( !move_uploaded_file($_FILES['photo']['tmp_name'], $path) )
			{
				E("Move photon error!");
			}
			//得到插入数据库的data
			$data = ['article_title' => $title, 'article_content' => $content, 'article_type' => $type, 'img' => $path, 'key_word' => $keyword, 'create_time' => date('Y-m-d H:i:s',time())];
			//插入数据库
			$ret = M('article')->add($data);
			if(!$ret)
			{
				E('Insert database error!');
			}
			$this->ret = 'success';
		}else
			E('error');
		}catch(\Think\Exception $e){
			$this->ret = 'error';
		}finally{
			$this->display();
			return;
		}
	}

	
}
