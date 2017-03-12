<div class="ui header">
	<h1>회원 정보 수정</h1>
</div>

<form action="/admin/member/edit.do" method="post" class="ui form" autocomplete="off">
	<input type="hidden" name="memberId" value="{{ $member->memberId }}">

	<div class="required field">
		<label for="userId" class="one wide ui">아이디</label>
		<input type="text" id="userId" name="userId" value="{{ $member->userId }}" required>
	</div>
	<div class="required field">
		<label for="userName" class="one wide ui">이름</label>
		<input type="text" id="userName" name="userName" value="{{ $member->userName }}" required>
	</div>
	<div class="required field">
		<label for="nickName" class="one wide ui">닉네임</label>
		<input type="text" id="nickName" name="nickName" value="{{ $member->nickName }}" required>
	</div>
	<div class="required field">
		<label for="emailAddress" class="one wide ui">이메일 주소</label>
		<input type="text" id="emailAddress" name="emailAddress" value="{{ $member->emailAddress }}" required>
	</div>
	<div class="field">
		<label for="password" class="one wide ui">변경할 비밀번호</label>
		<input type="password" id="password" name="password">
	</div>
	<div class="field">
		<input type="submit" value="수정하기" class="ui primary button">
	</div>
</form>