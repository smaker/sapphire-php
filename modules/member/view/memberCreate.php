<div class="ui header">
	<h1>회원 추가</h1>
</div>


<form action="/admin/member/add" method="post" class="ui form">
	<div class="required field">
		<label for="userId" class="one wide ui">아이디</label>
		<input type="text" id="userId" name="userId" required>
	</div>
	<div class="required field">
		<label for="userName" class="one wide ui">이름</label>
		<input type="text" id="userName" name="userName" required>
	</div>
	<div class="required field">
		<label for="nickName" class="one wide ui">닉네임</label>
		<input type="text" id="nickName" name="nickName" required>
	</div>
	<div class="required field">
		<label for="emailAddress" class="one wide ui">이메일 주소</label>
		<input type="text" id="emailAddress" name="emailAddress" required>
	</div>
	<div class="required field">
		<label for="password" class="one wide ui">비밀번호</label>
		<input type="text" id="password" name="password" required>
	</div>
	<div class="field">
		<input type="submit" value="추가하기" class="ui primary button">
	</div>
</form>