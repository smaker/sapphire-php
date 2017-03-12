<script src="/modules/member/view/js/login.js"></script>

<div class="ui container">
	<div class="ui basic segment">
		<div class="ui two column middle aligned very relaxed stackable grid">
			<div class="column">
				<form id="login" action="/login/" method="post" class="ui form">
					<input type="hidden" name="from" value="<?php echo $from; ?>">
					<div class="field">
						<label for="">아이디</label>
						<div class="ui left icon input">
							<input type="text" name="user_id" placeholder="아이디" required>
							<i class="user icon"></i>
						</div>
					</div>
					<div class="field">
						<label for="">비밀번호</label>
						<div class="ui left icon input">
							<input type="password" name="password" required>
							<i class="lock icon"></i>
						</div>
					</div>
					<div class="field">
						<input type="submit" value="로그인" class="ui button primary">
					</div>
				</form>
			</div>
			<div class="ui vertical divider">
			Or
			</div>
  <div class="center aligned column">
    <a href="/login/twitter" class="ui big green labeled icon button">
      <i class="signup icon"></i>
      트위터 로그인
    </a>
    <a href="/login/kakao" class="ui big green labeled icon button">
      <i class="signup icon"></i>
      카카오 로그인
    </a>
    <br><br>
    <a href="/join" class="ui big green labeled icon button">
      <i class="signup icon"></i>
      가입하기
    </a>
  </div>
		</div>
	</div>
</div>
