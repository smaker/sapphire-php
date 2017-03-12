<div class="ui container">
	<div class="ui basic segment">
		<form action="/<?php echo \Core\Uri::get(0); ?>/create" method="post" class="ui form">
		    <div class="field">
		      <input type="text" name="title" placeholder="제목" title="제목" required>
		    </div>
		    <div class="field">
		      <textarea name="content" id="" cols="30" rows="10" placeholder="내용" title="내용" required></textarea>
		    </div>
		    <?php if(!\Module\Member\Model::isLogged()) { ?>
		    <div class="inline fields">
		    	<div class="field">
		    		<input type="text" name="nick_name" placeholder="글쓴이" autocomplete="off" required>
		    	</div>
		    	<div class="field">
		    		<input type="password" name="password" placeholder="비밀번호" autocomplete="off" required>
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
		    <input type="submit" value="등록" class="ui button">
		  </div>
		</form>
	</div>
</div>