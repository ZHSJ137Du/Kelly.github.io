<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;
/**
 * 网站设置模型
 * @author 华强小组
 */
class WebConfigModel extends Model{

    protected $_validate = array(
        array('title', 'require', '网站名称不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    	array('title', '1,50', '网站名称不能超过50个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),
    	array('subtitle', 'require', '网站副标题不能为空', self::MUST_VALIDATE , 'regex', self::MODEL_BOTH),
    	array('subtitle', '1,50', '网站副标题不能超过50个字符', self::VALUE_VALIDATE , 'length', self::MODEL_BOTH),    

    	//TO DO 验证数据有效性
    );

}
