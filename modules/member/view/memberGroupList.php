<div class="ui header">
	<h1>회원 그룹</h1>
</div>
<form action="/admin/member/group/delete" method="post" class="ui form">
	<table class="ui table unstackable striped">
		<thead>
			<tr>
				<th class="one wide">
					<div class="field">
						<div class="ui checkbox">
							<input type="checkbox" name="groupId[]"><label for=""></label>
						</div>
					</div>
				</th>
				<th class="center aligned">그룹명</th>
				<th class="center aligned">그룹마크</th>
				<th class="center aligned">소속회원</th>
				<th class="center aligned">생성일자</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($groupList as $group) { ?>
			<tr>
				<td>
					<div class="field">
						<div class="ui checkbox">
							<input type="checkbox" name="groupId[]" value=""><label for=""></label>
						</div>
					</div>
				</td>
				<td class="center aligned"><?php echo escape($group->groupName); ?></td>
				<td class="center aligned">
					<?php if($group->groupMark) { ?>
					<img src="<?php echo $group->groupMark; ?>">
					<?php } else { ?>
					<span class="ui small label">없음</span>
					<?php } ?>
				</td>
				<td class="center aligned">0</td>
				<td class="center aligned"><?php echo $group->createdAt; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</form>
<div class="clear"></div>
<br>
<form action="/admin/member/group/add" method="post" class="ui form">
	<div class="field">
		<div class="ui action small input">
			<input type="text" name="groupName" title="그룹명" placeholder="추가할 그룹명을 입력해주세요." required>
			<input type="file" name="groupMark" title="그룹 이미지 마크" accept="image/*" style="border-radius:0" hidden>
			<input type="submit" class="ui button primary" value="그룹 추가">
		</div>
	</div>
</form>