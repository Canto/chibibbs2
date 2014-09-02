<?php
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');
header ('Cache-Control: no-cache, must-revalidate');
header ('Pragma: no-cache');
header ('Content-type: text/html; charset=UTF-8');
session_start();
define("__CHIBI__",time());

if(empty($_GET['lang'])) $lang = "ko";
else $lang = $_GET['lang'];
require_once "../../lang/lang.$lang.php";
require_once "../../classes/classes.php";
if(is_file("../../data/config/db.config.php")){
require_once "../../data/config/db.config.php";
/* Set DB */
$db = new CDB();
$db->set($DBINFO);
/* Check Installed Board */
$install = new Install();

if($install->install_check($db->conn())==true){
	echo "<script type='text/javascript'>
			alert('".$clang->installed."');
		 </script>";
	exit;
}
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
		.xe{display: none;}
	</style>
	<script>
		(function($){
			$(document).ready(function(){
			$("#cms").change(function(){
				if($(this).val()=="xe")
				{
					$(".xe").show();
					$(".xe").html('<label class="col-md-2 control-label" for="xepath">XE 설치 위치</label><div class="col-md-10"><input class="form-control" type="text" id="xepath" name="xepath" placeholder="XE 설치 위치" required><span class="help-block">XE 설치 폴더명을 적어주세요. (최상단 폴더일 경우 ./ 를 넣어주세요.)</span></div>');
				}
				else
				{
					$(".xe").hide();
				}
			});
			});
		})(jQuery);
	</script>
</head>
<body>
	<div class="container">
	<div class="row col-md-12 col-lg-12">

		<div class="panel panel-default">
			<div class="panel-heading title">
				<h3>Chibi Tool BBS v2.0 Install</h3>
				<div id="license" class="well">
					<?php echo $clang->license;?>
				</div>
			</div>
			<div class="panel-body">
				<?php
					if(!is_writable('../../data')){
				?>
				<div class="alert alert-danger">
					data 폴더의 권한이 <b>707</b> 혹은 <b>777</b>이 아닙니다<br/>
					data 폴더의 권한을 확인해주세요.
				</div>
				<? }else{ ?>
				<form class="form-horizontal" role="form" method="post" id="install" action="install.check.php">
					<input type="hidden" name="mode" value="install">
					<input type="hidden" name="type" value="install">
				<div class="form-group">
					<label class="col-md-2 control-label" for="lang">설치 언어</label>
					<div class="col-md-10">
						<select name="lang" id="lang" class="form-control">
							<option value="ko">한국어</option>
							<option value="en">English</option>
							<option value="jp">日本語</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="cms">연동 CMS(툴)</label>
					<div class="col-md-10">
						<select name="cms" id="cms" class="form-control">
							<option value="none">연동 안함</option>
							<option value="xe">XE ( Xpress Engine )</option>
							<option value="gnu">그누보드</option>
						</select>
						<span class="help-block">Chibi Tool BBS 와 연동 할 프로그램을 선택 할 수 있습니다.</span>
					</div>
				</div>
				<div class="form-group xe">

				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="host">호스트</label>
					<div class="col-md-10">
						<input class="form-control" type="text" id="host" name="host" placeholder="호스트명" required value="localhost">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="dbname">DB 이름</label>
					<div class="col-md-10">
						<input class="form-control" type="text" id="dbname" name="dbname" placeholder="DB 이름" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="dbuser">DB 유저 아이디</label>
					<div class="col-md-10">
						<input class="form-control" type="text" id="dbuser" name="dbuser" placeholder="DB 유저 아이디" required>
						<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 아이디를 입력하세요.</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="dbpass">DB 패스워드</label>
					<div class="col-md-10">
						<input class="form-control" type="password" id="dbpass" name="dbpass" placeholder="DB 패스워드" required>
						<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 패스워드를 입력하세요.</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="admin_id">최고관리자 아이디</label>
					<div class="col-md-10">
						<input class="form-control" type="text" id="admin_id" name="admin_id" placeholder="최고관리자 아이디"  required>
						<span class="help-block">치비BBS 전체를 관리 할 수 있는 관리자 아이디를 입력하세요.</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="admin_pass">최고관리자 패스워드</label>
					<div class="col-md-10">
						<input class="form-control" type="password" id="admin_pass" name="admin_pass" placeholder="최고관리자 패스워드"  required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-2 control-label" for="admin_pass2">최고관리자 패스워드(확인)</label>
					<div class="col-md-10">
						<input class="form-control" type="password" id="admin_pass2" name="admin_pass2" placeholder="최고관리자 패스워드(확인)"  required>
						<span class="help-block">최고 관리자패스워드를 다시 한번 적어주세요.</span>
					</div>
				</div>
				<div class="form-group pull-right" style="margin-right: 5px;">
					<button type="submin" class="btn btn-primary">설치</button>
				</div>
				<script type="text/javascript">
					(function($){
						$(document).ready(function(){
							$("form").submit(function(){
								var pattern = /^[a-z]+[a-z0-9]*$/;
								if($("#admin_id").val() == ""){
									alert("최고관리자 ID를 입력해 주세요.");
									$("#admin_id").focus();
									return false;
								}else if(!pattern.test($("#admin_id").val())){
									alert("최고관리자 ID는 영문 소문자 혹은 영문(소문자)+숫자로만 입력가능합니다.");
									$("#admin_id").focus();
									return false;
								}
								if($("#admin_pass").val() == ""){
									alert("최고관리자 패스워드를 입력해 주세요.");
									$("#admin_pass").focus();
									return false;
								}
								if($("#admin_pass").val() != $("#admin_pass2").val()){
									alert("최고관리자 패스워드가 동일하지 않습니다.");
									$("#admin_pass").focus();
									return false;
								}
								if($("#cms").val() == "xe"){
									if($("#xepath").val()==""){
									alert("XE 설치 위치를 적어주세요.");
									$("#xepath").focus();
									return false;
									}
								}
								return true;
							});
						});

					})(jQuery);
				</script>
				<?php } ?>
			</div>
		</div>
		</form>
	</div>
	</div>
</body>
</html>
