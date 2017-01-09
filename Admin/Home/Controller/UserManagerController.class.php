<?php
namespace Home\Controller;

/**
 * 用户列表
 * @author 华强小组
 *
 */
class UserManagerController extends CommonController{
	protected  $user;
	
	public function _initialize(){
		parent::_initialize();
		$this->user = D('user');
	}
	
	//数据列表
	public function index(){
		$count      = $this->user->count();
		$Page       = new \Think\Page($count,5);
		$Page->setConfig('theme', '%FIRST%%UP_PAGE%%LINK_PAGE%%DOWN_PAGE%%END%%HEADER%');
		$show       = $Page->show();
		$user_list = $this->user->field('id, user_name, phone, email, power, status')
					->limit($Page->firstRow.','.$Page->listRows)->order('id asc')->select();
		$user_list = int_to_string($user_list);
		$this->assign('user_list', $user_list);
		$this->assign('page',$show);
		$this->display();
	}
	
	//删除数据
	public function del(){
		if(IS_GET){
			$ids = I('get.ids');
			$ids = explode(',', $ids);
		}
		if(IS_POST){
			$ids = I('post.ids');
		}
		empty($ids) && $this->error('参数不能为空！');
		$res = $this->user->where(array('id'=>array('in',$ids)))->delete();
		if(!$res){
			$this->error($this->user->getError());
		}else{
			$this->success('删除用户成功！');
		}
	}	
	
	//设置用户状态
	public function setStatus(){
		$ids    =   I('request.ids');
		$status =   I('request.status');
		if(empty($ids)){
			$this->error('请选择要操作的数据');
		}
		$map['id'] = array('in',$ids);
		switch ($status){
			case 0  :
				$this->forbid($map, array('success'=>'禁用成功','error'=>'禁用失败'));
				break;
			case 1  :
				$this->resume($map, array('success'=>'启用成功','error'=>'启用失败'));
				break;
			default :
				$this->error('参数错误');
				break;
		}
	}

	//用户拉黑禁用
	protected function forbid ($where = array() , $msg = array( 'success'=>'状态禁用成功！', 'error'=>'状态禁用失败！')){
		$data    =  array('status' => 0);
		$this->editRow($data, $where, $msg);
	}
	
	//用户恢复
	protected function resume ($where = array() , $msg = array( 'success'=>'状态恢复成功！', 'error'=>'状态恢复失败！')){
		$data    =  array('status' => 1);
		$this->editRow($data, $where, $msg);
	}
	
	//
	final protected function editRow ($data, $where , $msg ){
		$id    = array_unique((array)I('id',0));
		$id    = is_array($id) ? implode(',',$id) : $id;
		$fields = $this->user->getDbFields();
		
		if(in_array('id',$fields) && !empty($id)){
			$where = array_merge( array('id' => array('in', $id )) ,(array)$where );
		}
		
		$msg   = array_merge( array( 'success'=>'操作成功！', 'error'=>'操作失败！', 'url'=>'' ,'ajax'=>IS_AJAX) , (array)$msg );//如果两个或更多个数组元素有相同的键名，则最后的元素会覆盖其他元素。
		if( $this->user->where($where)->save($data)!==false ) {
			$this->success($msg['success'],$msg['url'],$msg['ajax']);
		}else{
			$this->error($msg['error'],$msg['url'],$msg['ajax']);
		}
	}	
}