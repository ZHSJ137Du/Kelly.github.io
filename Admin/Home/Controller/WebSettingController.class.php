<?php
namespace Home\Controller;
use Think\Upload;

/**
 * 网站设置控制器
 * @author 华强小组
 *
 */
class WebSettingController extends CommonController{
	protected  $web_config;
	
	public function _initialize(){
		parent::_initialize();
		$this->web_config = D('web_config');
	}
	
	//web_config读取数据
	public function index(){
		if (!S('web_config_list')) {
			$web_config_list = $this->web_config->find();
			S('web_config_list', $web_config_list, 3600);
		}
		$this->assign('web_config_list', S('web_config_list'));
		$this->display();
	}
	
	//web_config保存操作  保存数据也可以保存在常量中，用C方法设置
	public function update(){
		if (IS_POST) {
			if ($this->web_config->create()) {
				if (I('post.id')?$this->web_config->save():$this->web_config->add()) {
					S('web_config_list', I('post.'), 3600);
					$this->success('保存成功');
				} else {
					$error = $this->web_config->getError();
					$this->error(empty($error) ? '数据未修改！' : $error);
				}
			} else {
				$this->error($this->web_config->getError());
			}
		}else{
			$this->error('非法提交');
		}
	}
	
	// 图片上传
	public function upload(){
		$Upload = new Upload(C('PICTURE_UPLOAD'));
        $info   = $Upload->upload();
        if($info){
            foreach ($info as $key => $value) {
                $path = array('path'=>$value['savepath'].$value['savename']);	//在模板里的url路径
            }
            $return  = array('status' => "1", 'info' => '上传成功');
            $return = array_merge($path, $return);
            $this->ajaxReturn($return);
        } else {
            $this->error = $Upload->getError();
            return false;
        }			
	}
}