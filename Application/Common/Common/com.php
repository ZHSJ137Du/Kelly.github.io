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
function inject_check($sql_str) { 
    return eregi('select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile', $sql_str);
} 

function str_check( $str ) { 
	if (inject_check($post)) {
		return false;
	}
    if(!get_magic_quotes_gpc()) { 
        $str = addslashes($str); // 进行过滤 
    } 
    $str = str_replace("_", "\_", $str); 
    $str = str_replace("%", "\%", $str); 
     
   return $str; 
}

function post_check($post) {
	if (inject_check($post)) {
		return false;
	}
    if(!get_magic_quotes_gpc()) { 
        $post = addslashes($post);
    } 
    $post = str_replace("_", "\_", $post); 
    $post = str_replace("%", "\%", $post); 
    $post = nl2br($post); 
    $post = htmlspecialchars($post); 
     
    return $post; 
}
