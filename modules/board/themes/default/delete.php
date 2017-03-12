<div class="ui container">
	<div class="ui basic segment">
		<div class="ui icon message warning">
			<i class="warning sign icon"></i>
			<div class="content">
				<form action="/<?php echo $instance->id; ?>/delete/<?php echo $article->articleId; ?>" method="post" class="ui form">
					<div class="header">
					정말 글을 삭제하시겠습니까?
					</div>
					<p>
						<br>
			    		<?php echo $article->title; ?>
			    		<br><br>
			    		<input type="submit" class="ui button primary" value="확인">
			    		<a href="/<?php echo $instance->id; ?>/<?php echo $article->articleId; ?>" class="ui button">돌아가기</a>
			    	</p>
				</form>
		  </div>
		</div>
	</div>
</div>