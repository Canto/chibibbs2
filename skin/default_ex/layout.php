<!--// 상단 공지사항 시작 //-->
<div class="container">
	<div class="col-md-12">
		<div class="user_notice_border_color user_notice_border_type user_notice_background_color">
		{$board->notice->head}
		</div>
	</div>
</div>
<!--// 상단 공지사항 끝 //-->

<!--// 본문 시작 //-->
<div class="container">
	<div class="row">
		<!--// 상단 페이지바 시작 //-->
		<div class="paging-bar">
			<ul class="pagination pagination-sm">
				{$paging}
			</ul>
		</div>
		<!--// 상단 페이지바 종료 //-->

		<!--// 그림 & 코멘트 시작 //-->

		<!--@START::PIC-->
		<div class="panel panel-default">
			<div class="panel-heading title">No.{$pic->no}</div>
			<div class="panel-body">
				<ul class="content col-md-12">
					<li class="pic">
						{$picture}
					</li>
					<li class="comment">
						<!--@START::COMMENT-->
						<ul>
						<li>{$comment->name}</li>
						<!--@if::($comment->op->secret)-->
						<li>Secret</li>
						<!--@else-->
						<li>{$comment->comment}</li>
						<!--@if::end-->
						</ul>
						<!--@END::COMMENT-->
					</li>
				</ul>
			</div>
		</div>
		<!--@END::PIC-->

		<!--// 그림 & 코멘트 종료 //-->

		<!--// 하단 페이지바 시작 //-->
		<div class="paging-bar">
			<ul class="pagination pagination-sm">
				{$paging}
			</ul>
		</div>
		<!--// 하단 페이지바 종료 //-->
	</div>
</div>
<!--// 본문 종료 //-->

<!--// 하단 공지사항 시작 //-->
<div class="container layout-foot">
	<div class="notice-foot">
		{$board->notice->foot}
	</div>
</div>
<!--// 하단 공지사항 끝 //-->