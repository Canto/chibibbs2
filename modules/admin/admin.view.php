<?php
if(!defined("__CHIBI__")) exit();

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
		<title>Chibi Tool BBS <?=$chibi_ver?> <?=$clang->admin_page?></title>
		<style>
			body{background-color: #cccccc;font-family: "나눔 고딕","Nanum Gothic","돋움","Dotum",Helvetica,Arial,sans-serif;padding:0px;}
			h3{margin:3px;}
			.navbar-toggle .icon-bar { background-color: #428bca; }
			.navbar-toggle:hover{color:#463265;background-color:#f9f9f9}
			.navbar{background-color:#ffffff;}
			th{text-align:center !important;font-size:13px !important}
			td{text-align:center !important;font-size:13px !important}
			.setup p {margin-bottom:0px;}
		</style>
	</head>
	<body>
<?php
if(!$_SESSION["user_info"])
{
	require_once "modules/login/login.view.php";
}
else if($admin->check($_GET['cid'],$user_info))
{
	$requset_cid = "&cid=".$_GET['cid'];
?>

		<header class="navbar navbar-static-top bs-docs-nav" id="top" role="banner">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="./index.php?mid=admin" class="navbar-brand">Chibi Tool BBS <?=$chibi_ver?> <?=$clang->admin_page?></a>
				</div>
				<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">
				<ul class="nav navbar-nav" style="margin-bottom: 0;margin-top: 0;">
					<li>
						<a href="index.php?mid=admin&cAct=adminBoardCreate<?=$requset_cid?>"><?=$clang->board_create?></a>
					</li>
					<li>
						<a href="index.php?mid=admin&cAct=adminBoardList<?=$requset_cid?>"><?=$clang->board_management?></a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right" style="margin-bottom: 0;margin-top: 0;">
					<li>
						<a href="#" class="logout" ><?=$clang->logout?></a>
					</li>
					<li><a href="http://blog.getbootstrap.com" onclick="_gaq.push(['_trackEvent', 'Navbar', 'Community links', 'Blog']);">Blog</a></li>
				</ul>
			</nav>
		</div>
	</header>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default">
					<script>
						(function($){
							$(document).ready(function(){
								$.ajax({
									url : "http://chibi.kr/update3.php",
									type : "GET",
									data : {version:"<?=$chibi_ver?>",lang:"<?=$LANG?>"},
									dataType : "jsonp"
								}).done(function(data){
									$("#divnotice").addClass("alert-info");
									$.each(data,function(i,item){
										$("#notice").append("<li>"+item+"</li>");
									});
								}).fail(function(jqXHR, textStatus){
									$("#divnotice").addClass("alert-danger");
									$("#divnotice").height("20px");
									$("#notice").append("<li>업데이트 서버와의 연결에 실패하였습니다.</li>");
									$("#notice").append("<li>ERROR CODE :"+textStatus+"</li>");
								});
							});
						})(jQuery);
					</script>
					<div class="panel-heading">
						<h4><?=$clang->chibi_notice?></h4>
						<div class="alert" id="divnotice" style="height:200px;overflow:scroll;">
						<ul id="notice" style="padding-left: 20px;"></ul>
						</div>
					</div>
					<div class="panel-body" style="padding: 0px;">
						<?php
						switch($_GET['cAct'])
						{
						case "adminBoardList":
							require_once "modules/admin/admin.view.list.php";
							break;
						case "adminBoardCreate":
							require_once "modules/admin/admin.board.create.view.php";
							break;
						default :
							require_once "modules/admin/admin.view.widget.php";
							break;
						}
						?>

					</div>
			</div>
		</div>
	</div>
<?php
}
else
{
?>
<div class="container">
	<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-danger">
					<?=$clang->is_not_admin?>
				</div>
			</div>
	</div>
</div>
<?php
}
?>
		<script>
			(function($){
				$(document).ready(function(){
					$(".logout").click(function(){
						var logintype = "<?=$user_info->login_type?>";
						if(logintype){
						$.ajax({
							url : "modules/login/login.controller.php",
							type : "POST",
							data : {cAct:"logout"},
							dataType : "json"
						}).done(function(data){
							if(data.status=="success")
							{
								location.reload();
							}
							else
							{
								alert("error");
							}
						}).fail(function(data){
							alert("error");
						});
						}else{
							$.ajax({
								url : "<?=str_replace($_SERVER['DOCUMENT_ROOT'],"/",$XE_PATH);?>?act=dispMemberLogout",
								type : "POST",
								data : {act:"dispMemberLogout"},
								dataType : "html"
							}).done(function(data){
								location.reload()
							}).fail(function(data){
								alert("error");
							});

						}

					});
				});
			})(jQuery);
		</script>
	</body>
</html>