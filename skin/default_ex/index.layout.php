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
	<title><?php echo $board->title?></title>
	<link href="skin/<?=$board->skin?>/skin.css" rel="stylesheet">
	<style type="text/css">
		<?php include "skin/".$board->skin."/skin.css.php"; /* 유저설정 CSS */ ?>
	</style>
	<style>
		.row{padding:10px !important;}
		ul li{list-style-type: none;}
		.pic, .comment{float:left;display: table-cell;padding:0px;}
		.panel-body{padding:0px !important;}
		.panel-heading{padding: 0px !important;}
		.content{height:100%;position: relative;padding:0px;margin:0px;}
		.pic {border-right:1px solid #eee;}
		.title{padding:2px 0px 2px 5px !important;}
		.footer{width:100%;text-align:right;}
		.paging-bar{text-align: center;}
	</style>
</head>
<body>
<?php
	if($board->op->include_head) require_once $board->op->include_head;

	switch($act)
	{
		case "picDraw" :
			require_once "./modules/draw.php";
			break;
		case "picContinue" :
			require_once "./modules/draw.php";
			break;
		default :
			require_once "./data/".$board->cid."/tpl/".$board->cid.".tpl.compiled.php";
			break;
	}

	if($board->op->include_foot) require_once $board->op->include_foot;
?>
<?php

?>
	<div class="footer col-md-12">
		<p class="pull-right">
			Chibi Tool BBS ver <?=$chibi_ver?> &copy; <a href='http://canto.btool.kr' target='_blank'>Canto</a>
			<?php if(!empty($skin->op->author)){?>
				| Skin by <?=$skin->op->author?>
			<?}?>
		</p>
	</div>
</body>
</html>
