<?php
if(!defined("__CHIBI__")) exit();
if($user_info->is_admin=="Y"){
	?>
	<form class="form-horizontal" method="post" action="index.php?mid=admin&cAct=adminBoardCreateOk">
		<table class="table table-bordered setup">
			<thead>
			<tr>
				<th colspan="2"><?=$clang->create_board?></th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->board_id?></td>
				<td>
					<input type="text" id="cid" name="cid" class="form-control" onblur="checkID()" placeholder="<?=$clang->board_id?>" required="required"/>
					<p class="text-left help-block" ><span id="chk_id"></span><?=$clang->help_board_id?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->set_skin?></td>
				<td>
					<select name="skin" class="form-control">
						<?php
						foreach(glob("./skin/*",GLOB_ONLYDIR) as $value){
							$skin = explode("/",$value);
							if($skin[2]=="default_ex")$s_chk="selected";
							else $s_chk="";
							echo "<option vlaue=\"".$skin[2]."\" ".$s_chk." >".$skin[2]."</option>";
						}
						?>
					</select>
					<p class="text-left help-block"><?=$clang->help_set_skin?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->board_titile?></td>
				<td>
					<input class="form-control" type="text" name="title" placeholder="<?=$clang->board_title?>" required="required" >
					<p class="text-left help-block"><?=$clang->help_board_title?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->board_secret?></td>
				<td>
					<select name="secret" class="form-control" >
						<option value="N"><?=$clang->board_secret_select_no?></option>
						<option value="Y"><?=$clang->board_secret_select_yes?></option>
					</select>
					<p class="text-left help-block"><?=$clang->help_board_secret?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->board_secret_password?></td>
				<td>
					<input class="form-control" type="password" name="board_secret_password" placeholder="<?=$clang->board_secret_password?>" required="required">
					<p class="text-left help-block"><?=$clang->hepl_board_secret_password?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->use_permission?></td>
				<td>
					<select name="use_permission" class="form-control">
						<option value="all"><?=$clang->user_permission_all?></option>
						<option value="member-b"><?=$clang->user_permission_member_b?></option>
						<option value="member-cms"><?=$clang->user_permission_member_cms?></option>
						<option value="admin"><?=$clang->user_permission_admin?></option>
					</select>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->member_b_password?></td>
				<td>
					<input class="form-control" type="password" name="member_b_password" />
					<p class="text-left help-block"><?=$clang->help_member_b_password?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->pic_page?></td>
				<td>
					<input class="form-control" type="number" name="pic_page"/>
					<p class="text-left help-block"><?=$clang->help_pic_page?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->pic_page_bar?></td>
				<td>
					<input class="form-control" type="number" name="pic_page_bar"/>
					<p class="text-left help-block"><?=$clang->help_pic_page_bar?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->pic_max_width?></td>
				<td>
					<input class="form-control" type="number" name="pic_max_width"/>
					<p class="text-left help-block"><?=$clang->help_pic_max_width?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->pic_max_height?></td>
				<td>
					<input class="form-control" type="number" name="pic_max_height"/>
					<p class="text-left help-block"><?=$clang->help_pic_max_height?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->pic_min_width?></td>
				<td>
					<input class="form-control" type="number" name="pic_min_width"/>
					<p class="text-left help-block"><?=$clang->help_pic_min_width?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->pic_min_height?></td>
				<td>
					<input class="form-control" type="number" name="pic_min_height"/>
					<p class="text-left help-block"><?=$clang->help_pic_min_height?></p>
				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->position?></td>
				<td >
					<div class="col-lg-3 col-md-2 col-sm-2 col-xs-2" style="line-height: 34px;"><?=$clang->position_num?></div>
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="padding: 0;margin-bottom:10px;"><input class="form-control" type="number" id="position-num"></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" ><button class="form-control btn-primary" id="p-add" type="button"><?=$clang->add?></button></div>
					<div class="position-title">
						<table class="table table-bordered" id="position" >
							<thead>
							<tr>
								<th><?=$clang->inst?></th>
								<th><?=$clang->position_img?></th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td><input class="form-control" type="text" name="inst[0]" /></td>
								<td><input class="form-control" type="text" name="position[0]" /></td>
							</tr>
							</tbody>
						</table>
					</div>
					<p class="text-left help-block"><?=$clang->help_position?></p>

				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->position?>2</td>
				<td >
					<div class="col-lg-3 col-md-2 col-sm-2 col-xs-2" style="line-height: 34px;"><?=$clang->position_num?></div>
					<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5" style="padding: 0;margin-bottom:10px;"><input class="form-control" type="number" id="position-num2"></div>
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" ><button class="form-control btn-primary" id="p-add2" type="button"><?=$clang->add?></button></div>
					<div class="position-title">
						<table class="table table-bordered" id="position2" >
							<thead>
							<tr>
								<th><?=$clang->inst?></th>
								<th><?=$clang->position_img?></th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<td><input class="form-control" type="text" name="inst2[0]" /></td>
								<td><input class="form-control" type="text" name="position2[0]" /></td>
							</tr>
							</tbody>
						</table>
					</div>
					<p class="text-left help-block"><?=$clang->help_position?></p>

				</td>
			</tr>
			<tr>
				<td class="col-lg-3 col-md-3 col-sm-3 col-xs-3"><?=$clang->ip_show?></td>
				<td>

				</td>
			</tr>
			</tbody>
	</table>
	</form>
	<script>
		(function($){
			$(document).ready(function(){
				$("#p-add").click(function(){
					var cnt = $('#position > tbody > tr').length;
					var num = $('#position-num').val();
					if(cnt > num) $('#position > tbody > tr').slice(num,cnt).remove();
					else {
						for(i=cnt;i<num;i++){
							$('#position > tbody').append('<tr>' +
								'<td><input class="form-control" type="text" name="inst['+i+']"/></td>' +
								'<td><input class="form-control" type="text" name="position['+i+']"/></td>' +
								'</tr>');
						}
					}
				});
				$("#p-add2").click(function(){
					var cnt2 = $('#position2 > tbody > tr').length;
					var num2 = $('#position-num2').val();
					if(cnt2 > num2) $('#position2 > tbody > tr').slice(num2,cnt2).remove();
					else {
						for(i=cnt2;i<num2;i++){
							$('#position2 > tbody').append('<tr>' +
								'<td><input class="form-control" type="text" name="inst2['+i+']"/></td>' +
								'<td><input class="form-control" type="text" name="position2['+i+']"/></td>' +
								'</tr>');
						}
					}
				});
			});
		})(jQuery);
		function checkID(){
			$.ajax({
				url: './modules/admin/admin.board.id.check.php',
				type: 'POST',
				data: {'cid':$('#cid').val()},
				dataType: 'html',
				success: function(data){
					if(data == true){
						$("#chk_id").removeClass().text("");
						$("#chk_id").addClass("text-success").prepend("<?=$clang->board_id_available?><br/>");
					}else{
						$("#chk_id").removeClass().text("");
						$("#chk_id").addClass("text-danger").prepend("<?=$clang->board_id_unavailable?><br/>");
						$("#cid").focus();
					}
				}
			});
		}
	</script>
<?php
}else{
	?>
	<div class="span6 offset3 alert alert-error margin20">
		<a class="close" href="javascript:history.go(-1);">&times;</a>
		접속권한이 없습니다.<br/>
		최고 관리자만 접속 가능한 페이지 입니다.<br/><br/>
		<a class="btn btn-danger" href="javascript:history.go(-1);">돌아가기</a>
	</div>
<?php
}
?>