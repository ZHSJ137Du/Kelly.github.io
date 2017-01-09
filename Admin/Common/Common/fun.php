<?php
function echojson($msg,$bool,$a){
	$arr = array(
		'msg'=>$msg,
		'status'=>$bool,
		'a'=>$a
	);
	echo json_encode($arr);
	die();
}