<?php
$section = \Core\Input::get('section');
if(!isset($section))
{
	$section = '';
}
?>
<div class="overflowAuto">
	<div class="ui top attached tabular menu">
		<a href="/admin/board/edit/{{ $board->instanceId }}" class="<?php if(!$section) { ?>active <?php } ?>item">기본 설정</a>
		<a href="/admin/board/edit/{{ $board->instanceId }}?section=permisson" class="<?php if($section == 'permisson') { ?>active <?php } ?> item">권한 관리</a>
		<a href="/admin/board/edit/{{ $board->instanceId }}?section=form" class="item">입력 항목 관리</a>
		<a href="" class="item">추가 설정</a>
	</div>
</div>