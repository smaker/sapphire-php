<div class="ui container">
	<div class="ui basic segment">
		<form id="memberJoin" action="/join.do" method="post" class="ui form">
			<h1 class="ui header">이용약관</h1>
			<div class="field">
				<textarea cols="30" rows="10" readonly>이 곳에 이용약관을 입력해주세요.</textarea>
			</div>
			<div class="field">
				<div class="ui checkbox">
					<input type="checkbox" name="agree" id="agree" value="Y" required title="이용약관"> <label for="agree"><a href="/agree">이용약관</a>에 동의합니다.</label>
				</div>
			</div>
			<h2 class="ui header"><i class="leaf icon"></i>기본 정보</h2>
			<div class="required field">
				<label for="userId">아이디</label>
				<div class="ui left icon input">
					<input type="text" id="userId" name="userId" placeholder="아이디" title="아이디" required>
					<i class="user icon"></i>
				</div>
			</div>
			<div class="required field">
				<label for="password">비밀번호</label>
				<div class="ui left icon input">
					<input type="password" id="password" name="password" placeholder="****" title="비밀번호" required>
					<i class="lock icon"></i>
				</div>
			</div>
			<div class="required field">
				<label for="password2">비밀번호 확인</label>
				<div class="ui left icon input">
					<input type="password" id="password2" name="password2" placeholder="****" title="비밀번호 확인" required>
					<i class="lock icon"></i>
				</div>
			</div>
			<div class="required field">
				<label for="">이름</label>
				<input type="text" name="userName" placeholder="이름" title="이름" required>
			</div>
			<div class="required field">
				<label for="">닉네임</label>
				<input type="text" name="nickName" placeholder="닉네임" title="닉네임" required>
			</div>
			<div class="required field">
				<label for="">이메일 주소</label>
				<input type="email" name="emailAddress" placeholder="example@sensitivecms.com" title="이메일 주소" required>
			</div>
			<!--<h2 class="ui header">추가 정보</h2>
			<div class="field">
				<label for="">집 주소</label>
				<input type="text" name="address" placeholder="집 주소" title="집 주소">
			</div>-->
			<input type="submit" value="회원 가입" class="ui button primary">
		</form>
	</div>
</div>