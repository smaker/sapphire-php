<?php
	if(!isset($section))
	{
		$section = '';
	}
?>

<div class="ui basic segment">
	<h1 class="ui header">게시판 설정</h1>
	<div class="overflowAuto">
		<div class="ui top attached tabular menu">
			<a href="/admin/board/edit/<?php echo $board->instanceId; ?>" class="<?php if(!$section) { ?>active <?php } ?>item">기본 설정</a>
			<a href="/admin/board/edit/<?php echo $board->instanceId; ?>?section=permission" class="<?php if($section == 'permission') { ?>active <?php } ?>item">권한 관리</a>
			<a href="/admin/board/edit/<?php echo $board->instanceId; ?>?section=form" class="<?php if($section == 'form') { ?>active <?php } ?>item">입력 항목 관리</a>
			<a href="" class="item">추가 설정</a>
		</div>
	</div>