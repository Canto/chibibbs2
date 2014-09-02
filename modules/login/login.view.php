<div class="container">
<div class="row">
<div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-10 col-xs-offset-1">
	<div class="panel panel-default" style="margin-top: 30px;">
		<div class="panel-heading">
			<?=$clang->login?>
		</div>
		<div class="panel-body">
			<?php if($_SESSION['XE_VALIDATOR_MESSAGE']){ ?>
				<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 alert alert-danger" style="margin-top:10px;margin-bottom:10px;">
					<?php
					echo $_SESSION['XE_VALIDATOR_MESSAGE'];
					unset($_SESSION['XE_VALIDATOR_MESSAGE']);
					?>
				</div>
			<?php } else if(!isset($user_info->id)){ ?>
			<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 alert alert-danger" style="margin-top:10px;margin-bottom:10px;">
				<?=$clang->is_not_login?>
			</div>
			<?php } ?>

			<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top: 10px">
			<form class="form-horizontal" role="form" id="login" method="post" action="<?=str_replace($_SERVER['DOCUMENT_ROOT'],"/",$XE_PATH);?>?act=procMemberLogin">
				<div class="form-group">
					<label for="type" class="col-md-2 col-xs-3 col-sm-2 control-label">Type</label>
					<div class="col-md-10 col-xs-9 col-sm-10">
						<select id="type" class="form-control">
							<?php if($CMS=="xe"){?><option value="xeboard"><?=$clang->admin_type_xeboard?></option><?php }?>
							<option value="board"><?=$clang->admin_type_board?></option>
							<option value="super"><?=$clang->admin_type_super?></option>
						</select>
					</div>
				</div>

				<div class="form-group">
					<label for="id" class="col-md-2 col-sm-2 col-xs-3 control-label">ID</label>
					<div class="col-md-10 col-sm-10 col-xs-9 ">
						<input type="text" class="form-control" name="user_id" id="user_id" placeholder="ID">
					</div>
				</div>
				<div class="form-group">
					<label for="password" class="col-md-2 col-sm-2 col-xs-3 control-label">Password</label>
					<div class="col-md-10 col-sm-10 col-xs-9 ">
						<input type="password" class="form-control" name="password" id="password" placeholder="Password">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-2 col-md-10 col-sm-10 col-xs-9 col-sm-offset-2 col-xs-offset-3 ">
						<button type="submit" id="signin" class="btn btn-primary"><?=$clang->login?></button>
					</div>
				</div>
				<input type="hidden" id="cid" value="<?=$_GET['cid']?>">
				<input type="hidden" name="error_return_url" value="<?=$_SERVER['REQUEST_URI']?>">
				<input type="hidden" name="act" value="procMemberLogin">
				<input type="hidden" name="success_return_url" value="<?=$_SERVER['REQUEST_URI']?>" />
			</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
<script>
	(function($){
		$(document).ready(function(){

		$("#login").submit(function(){
			if($("#type").val()=="super"){
			$.ajax({
				url : "modules/login/login.controller.php",
				type : "POST",
				data : {cAct:"login",user_id:$("#user_id").val(),password:$("#password").val(),cid:$("#cid").val()},
				dataType : "json"
			}).done(function(data){
				if(data.status=="success")
				{
					location.reload();
				}
				else
				{
					$(".alert").remove();
					$(".panel-body").prepend(
						'<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 alert alert-danger" style="margin-top:10px;"><?=$clang->fail_login?></div>'
					);
				}
			}).fail(function(data){
				$(".alert").remove();
				$(".panel-body").prepend(
					'<div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2 alert alert-danger" style="margin-top:10px;"><?=$clang->fail_login?></div>'
				);
			});
				return false;
			}else{
				return true;
			}

		});
		});
	})(jQuery);
</script>