<div class="ui container">
	<div class="ui basic segment">
		<div class="ui segment">
			<div class="ui comments">
				<div class="comment">
					<a href="" class="avatar">
						<img src="http://semantic-ui.com/images/avatar/small/christian.jpg">
					</a>
					<div class="content">
						<a href="" class="author">{{ $comment->nickName }}</a>
						<div class="text">{{ $comment->content }}</div>
					</div>
				</div>
			</div>
		</div>
		<form action="/{{ $instance->id }}/{{ $comment->commentId }}/comment-delete/{{ $comment->commentId }}" method="post" class="form">
			<input type="hidden" name="commentId" value="{{ $comment->commentId }}">
			<p>정말 댓글을 삭제하시겠습니까?</p>
			<input type="submit" value="삭제하기" class="ui red button">
			<a href="" class="ui button">돌아가기</a>
		</form>
	</div>
</div>