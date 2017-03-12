<include file="_header.php">

<div class="responsive-table">
	<table class="ui celled striped unstackable table">
	<caption>Total: <?php echo number_format($totalCount); ?>, Page {{ $page }} /1</caption>
		<thead>
			<tr>
				<th class="one wide">번호</th>
				<th>제목</th>
				<th class="two wide center aligned">글쓴이</th>
				<th class="three wide center aligned">날짜</th>
				<th class="one wide center aligned">조회수</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($noticeList as $no => $article) { ?>
			<tr>
				<td>
					<div class="ui ribbon label">Notice</div>
				</td>
				<td><?php echo $article->getTitle(); ?></td>
				<td class="center aligned">0</td>
	      		<td class="center aligned">0</td>
	      		<td class="center aligned">0</td>
	    	</tr>
	    	<?php } ?>
	    <?php
		if($totalCount)
		{
		foreach($list as $no => $article) { ?>
	    <tr>
	      <td><?php echo $no; ?></td>
	      <td class="selectable">
	      	<a href="/<?php echo Core\Uri::get(0); ?>/{{ $article->articleId }}"><?php echo $article->getTitle(); ?></a>
	      </td>
	      <td class="center aligned">
	      	<a class="member">{{ $article->nickName }}</a>
			<div class="ui special popup">
			  <div class="header">{{ $article->nickName }}</div>
				<div class="ui link list">
				                <a href="" class="item">회원 정보 보기</a>
				              </div>
			</div>
	      </td>
	      <td class="center aligned">{{ $article->createAt }}</td>
	      <td class="center aligned">{{ $article->viewCount }}</td>
	    </tr>
	    <?php
			}
		}
			else
			{
		?>
		<td colspan="5" class="center aligned">등록된 글이 없습니다.</td>
		<?php
			}?>
	  </tbody>
	  <tfoot>
	    <tr>
	    	<th colspan="5" style="text-align: center">
	      <div class="ui pagination menu">
	        <a href="" class="icon item">
	          <i class="left chevron icon"></i>
	        </a>
	        <?php for($i=1;$i<=$totalPage;$i++) { ?>
	        <a href="/{{ $instance->id }}/page/<?php echo $i; ?>" class="item<?php if($page == $i) { ?> active<?php } ?>"><?php echo $i; ?></a>
	        <?php } ?>
	        <a href="" class="icon item">
	          <i class="right chevron icon"></i>
	        </a>
	      </div>
	    </th>
	  </tr></tfoot>
	</table>
</div>

<a href="/<?php echo Core\Uri::get(0); ?>/create" class="ui right floated basic button">글쓰기</a>

<script>
$('a.member').popup({
	on : 'click'
});
</script>

<include file="_footer.php">