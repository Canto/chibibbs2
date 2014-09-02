<?php
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
session_start();


$HOSTNAME = $_POST['host'];
$USERNAME = $_POST['dbuser'];
$DBPASSWD = $_POST['dbpass'];
$DBNAME = $_POST['dbname'];
$S_ADMIN_ID = $_POST['admin_id'];
$S_ADMIN_PASSWD = $_POST['admin_pass'];
$CMS = $_POST['cms'];
$LANG = $_POST['lang'];
$XE_PATH = $_POST['xepath'];
require_once "../cdb/cdb.class.php";
$DBINFO = array(
	"HOSTNAME" => $HOSTNAME,
	"USERNAME" => $USERNAME,
	"DBPASSWD" => $DBPASSWD,
	"DBNAME" => $DBNAME,
);
$db = new CDB();
$db->set($DBINFO);


/* DB Table 생성 확인*/
$db_check = (object) array("status"=>"","admin"=>"","skin"=>"","pic"=>"","comment"=>"","tpl"=>"","member"=>"","emoticon"=>"","log"=>"","dbname"=>"");
if(is_resource($db->conn())) $db_check->status = true;
else $db_check->status = false;
if(is_resource(@mysql_query("DESC chibi_admin",$db->conn()))) $db_check->admin = true;
else $db_check->admin = false;
if(is_resource(@mysql_query("DESC chibi_skin",$db->conn()))) $db_check->skin = true;
else $db_check->skin = false;
if(is_resource(@mysql_query("DESC chibi_pic",$db->conn()))) $db_check->pic = true;
else $db_check->pic = false;
if(is_resource(@mysql_query("DESC chibi_comment",$db->conn()))) $db_check->comment = true;
else $db_check->comment = false;
if(is_resource(@mysql_query("DESC chibi_tpl",$db->conn()))) $db_check->tpl = true;
else $db_check->tpl = false;
if(is_resource(@mysql_query("DESC chibi_member",$db->conn()))) $db_check->member = true;
else $db_check->member = false;
if(is_resource(@mysql_query("DESC chibi_emoticon",$db->conn()))) $db_check->emoticon = true;
else $db_check->emoticon = false;
if(is_resource(@mysql_query("DESC chibi_log",$db->conn()))) $db_check->log = true;
else $db_check->log = false;
if(is_resource(@mysql_select_db($DBNAME,$db->conn()))) $db_check->dbname = true;
else $db_check->dbname = false;
if($db_check->status == true){

$config_string = "<?php
if(!defined(\"__CHIBI__\")) exit();
\$DBINFO = array(
	\"HOSTNAME\" => \"{$HOSTNAME}\",
	\"USERNAME\" => \"{$USERNAME}\",
	\"DBPASSWD\" => \"{$DBPASSWD}\",
	\"DBNAME\" => \"{$DBNAME}\"
);
\$ADMIN_ID = \"{$S_ADMIN_ID}\";
\$ADMIN_PASSWD = \"".md5($S_ADMIN_PASSWD)."\";
\$LANG = \"lang.{$LANG}.php\";
\$CMS = \"{$CMS}\";
/* Chibi BBS PATH */
\$CHIBI_PATH = str_replace('data/config/db.config.php', '', str_replace('\\\\', '/', __FILE__));
\$XE_PATH =  \$_SERVER['DOCUMENT_ROOT'].\"{$XE_PATH}/\";
?>";

	if(is_dir(dirname(__FILE__)."/../../data/config")==false){ /* config 폴더가 없을경우 */
		mkdir(dirname(__FILE__)."/../../data/config",0755);
		$db_config_file = fopen(dirname(__FILE__)."/../../data/config/db.config.php","w");
		fwrite($db_config_file,$config_string);
		chmod(dirname(__FILE__)."/../../data/config/db.config.php",0644);
		fclose($db_config_file);
	}else{ /* 있을경우 */
		if(!is_writable(dirname(__FILE__)."/../../data/config")){ /* 쓰기 불가 상태일 경우 */
			chmod(dirname(__FILE__)."/../../data/config",0755);
			$db_config_file = fopen(dirname(__FILE__)."/../../data/config/db.config.php","w");
			fwrite($db_config_file,$config_string);
			chmod(dirname(__FILE__)."/../../data/config/db.config.php",0644);
			fclose($db_config_file);
		}else{ /* 쓰기 가능한 상태일 경우 */
			$db_config_file = fopen(dirname(__FILE__)."/../../data/config/db.config.php","w");
			fwrite($db_config_file,$config_string);
			chmod(dirname(__FILE__)."/../../data/config/db.config.php",0644);
			fclose($db_config_file);
		}
	}

	/* sql */
	$admin_string = "CREATE TABLE `chibi_admin` (
`idx` BIGINT NOT NULL AUTO_INCREMENT,
`cid` VARCHAR(255) NOT NULL,
`skin` VARCHAR(255) NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`permission` VARCHAR(255) NOT NULL,
`title` VARCHAR(255) NOT NULL,
`notice` LONGTEXT NOT NULL,
`tag` TEXT NOT NULL,
`spam` LONGTEXT NOT NULL,
`op` LONGTEXT NOT NULL,
PRIMARY KEY (`idx`),
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	$skin_string = "CREATE TABLE `chibi_skin` (
`idx` BIGINT NOT NULL AUTO_INCREMENT,
`cid` VARCHAR(255) NOT NULL,
`skin_name` VARCHAR(255) NOT NULL,
`op` LONGTEXT NOT NULL,
PRIMARY KEY (`idx`),
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	$pic_string = "CREATE TABLE `chibi_pic` (
`idx` BIGINT NOT NULL AUTO_INCREMENT,
`no` INT NOT NULL,
`cid` VARCHAR(255) NOT NULL,
`type` VARCHAR(255) NOT NULL,
`src` TEXT NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`agent` VARCHAR(255) NOT NULL,
`pic_ip` VARCHAR(255) NOT NULL,
`time` INT(10) NOT NULL,
`op` LONGTEXT NOT NULL,
PRIMARY KEY (`idx`),
INDEX (`no`, `cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	$comment_string ="CREATE TABLE `chibi_comment` (
`idx` BIGINT NOT NULL AUTO_INCREMENT,
`cid` VARCHAR(255) NOT NULL,
`pic_no` INT(10) NOT NULL,
`no` INT(10) NOT NULL,
`children` INT(10) NOT NULL,
`depth` INT(10) NOT NULL,
`name` VARCHAR(255) NOT NULL,
`passwd` VARCHAR(255) NOT NULL,
`rtime` INT(10) NOT NULL,
`comment` LONGTEXT NOT NULL,
`memo` VARCHAR(255) NOT NULL,
`hpurl` VARCHAR(255) NOT NULL,
`ip` VARCHAR(255) NOT NULL,
`op` LONGTEXT NOT NULL,
PRIMARY KEY (`idx`),
INDEX (`cid`, `pic_no`,`children`),
FULLTEXT(`comment`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	$emoticon_string = "CREATE TABLE `chibi_emoticon` (
cid varchar(255) NOT NULL,
inst varchar(255) NOT NULL,
url text NOT NULL,INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";
	$log_string = "CREATE TABLE `chibi_log` (
`cid` VARCHAR(255) NOT NULL,
`ip` VARCHAR(255) NOT NULL,
`session` VARCHAR(255) NOT NULL,
`date` INT(10) NOT NULL,
INDEX (`cid`)
) ENGINE = MyISAM CHARACTER SET utf8 COLLATE utf8_general_ci";

	/* admin 초기 옵션 */
	$admin_option = array(
		'secret'=>'off',
		'use_permission'=>'all',
		'btool'=>'off',
		'include_head'=>'',
		'include_foot'=>'',
		'pic_page'=>'5',
		'pic_page_bar'=>'10',
		'pic_max_width'=>'1000',
		'pic_max_height'=>'1000',
		'pic_min_width'=>'50',
		'pic_min_height'=>'50',
		'pic_d_width'=>'300',
		'pic_d_height'=>'300',
		'pic_thumbnail_width'=>'500',
		'showip'=>'off',
		'pic_point'=>'10',
		'comment_point'=>'5'
	);

	/* 기본 게시판 폴더 생성 */
	if(is_dir(dirname(__FILE__)."/../../data/free")==false){
		umask(0);
		mkdir(dirname(__FILE__)."/../../data/free",0755);
		mkdir(dirname(__FILE__)."/../../data/free/tpl",0755);
		mkdir(dirname(__FILE__)."/../../data/free/emoticon",0755);
	}else{
		if(!is_writable(dirname(__FILE__)."/../../data/free")){
			umask(0);
			chmod(dirname(__FILE__)."/../../data/free",0755);
			if(is_dir(dirname(__FILE__)."/../../data/free/emoticon"==false)){
				mkdir(dirname(__FILE__)."/../../data/free/emoticon",0755);
			}
			if(is_dir(dirname(__FILE__)."/../../data/free/tpl"==false)){
				mkdir(dirname(__FILE__)."/../../data/free/tpl",0755);
			}
		}
	}

	/* 어드민 테이블 초기 설정 */
	$admin_notice = array('head'=>'','foot'=>'');
	$admin_tag = "img,embed,object,b,param,strike";
	$admin_spam =  array('ip'=> '','op'=>'ban','word'=>'aloha,viagra');
	$admin_insert_string ="INSERT INTO `chibi_admin` ( `idx`,
`cid`, `skin`, `passwd`, `permission`, `title`, `notice`, `tag`, `spam`, `op`) VALUES ('','free', 'default_ex', MD5('1234'), '', 'Chibi Tool BBS', '".mysql_real_escape_string(serialize($admin_notice))."', '".mysql_real_escape_string($admin_tag)."', '".mysql_real_escape_string(serialize($admin_spam))."', '".mysql_real_escape_string(serialize($admin_option))."');";

	/* admin 테이블 생성 */
	if($db_check->status == true && $db_check->admin == false ){
		mysql_query($admin_string,$db->conn());
		$admin_error = mysql_error();
		if(empty($admin_error)==true){
			mysql_query($admin_insert_string,$db->conn());
			$admin_insert_error = mysql_error();
		}
	}

	/* 스킨 초기 설정 */
	$cid = 'free';
	include_once "../../skin/default_ex/skin.sql.php";
	/* skin 테이블 생성 */
	if($db_check->status == true && $db_check->skin == false ){
		mysql_query($skin_string,$db->conn());
		$skin_error = mysql_error();
		if(empty($skin_error)==true){
			mysql_query($skin_insert_string,$db->conn());
			$skin_insert_error = mysql_error();
		}
	}

	/* 템플릿 초기 설정 */

	require_once "../template/template.class.php";
	$tpl = new Template();
	$tpl_op = fopen(dirname(__FILE__)."/../../skin/default_ex/layout.php", "r");
	$tpl_file = '';
	while (!feof($tpl_op)){
		$tpl_file = $tpl_file.fgets($tpl_op);
	}
	$fp=fopen(dirname(__FILE__)."/../../data/free/tpl/free.tpl.php","w");
	fwrite($fp,$tpl_file);
	fclose($fp);
	fclose($tpl_op);
	chmod(dirname(__FILE__)."/../../data/free/tpl/free.tpl.php",0644);
	$content = $tpl->convert($tpl_file);
	$fp=fopen(dirname(__FILE__)."/../../data/".$cid."/tpl/".$cid.".tpl.compiled.php","w");
	fwrite($fp,$content);
	fclose($fp);
	chmod(dirname(__FILE__)."/../../data/".$cid."/tpl/".$cid.".tpl.compiled.php",0644);

	/* log 테이블 생성*/
	if($db_check->status == true && $db_check->log == false ){
		mysql_query($log_string,$db->conn());
		$log_error = mysql_error();
	}

	/* pic 테이블 생성*/
	if($db_check->status == true && $db_check->pic == false ){
		mysql_query($pic_string,$db->conn());
		$pic_error = mysql_error();
	}

	/* pic 테이블 생성*/
	if($db_check->status == true && $db_check->comment == false ){
		mysql_query($comment_string,$db->conn());
		$comment_error = mysql_error();
	}


	/* emoticon 테이블 생성 */
	if($db_check->status == true && $db_check->emoticon == false ){
		mysql_query($emoticon_string,$db->conn());
		$emoticon_error = mysql_error();
	}
?>
	<!DOCTYPE html>
	<html lang="ko">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=3.0">
		<meta name="robots" content="noindex,nofollow">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
		<title>Chibi Tool BBS v2.0 Install</title>
		<style>
			body{background-color: #666666;font-family: "나눔 고딕","Nanum Gothic","돋움","Dotum",Helvetica,Arial,sans-serif;padding:10px;}
			h3{margin:3px;}
			.panel-body{padding:0px;}
			.table{margin-bottom:0px;}
		</style>
	</head>
	<body>
	<div class="container">
		<div class="row">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>서버 환경 체크</h3>
				</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr class="info">
								<th colspan="3">DB 정보 파일 생성 결과</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="3"><?php if(is_file(dirname(__FILE__)."/../../data/config/db.config.php")) echo "<p class=\"text-success\">DB 정보 파일 생성 성공</p>";else echo "<p class=\"text-danger\">DB 정보 파일 생성 실패</p>";?></td>
							</tr>
						</tbody>
						<thead>
						<tr class="info">
							<th class="col-md-3">DB 테이블 명</th>
							<th class="col-md-2">상태</th>
							<th class="col-md-7">상세</th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td>chibi_admin(게시판)</td>
							<td>
								<?php
								if($db_check->admin==true) echo "<p class=\"text-info\">이미 존재 함</p>";
								else if($db_check->admin==false && isset($admin_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
								else echo "<p class=\"text-danger\">오류(상세참고)</p>"
								?>
							</td>
							<td><?php if(isset($admin_error)==true) echo "<p class=\"text-danger\">".$admin_error."</p>";?></td>
						</tr>
						<tr>
							<td>chibi_skin(스킨)</td>
							<td>
								<?php
								if($db_check->skin==true) echo "<p class=\"text-info\">이미 존재 함</p>";
								else if($db_check->skin==false && isset($skin_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
								else echo "<p class=\"text-danger\">오류(상세참고)</p>"
								?>
							</td>
							<td><?php if(isset($skin_error)==true) echo "<p class=\"text-danger\">".$skin_error."</p>";?></td>
						</tr>
						<tr>
							<td>chibi_pic(그림)</td>
							<td>
								<?php
								if($db_check->pic==true) echo "<p class=\"text-info\">이미 존재 함</p>";
								else if($db_check->pic==false && isset($pic_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
								else echo "<p class=\"text-danger\">오류(상세참고)</p>"
								?>
							</td>
							<td><?php if(isset($pic_error)==true) echo "<p class=\"text-danger\">".$pic_error."</p>";?></td>
						</tr>
						<tr>
							<td>chibi_comment(코멘트)</td>
							<td>
								<?php
								if($db_check->comment==true) echo "<p class=\"text-info\">이미 존재 함</p>";
								else if($db_check->comment==false && empty($comment_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
								else echo "<p class=\"text-danger\">오류(상세참고)</p>"
								?>
							</td>
							<td><?php if(isset($comment_error)==true)  echo "<p class=\"text-danger\">".$comment_error."</p>";?></td>
						</tr>
						<tr>
							<td>chibi_log(로그)</td>
							<td>
								<?php
								if($db_check->log==true) echo "<p class=\"text-info\">이미 존재 함</p>";
								else if($db_check->log==false && empty($log_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
								else echo "<p class=\"text-danger\">오류(상세참고)</p>"
								?>
							</td>
							<td><?php if(isset($log_error)==true) echo "<p class=\"text-danger\">".$log_error."</p>";?></td>
						</tr>
						<tr>
							<td>chibi_emoticon(이모티콘)</td>
							<td>
								<?php
								if($db_check->emoticon==true) echo "<p class=\"text-info\">이미 존재 함</p>";
								else if($db_check->emoticon==false && empty($emoticon_error)==true) echo "<p class=\"text-success\">생성 완료</p>";
								else echo "<p class=\"text-danger\">오류(상세참고)</p>"
								?>
							</td>
							<td><?php if(isset($emoticon_error)==true) echo "<p class=\"text-danger\">".$emoticon_error."</p>";?></td>
						</tr>
						<tr>
							<td colspan="3">
								<?php if((empty($admin_error) && empty($skin_error) && empty($pic_error) && empty($comment_error) && empty($member_error) && empty($tpl_error) && empty($log_error))==true){
									echo "<a class=\"btn btn-primary\" href=\"../../index.php?mid=admin\">설치완료</a>";
								}else{
									echo "<a class=\"btn btn-primary\" href=\"install.php\">돌아가기</a><span class=\"help-block\">오류 항목이 있습니다. 오류 항목을 확인하세요.</span>";
								}?>
							</td>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	</body>
	</html>
<?
}
?>
