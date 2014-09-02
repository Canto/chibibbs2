<?php
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());
error_reporting(E_ALL ^ E_NOTICE);
require_once "../../data/config/db.config.php";
$id = $_POST['user_id'];
$password = $_POST['password'];
$cid = $_POST['cid'];
$cAct = $_POST['cAct'];
if($cAct=="login"){
if($id==$ADMIN_ID && md5($password) == $ADMIN_PASSWD){
	$user_info = new stdClass();
	$user_info->user_id = $ADMIN_ID;
	$user_info->password = $ADMIN_PASSWD;
	$user_info->last_login = date("YmdHis",time());
	$user_info->login_type = "chibibbs";
	$user_info->is_admin = "Y";
	$_SESSION["user_info"] = $user_info;
	//Develop::debugPrint($_SESSION["user_info"]);
	$json = array("status"=>"success");
}else{
	unset($_SESSION["user_info"]);
	$json = array("status"=>"fail");
}
}else if($cAct=="logout"){
	unset($_SESSION["user_info"]);
	$json = array("status"=>"success");
}
echo json_encode($json);