<?php

?>
<?php if($user_info->is_admin=="Y"){ ?>
<table class="table table-bordered col-md-12">
	<thead>
		<tr>
			<th class="col-md-2 col-xs-2 " colspan="2"><?=$clang->all_visitor?></th>
			<th class="col-md-4 col-xs-4 " colspan="2"><?php echo $db->row('','chibi_log');?></th>
			<th class="col-md-2 col-xs-2 " colspan="2"><?=$clang->all_picture?></th>
			<th class="col-md-4 col-xs-4 " colspan="2"><?php echo $db->row('','chibi_pic');?></th>
		</tr>
		<tr>
			<th class="col-md-2 col-xs-2 " colspan="2"><?=$clang->today_visitor?></th>
			<th colspan="2"><?php echo $db->row('','chibi_log',array(array('date',date("Ymd"))));?></th>
			<th class="col-md-2 col-xs-2 " colspan="2"><?=$clang->all_comment?></th>
			<th colspan="2"><?php echo $db->row('','chibi_comment');?></th>
		</tr>
	</thead>
</table>
<?php } ?>
<div class="table-responsive">
<table class="table table-bordered col-md-12 admin-list">
	<thead>
		<tr>
			<th><?=$clang->admin_list_cid?></th>
			<?php if($display->device()=="pc"){?>
			<th><?=$clang->admin_list_skin?></th>
			<th><?=$clang->all_visitor?></th>
			<th><?=$clang->today_visitor?></th>
			<th><?=$clang->pictures?></th>
			<th><?=$clang->comments?></th>
			<?php } ?>
			<th <?php if($display->device()=="pc") echo "class=\"col-md-4 col-xs-4\""; ?>><?=$clang->board_management?></th>
		</tr>
	</thead>
	<tbody>
	<?php
		$board = $admin->select(NULL,$db->conn());
		$i = 0;
		while($i<count($board)){
			$list = $admin->board_set($board[$i]);
			$i++;
			if($admin->check($list->cid,$user_info)){
	?>
		<tr>
			<td><?=$list->cid?></td>
			<?php if($display->device()=="pc"){?>
			<td><?=$list->skin?></td>
			<td><?=$list->total_visitors?></td>
			<td><?=$list->today_visitors?></td>
			<td><?=$list->total_pics?></td>
			<td><?=$list->total_comments?></td>
			<?php } ?>
			<td>
				<ul class="tooltip-examples list-inline" <?php if($display->device()=="mobile") echo "style=\"margin-bottom: 2px;\"";?>>
					<li style="padding:0"><a href="./index.php?mid=admin&cAct=adminBoardSetup&cid=<?=$list->cid?>" class="btn btn-info" data-toggle="tooltip" data-original-title="<?=$clang->list_board_management;?>"><span class="glyphicon glyphicon-cog"></span></a></li>
					<li style="padding:0"><a href="./index.php?mid=admin&cAct=adminSkinSetup&cid=<?=$list->cid?>" class="btn btn-info" data-toggle="tooltip" data-original-title="<?=$clang->skin_management;?>"><span class="glyphicon glyphicon-leaf"></span></a></li>
					<li style="padding:0"><a href="./index.php?mid=admin&cAct=adminEmoticonSetup&cid=<?=$list->cid?>" class="btn btn-info" data-toggle="tooltip" data-original-title="<?=$clang->emoticon?>"><span class="glyphicon glyphicon-heart-empty"></span></a></li>
					<li style="padding:0"><a href="./admin.php?cAct=adminStatic&cid=<?=$list->cid?>" class="btn btn-info" data-toggle="tooltip" data-original-title="<?=$clang->statics?>"><span class="glyphicon glyphicon-stats"></span></a></li>
					<?php if($display->device()=="mobile") echo "</ul><ul class=\"tooltip-examples list-inline\" style=\"margin-bottom: 0px;\">"; ?>
					<li style="padding:0"><a href="./index.php?mid=admin&cAct=adminBoardReset&cid=<?=$list->cid?>" class="btn btn-warning btn-sm" style="margin-top:2px;"><?=$clang->reset?></a></li>
					<li style="padding:0"><a href="./index.php?mid=admin&cAct=adminBoardDelete&cid=<?=$list->cid?>" class="btn btn-danger btn-sm" style="margin-top:2px;"><?=$clang->del?></a></li>
				</ul>
				<script>(function($){$('[data-toggle=tooltip]').tooltip();})(jQuery);</script>
				</div>
			</td>
		</tr>
	<?php
			}
		}
	?>
	</tbody>
</table>
</div>