<div class="ui header">
	<h2>페이지 설정</h2>
</div>
<form action="/admin/page/edit/{{ $page->instanceId }}" method="post" class="ui form">
	<div class="required field">
		<label for="pageID" class="one wide ui">페이지 ID</label>
		<input type="text" id="pageID" name="id" value="{{ $page->id }}" required>
		<p>접속 시 사용할 페이지 ID를 입력해주세요. ex) http://sensitivecms.com/home</p>
	</div>
	<div class="required field">
		<label for="pageTitle" class="one wide ui">페이지 제목</label>
		<input type="text" id="pageTitle" name="title" value="{{ $page->title }}" required>
	</div>
	<div class="required field">
		<label for="siteTheme" class="one wide ui">사이트 테마</label>
		<select name="siteTheme" id="siteTheme" class="dropdown">
			<option value="@">(빈 테마)</option>
			<?php foreach($siteThemes as $theme => $themeInfo) { ?>
			<option value="{{ $theme }}"<?php if($page->config->siteTheme) { ?> selected<?php } ?>>{{ $themeInfo->title }}</option>
			<?php } ?>
		</select>
	</div>
	<div class="field">
		<label for="content">내용</label>
		<textarea name="content" id="content" cols="30" rows="10"><?php echo htmlspecialchars($page->config->content); ?></textarea>
	</div>
	<input type="submit" value="저장" class="ui button primary">
</form>