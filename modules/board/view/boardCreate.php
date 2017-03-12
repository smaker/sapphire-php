<div class="ui basic segment">
	<h1 class="ui header">게시판 추가</h1>
	<form id="form" action="/admin/board/create" method="post" class="ui form">
		<div class="required field">
			<label for="instanceId" class="one wide ui">게시판 ID</label>
			<input type="text" id="instanceId" name="id" value="" required>
			<p>접속 시 사용할 게시판 ID를 입력해주세요. ex) http://sensitivecms.com/<span id="boardID_live"></span></p>
		</div>
		<div class="required field">
			<label for="" class="one wide ui">브라우저 제목</label>
			<input type="text" name="title" value="" required>
		</div>
		<div class="field">
			<label for="siteTheme" class="one wide ui">사이트 테마</label>
			<select name="siteTheme" id="siteTheme" class="dropdown">
				<option value="@">(빈 테마)</option>
				{{ @foreach ($siteThemes as $theme => $themeInfo) }}
				<option value="{{ $theme }}">{{ $themeInfo->title }}</option>
				{{ @end }}
			</select>
		</div>
		<div class="field">
			<label for="boardTheme" class="one wide ui">게시판 테마</label>
			<select name="boardTheme" id="boardTheme" class="dropdown" required>
				<option value="default">Default Theme</option>
			</select>
		</div>
		<div class="required field">
			<label for="">목록 수</label>
			<input type="number" name="listCount" value="20" min="1" max="100" requried>
			<p>한 페이지에 나타낼 게시물 수를 입력해주세요.</p>
		</div>
		<div class="required field">
			<label for="">페이지 수</label>
			<input type="number" name="pageCount" value="10" min="1" max="10" requried>
			<p>한 페이지에 나타낼 페이지 수를 입력해주세요.</p>
		</div>
		<div class="field">
			<label for="headerText">상단 내용</label>
			<textarea name="headerText" id="headerText" cols="30" rows="10"></textarea>
		</div>
		<div class="field">
			<label for="footerText">하단 내용</label>
			<textarea name="footerText" id="footerText" cols="30" rows="10"></textarea>
		</div>
		<input type="submit" class="ui button primary" value="확인">
	</form>
</div>