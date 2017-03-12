<include file="_editHeader.php">

<div class="ui basic segment">
	<form class="ui form">
		<h2 class="ui dividing header">권한 설정</h2>
		<div class="field">
			<label for="">글쓰기</label>
			<select name="" id="">
				<option value="">모든 사용자</option>
				<option value="">로그인 사용자</option>
				<option value="">게시판 관리자</option>
				<option value="">최고 관리자</option>
			</select>
		</div>
		<div class="field">
			<label for="">댓글 작성</label>
			<select name="" id="">
				<option value="">모든 사용자</option>
				<option value="">로그인 사용자</option>
				<option value="">게시판 관리자</option>
				<option value="">최고 관리자</option>
			</select>
		</div>
		<input type="submit" class="ui button primary" value="저장">
	</form>
</div>

<div class="ui basic segment">
	<form action="" class="ui form" method="post">
		<h2 class="ui dividing header">게시판 관리자</h2>
		<div class="field">
			<p>아직 게시판 관리자가 없습니다.</p>
			<div class="ui fluid multiple search selection dropdown">
			  <input type="hidden" name="memberId">
			  <i class="dropdown icon"></i>
			  <div class="default text">선택하세요</div>
			  <div class="menu">
			  <div class="item" data-value="1">SimpleCode</div>
			  <div class="item" data-value="2">Super Admin</div>
			  <div class="item" data-value="3">Foo</div>
			  <div class="item" data-value="4">Bar</div>

			</div>
			 </div>
		</div>
	</form>
</div>


<script>
	$('.ui.dropdown')
  .dropdown({
   // useLabels: false,
    //maxSelections: 3
  });
</script>
