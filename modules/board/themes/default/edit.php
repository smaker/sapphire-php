<div class="ui container">
	<div class="ui basic segment">
		<form action="/<?php echo $instance->id; ?>/edit" method="post" class="ui form">
			<input type="hidden" name="articleId" value="<?php echo $article->articleId; ?>">
		    <div class="field">
		      <input type="text" name="title" value="<?php echo escape($article->title); ?>" placeholder="제목" required>
		    </div>
		    <div class="field">
		      <textarea name="content" cols="30" rows="10" placeholder="내용" required><?php echo str_replace('<br />', "\n", $article->content); ?></textarea>
		    </div>
		    <?php if(!\Module\Member\Model::isLogged()) { ?>
		    <div class="inline fields">
		    	<div class="field">
		    		<input type="password" name="password" placeholder="비밀번호">
		    	</div>
		    </div>
		    <?php } ?>
			<div class="field">
				<div class="ui checkbox">
					<input type="checkbox" id="isNotice" name="isNotice" value="Y">
					<label for="isNotice">공지</label>
				</div>
				<div class="ui checkbox">
					<input type="checkbox" id="isSecret" name="isSecret" value="Y">
					<label for="isSecret">비밀글</label>
				</div>
			</div>
		    <input type="submit" value="수정 완료" class="ui button">
		  </div>
		</form>
	</div>
</div>