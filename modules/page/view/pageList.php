<div class="ui basic segment">
	<div class="ui header">
		<h2>페이지 관리</h2>
	</div>
	<table class="ui celled unstackable table">
		<thead>
			<tr>
				<th>번호</th>
				<th>제목</th>
				<th>생성일자</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($instances as $no => $page) { ?>
			<tr>
				<td><?php echo $no + 1; ?></td>
				<td>
					<a href="/<?php echo $page->id; ?>"><?php echo $page->title; ?></a>
				</td>
				<td></td>
				<td>
					<a href="/admin/page/edit/<?php echo $page->instanceId; ?>">Edit</a>
					<a href="">Delete</a>
				</td>
			</tr>
			<?php } ?>
		</tbody>
	</table>

	<a href="/admin/board/create" class="ui button primary right floated">페이지 생성</a>
</div>