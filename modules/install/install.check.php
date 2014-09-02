<?php
header ('Content-type: text/html; charset=UTF-8');
define("__CHIBI__",time());
session_start();

require_once "../cdb/cdb.class.php";


$HOSTNAME = $_POST['host'];
$USERNAME = $_POST['dbuser'];
$DBPASSWD = $_POST['dbpass'];
$DBNAME = $_POST['dbname'];
$S_ADMIN_ID = $_POST['admin_id'];
$S_ADMIN_PASSWD = $_POST['admin_pass'];
$CMS = $_POST['cms'];
$LANG = $_POST['lang'];
if(!empty($_POST['xepath'])){
	if($_POST['xepath']=="./") $XE_PATH = $_SERVER['DOCUMENT_ROOT'];
	else $XE_PATH = $_POST['xepath'];
}else{
	$XE_PATH = '';
}
$DBINFO = array(
	"HOSTNAME" => $HOSTNAME,
	"USERNAME" => $USERNAME,
	"DBPASSWD" => $DBPASSWD,
	"DBNAME" => $DBNAME,
);
$db = new CDB();
$db->set($DBINFO);

if(is_resource($db->conn())) $db_check = true;
else $db_check = false;
$php = phpversion();
if(version_compare($php,'5.0','>'))$php_check = true;
else $php_check = false;
$mysql = @mysql_get_server_info($db->conn());
if(version_compare($mysql,'5.0','>')) $mysql_check = true;
else $mysql_check = false;
$query = @mysql_query("SHOW CHARACTER SET WHERE `Charset`='utf8';",$db->conn());
$array = @mysql_fetch_array($query);
$encoding = $array['Default collation'];
if($encoding == 'utf8_general_ci') $encoding_check = true;
else $encoding_check = false;
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
			<?php
			if($db_check == false){/* DB 정보가 틀렸을 경우 */
				?>
				<div id="installed" class="alert alert-danger">
					<a class="close" href="javascript:history.go(-1);">&times;</a>
					<p class="text-danger">DB 정보가 틀립니다. 호스팅업체에서 다시 확인하시기 바랍니다.</p><br/><br/>
					<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
				</div>
				<script type="text/javascript">
					$('#installed').bind('closed', function () {
						history.go(-1);
					})
				</script>
			<?php
			}else{
			?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3>서버 환경 체크</h3>
				</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<thead>
							<tr class="info">
								<th></th>
								<th>서버 정보</th>
								<th>설치 최소 사양 ( 권장사양 )</th>
								<th>설치 가능 여부</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><p class="text-info">PHP 버젼</p></td>
								<td><p class="text-info"><?=$php?></p></td>
								<td><p class="text-info">5.0 ( 5.1.3 이상 )</p></td>
								<td><?php if($php_check==true){ echo "<p class=\"text-success\"><b>설치가능</b></p>";}else{ echo "<p class=\"text-error\"><b>설치불가</b></p>";}?></td>
							</tr>
							<tr>
								<td><p class="text-info">Mysql 버젼</p></td>
								<td><p class="text-info"><?=$mysql?></p></td>
								<td><p class="text-info">5.0</p></td>
								<td><?php if($mysql_check==true){ echo "<p class=\"text-success\"><b>설치가능</b></p>";}else{ echo "<p class=\"text-error\"><b>설치불가</b></p>";}?></td>
							</tr>
							<tr>
								<td><p class="text-info">Mysql 인코딩(UTF-8)체크</p></td>
								<td colspan="3"><?php if($encoding_check==true){ echo "<p class=\"text-success\"><b>UTF-8 지원</b></p>";}else{ echo "<p class=\"text-error\"><b>UTF-8 지원안함</b></p>";}?></td>
							</tr>
							<tr>
								<td colspan="4">
									<form method="post" id="install" action="install.ok.php" class="form-horizontal">
										<input type="hidden" name="mode" value="install">
										<input type="hidden" name="type" value="install">
										<input type="hidden" name="host" value="<?=$HOSTNAME?>">
										<input type="hidden" name="dbuser" value="<?=$USERNAME?>">
										<input type="hidden" name="dbpass" value="<?=$DBPASSWD?>">
										<input type="hidden" name="dbname" value="<?=$DBNAME?>">
										<input type="hidden" name="admin_id" value="<?=$S_ADMIN_ID?>">
										<input type="hidden" name="admin_pass" value="<?=$S_ADMIN_PASSWD?>">
										<input type="hidden" name="cms" value="<?=$CMS?>">
										<input type="hidden" name="lang" value="<?=$LANG?>">
										<input type="hidden" name="xepath" value="<?=$XE_PATH?>">
										<div class="control-group pull-right">
											<?php if(($php_check && $mysql_check && $encoding_check) == true){
												?>
												<button type="submin" class="btn btn-primary">다음 단계</button>
											<?
											}else{
												?>
												<a class=\"btn btn-primary\" href=\"install.setup.php\">돌아가기</a><span class=\"help-block\">오류 항목이 있습니다. 오류 항목을 확인하세요.</span>
											<?php
											}
											?>
										</div>
									</form>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>