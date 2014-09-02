<?php

/* chibi version */
$chibi_ver = "2.0";
/* DB Set */
$db = new CDB();
$db->set($DBINFO);

/* check Installed */
$install = new Install();
/* Display info */
$display = new Display();
/* Admin Class */
$admin = new Admin();
/* User info */
$user_info = new stdClass();
if($_GET['cid'])
{
	$bbs = new Board();
	$board = $bbs->select($_GET['cid'],$db->conn());
	/* Set board skin info , if have a cid */
	$skin = $bbs->skin($_GET['cid'],$db->conn());
}
if($_SESSION['user_info']) $user_info = $_SESSION['user_info'];
if($CMS=="xe")
{
	require_once($XE_PATH.'config/config.inc.php');
	$oContext = &Context::getInstance();
	$oContext->init();
	$logged_info = Context::get('logged_info');
	//$user_info->id = $logged_info->user_id;
	Develop::debugPrint($logged_info);
	if(empty($_SESSION['user_info']) && $logged_info->last_login > date(YmdHis,time()-10800)) $_SESSION['user_info'] = $logged_info;
	$user_info = $_SESSION['user_info'];
}
if($install->install_check($db->conn()) != true)
{
	echo "<script type=\"text/javascript\">location.href=\"modules/install/install.php\";</script>";
	exit;
}
//Develop::debugPrint($user_info);
require_once "modules/admin/admin.view.php";
?>
