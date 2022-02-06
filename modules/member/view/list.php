<table id="memberList" class="ui unstackable table">
	<thead>
		<tr>
			<th>아이디</th>
			<th>이름</th>
			<th>상태</th>
			<th>가입일</th>
			<th>최근 로그인</th>
			<th>조회/수정</th>
			<th>
				<div class="ui checkbox cart">
					<input type="checkbox"> <label></label>
				</div>
			</th>
		</tr>
	</thead>
	<tbody>
		{{ @foreach ($list as $no => $member) }}
		<tr id="member_{{ $member->memberId }}">
			<td>{{ escape($member->userId) }}</td>
			<td>{{ escape($member->userName) }}</td>
			<td>
				<?php
				switch($member->status)
				{
					case 'STANDBY':
						echo \Module\Member\AdminView::STATUS_STANDBY;
						break;
					case 'APPROVED':
						echo \Module\Member\AdminView::STATUS_APPROVED;
						break;
					case 'DENIED':
						echo \Module\Member\AdminView::STATUS_DENIED;
						break;
				}
				?>
			</td>
			<td>{{ convertDateFormat($member->createdAt, 'Y-m-d') }}</td>
			<td>{{ convertDateFormat($member->loginAt, 'Y-m-d') }}</td>
			<td>
				<a href="/admin/member/edit/{{ $member->memberId }}">조회/수정</a>
			</td>
			<td>
				<div class="ui ui-popup checkbox check"{{ @if ($member->isAdmin == 'Y') }} data-content="최고 관리 권한을 가진 회원은 선택할 수 없습니다."{{ @end }}>
					<input type="checkbox" name="cart" value="{{ $member->memberId }}"<?php if ($member->isAdmin == 'Y'): ?> disabled <?php endif; ?>> <label></label>
				</div>
			</td>
		</tr>
		{{ @endforeach }}
	</tbody>
</table>

<div class="ui left floated basic segment" style="padding:0">
	<a href="/admin/member/add" class="ui button secondary"><i class="add user icon"></i>회원 추가</a>
</div>

<div class="ui right floated basic segment" style="padding:0">
	<button id="deleteMembers" type="button" class="ui red button"><i class="trash icon"></i> 삭제</button>
	<button type="button" class="ui button"><i class="configure icon"></i> 관리</button>
</div>

<script>
$('.check').checkbox('attach events', '.checkbox.cart', 'toggle');
</script>

<div class="ui dimmer modals page transition hidden">
	<div class="ui small basic deleteConfirm modal transition">
		<div class="ui icon header">
			<i class="trash icon"></i>
			회원 삭제
    </div>
    <div class="content">
		<p style="text-align:center">한 번 삭제하면 되돌릴 수 없습니다. 정말 삭제하시겠습니까?</p>
    </div>
    <div class="actions" style="text-align: center">
		<div class="ui green ok inverted button">
			<i class="checkmark icon"></i>
			삭제하기
		</div>
		<div class="ui red basic cancel inverted button">
			<i class="remove icon"></i>
			취소하기
		</div>
    </div>
</div>

<div style="clear:both"></div>