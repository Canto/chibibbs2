<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_set_cookie_params(0);
session_start();
define("__CHIBI__",time());

/* check database config file */
if(is_file('data/config/db.config.php')==false){
	echo "<script type=\"text/javascript\">location.href=\"modules/install/install.php\";</script>";
}

/* Set BBS */
require_once "data/config/db.config.php";
require_once "lang/lang.ko.php";
require_once "classes/Develop.class.php";
require_once "classes/DB.class.php";
require_once "classes/Paging.class.php";
require_once "classes/Board.class.php";
require_once "classes/Install.class.php";
require_once "classes/Display.class.php";

/* Set DB */
$db = new DB();
$db->set($DBINFO);
/* Check Installed Board */
$install = new Install();
$install->install_check($db->conn());

/* Check Board ID */
if(!isset($_GET['cid']) || empty($_GET['cid'])){ /* If $_GET['cid'] is empty */
	echo "<script language=\"javascript\">alert(\"".$lang->cid_empty."\");</script>";
	exit;
}

/* Set Display Function */
$display = new Display();
/* Set board info, if have a cid. */
$bbs = new Board();
$board = $bbs->select($_GET['cid'],$db->conn());
/* Set board skin info , if have a cid */
$skin = $bbs->gets_skin();

/* include user function file, if user function file exists */
if(file_exists("skin/".$board->skin."/user.fn.php")) include_once 'skin/'.$board->skin.'/user.fn.php';

/* Check Spam IP */
$bbs->ip_check();

/* If board is empty  */
if(!isset($_GET['cid']) || empty($board->cid)==true){
	echo "<script language=\"javascript\">alert(\"".$lang->board_empty."\");</script>";
	exit;
}
if(!empty($_GET['search'])) $search = $_GET['search'];
else $search = NULL;
if(!empty($_GET['keyword'])) $keyword = $_GET['keyword'];
else $keyword = NULL;
if(empty($_GET['page'])) $_GET['page'] = 1;
/* Set board paging */
switch($search){
	case "name" :
		$sql = "SELECT count(`chibi_pic`.`idx`) FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`name`LIKE'".mysql_real_escape_string($keyword)."' AND  `chibi_comment`.`cid`='".mysql_real_escape_string($_GET['cid'])."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC ";
		break;
	case "comment" :
		$sql = "SELECT count(`chibi_pic`.`idx`) FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`comment` LIKE '%".mysql_real_escape_string($keyword)."%' AND  `chibi_comment`.`cid` =  '".mysql_real_escape_string($_GET['cid'])."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC";
		break;
	case "memo" :
		$sql = "SELECT count(`chibi_pic`.`idx`) FROM  `chibi_pic` LEFT JOIN  `chibi_comment` ON  `chibi_pic`.`no` =  `chibi_comment`.`pic_no` WHERE  `chibi_comment`.`memo` LIKE '%".mysql_real_escape_string($keyword)."%' AND  `chibi_comment`.`cid` =  '".mysql_real_escape_string($_GET['cid'])."' GROUP BY `chibi_pic`.`no` ORDER BY  `chibi_pic`.`no` DESC";
		break;
	case "no" :
		$sql = "SELECT count(no) FROM `chibi_pic` WHERE cid='".mysql_real_escape_string($_GET['cid'])."' AND no='".mysql_real_escape_string($keyword)."'";
		break;
	default :
		$sql = "SELECT count(no) FROM `chibi_pic` WHERE cid='".mysql_real_escape_string($_GET['cid'])."'";
		break;
}

$total = $db->row($db->query($sql));
$page = new Paging($_GET['page'],$board->op->pic_page,$board->op->pic_page_bar,$total);
$page->setUrl('cid='.$board->cid);
if(empty($_GET['search'])==false) $page->setUrl('search='.$_GET['search']);
if(empty($_GET['keyword'])==false) $page->setUrl('keyword='.$_GET['keyword']);
if($_GET['page']==1) $start = 0;
$page->setDisplay('prev_btn','<');
$page->setDisplay('next_btn','>');
$page->setDisplay('start_btn','>>');
$page->setDisplay('end_btn','>>');
$page->setDisplay('full');
if($total != 0) $paging = $page->showPage();
else $paging = '';

/* include skin file */
require_once "skin/".$board->skin."/index.layout.php";

?>
