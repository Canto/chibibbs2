<?php
/*
게시판 스킨 설정 SQL Query 처리 페이지
filename : skin.sql.php
========== 설정 방법 =============
각 변수에 사용자변수 추가 가능
개행(줄바꿈) 을 한뒤 변수를 추가
ex) $d_op->변수명 = '변수값'
*/

/////////////////////////////////////////////////////////////////
$d_op = new stdClass(); // 수정 금지

/*기본 설정*/
$d_skin = "default_EX"; //스킨명 (영문,폴더명과 일치하여야함)
//$d_op->author = '<a href="http://canto.btool.kr" target="_blank">Canto</a>', /*스킨제작자 표시용 앞 주석제거후 사용*/		
$d_op->backgroud_color = '#ffffff';
$d_op->background_img = '';
$d_op->repeat = '';
$d_op->notice_border_color = '';
$d_op->notice_border_type = '';
$d_op->table_border_color = '#dddddd';
$d_op->table_border_size = '1px';
$d_op->table_border_type = 'solid';
$d_op->table_inner_border_color = '#dddddd';
$d_op->table_inner_border_size = '1px';
$d_op->table_inner_border_type = 'solid';
$d_op->pic_border_hover='';
$d_op->pic_background_color='#ffffff';
$d_op->table_background_color='#ffffff';
$d_op->reply_background_color='#ffffff';
$d_op->reply_text_color='';
$d_op->rereply_bar_color='';
$d_op->rereply_text_color='';
$d_op->top_menu_icon_color='';
$d_op->resize='400';
$d_op->table_down='9999';
$d_op->size='show';
$d_op->tool='show';
$d_op->time='show';
$d_op->time_type='Y년m월d일 H시i분s초';
$d_op->more_icon='<img src="skin/default_EX/images/more.png">';
$d_op->secret_icon='<img src="skin/default_EX/images/secret.png">';
$d_op->btool_icon='<img src="skin/default_EX/images/btool.png">';
$d_op->chibi_icon='<img src="skin/default_EX/images/chibi.png">';
$d_op->load_icon='<img src="skin/default_EX/images/load.png">';
$d_op->reply_icon='<img src="skin/default_EX/images/re.png">';
$d_op->modify_icon='<img src="skin/default_EX/images/mod.png">';
$d_op->del_icon='<img src="skin/default_EX/images/del.png">';
$d_op->emoticon_icon='<img src="skin/default_EX/images/emoticon.png">';
$d_op->continue_icon='<img src="skin/default_EX/images/continue.png">';
$d_op->login_icon='<img src="skin/default_EX/images/login.png">';
$d_op->logout_icon='<img src="skin/default_EX/images/logout.png">';
$d_op->op_icon='<img src="skin/default_EX/images/op.png">';
$d_op->reflash_icon='<img src="skin/default_EX/images/reflash.png">';
$d_op->admin_icon='<img src="skin/default_EX/images/admin.png">';
$d_op->write_icon='<input type="image" src="skin/default_EX/images/write.png" class="cmtmodify-submit" />';
$d_op->hp_icon='<img src="skin/default_EX/images/hp.png">';
$d_op->pinater_icon='[작가글]';




/* 이 아래로는 수정하지 말것!!! 수정시 일어나는 오류에 대해선 책임 지지 않음 */
if(!isset($op)) $op = NULL;
//게시판 생성시 초기 설정
$skin_insert_string = "INSERT INTO `chibi_skin` (`idx`, `cid`, `skin_name`, `op`) VALUES ('', '".mysql_real_escape_string($cid)."', '".mysql_real_escape_string($d_skin)."','".mysql_real_escape_string(serialize($d_op))."')";
//게시판설정에서 스킨변경시 초기 설정
$uskin_db = "UPDATE `chibi_skin` SET `cid`='".mysql_real_escape_string($cid)."',  `skin_name`='".mysql_real_escape_string($d_skin)."', `op`='".mysql_real_escape_string(serialize($d_op))."' WHERE `cid`='".mysql_real_escape_string($cid)."'";
//스킨설정 페이지에서 업데이트시 설정
$update_db = "UPDATE `chibi_skin` SET `cid`='".mysql_real_escape_string($cid)."',  `skin_name`='".mysql_real_escape_string($d_skin)."', `op`='".mysql_real_escape_string(serialize($op))."' WHERE `cid`='".mysql_real_escape_string($cid)."' and `skin_name`='".mysql_real_escape_string($d_skin)."'";
?>