<?php

/**
 * 模板调用
 * @author华强小组
 * @param unknown $status
 * @return string|boolean
 */
function show_status_op($status) {
	switch ($status){
		case 0  : return    '启用';     break;
		case 1  : return    '禁用';     break;
		case 2  : return    '审核';       break;
		default : return    false;      break;
	}
}


/**
 * 获取用户状态
 * @author华强小组
 * @param unknown $data
 * @param unknown $map
 * @return unknown|Ambigous <array, unknown>
 */
function int_to_string(&$data,$map=array('power'=>array(1=>'是',0=>'否'),'status'=>array(1=>'正常',0=>'禁用'))) {
	if($data === false || $data === null ){
		return $data;
	}
	$data = (array)$data;
	foreach ($data as $key => $row){
		foreach ($map as $col=>$pair){
			if(isset($row[$col]) && isset($pair[$row[$col]])){
				$data[$key][$col.'_text'] = $pair[$row[$col]];
			}
		}
	}
	return $data;
}