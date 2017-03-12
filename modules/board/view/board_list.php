<h2 class="ui header">게시판 관리</h2>

<div class="responsive-table" style="margin-bottom:1em">
	<table class="ui celled unstackable table">
			<thead>
			<tr>
				<th class="two wide center aligned">번호</th>
				<th class="four wide center aligned">제목</th>
				<th class="four wide center aligned">생성일자</th>
				<th class="one wide center aligned">Action</th>
			</tr>
		</thead>
			<tbody>
			{{ @foreach ($instances as $no => $board) }}
			<tr>
				<td class="center aligned"><?php echo $no+1; ?></td>
				<td class="center aligned">
					<a href="/{{ $board->id }}">{{ $board->title }}</a>
				</td>
				<td class="center aligned">{{ $board->createAt }}</td>
				<td class="center aligned">
					<a href="/admin/board/edit/{{ $board->instanceId }}"><i class="setting icon"></i></a>
					<a href="/admin/board/delete/{{ $board->instanceId }}"><i class="remove icon"></i></a>
				</td>
			</tr>
			{{ @end }}
		</tbody>
		<tfoot>
				<tr>
					<th colspan="4">
						<div class="ui right floated pagination menu">
							<a class="icon item"><i class="left chevron icon"></i></a>
						<a class="item">1</a>
						<a class="item">2</a>
						<a class="item">3</a>
						<a class="item">4</a>
						<a class="icon item"><i class="right chevron icon"></i></a>
					</div>
				</th>
			</tr>
		</tfoot>
	</table>
</div>

<a href="/admin/board/create" class="ui button primary right floated">게시판 추가</a>