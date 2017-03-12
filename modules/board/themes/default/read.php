<div class="boardRead ui container">
	<div class="ui basic segment">
		<div class="ui segment">
			{{ -- 제목 -- }}
			<div class="ui header">
				<h2><?php echo escape($article->title); ?></h2>

			</div>

			<div class="ui clearing divider"></div>
			<div class="info">
				<div class="author">
					<i class="icon user"></i> <strong>{{ $article->nickName }}</strong>
				</div>
				<div class="date">
					<i class="icon time"></i>{{ $article->createAt }}
				</div>
			</div>

			<div class="articleBody">
				<?php echo $article->content; ?>
			</div>
			

			<div class="ui floated right">
				<a href="/<?php echo $instance->id; ?>/edit/{{ $article->articleId }}" class="ui button">수정</a>
				<a href="/<?php echo $instance->id; ?>/delete/{{ $article->articleId }}" class="ui button">삭제</a>
			</div>

			<div class="ui threaded comments">
				<h3 class="ui header">댓글 '<?php echo number_format($article->commentCount); ?>'</h3>

				<?php if($article->getCommentCount() == 0) { ?>
				<div class="ui icon small message">
					<i class="icon write"></i> 아직 등록된 댓글이 없네요. 첫 댓글을 달아보세요!
				</div>
				<?php } ?>

				<?php foreach($article->getComments() as $no => $comment) { ?>
				<div class="comment">
					<a class="avatar">
						<img src="http://semantic-ui.com/images/avatar/small/matt.jpg">
					</a>
					<div class="content">
						<a class="author"><?php echo $comment->nickName; ?></a>
						<div class="metadata">
							<span class="date"><?php echo $comment->createdAt; ?></span>
					</div>
					<div class="text">
						<?php echo $comment->content; ?>
					</div>
					<div class="actions">
						<a href="/<?php echo $instance->id; ?>/<?php echo $article->articleId; ?>/comment/<?php echo $comment->commentId; ?>" class="reply">답글</a> <a href="/{{ $instance->id }}/{{ $article->articleId }}/comment-delete/{{ $comment->commentId }}" class="delete">삭제</a>
					</div>
				</div>
			</div>
			<?php } ?>
			<form action="/<?php echo $instance->id; ?>/<?php echo $article->articleId; ?>/comment" method="post" class="ui reply form">
				<div class="field">
					<textarea name="content" placeholder="이곳에 댓글을 입력해주세요." required></textarea>
				</div>
				<button type="submit" class="ui blue labeled submit icon button">
					<i class="icon edit"></i> 댓글 등록
				</button>
			</form>
		</div>
	</div>
</div>