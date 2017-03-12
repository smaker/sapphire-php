<div class="ui basic segment">
	<table class="ui celled table">
	  <thead>
	    <tr>
	    <th>번호</th>
	    <th>제목</th>
	    <th>생성일자</th>
	    <th>Action</th>
	  </tr>
	  </thead>
	  <tbody>
	    <?php foreach($instances as $no => $instance) { ?>
	    <tr>
	      <td><?php echo $no; ?></td>
	      <td>
	      	<a href="/<?php echo $instance->id; ?>"><?php echo $instance->title; ?></a>
	      </td>
	      <td><?php echo $instance->createAt; ?></td>
	      <td>
	      	<a href="/admin/board/edit/<?php echo $instance->instanceId; ?>"><i class="setting icon"></i></a>
	      	<a href="/admin/board/delete/<?php echo $instance->instanceId; ?>">
	      		<i class="remove icon"></i>
	      	</a>
	      </td>
	    </tr>
	    <?php } ?>
	  </tbody>
	  <tfoot>
	    <tr><th colspan="4">
	      <div class="ui right floated pagination menu">
	        <a class="icon item">
	          <i class="left chevron icon"></i>
	        </a>
	        <a class="item">1</a>
	        <a class="item">2</a>
	        <a class="item">3</a>
	        <a class="item">4</a>
	        <a class="icon item">
	          <i class="right chevron icon"></i>
	        </a>
	      </div>
	    </th>
	  </tr></tfoot>
	</table>
	<a href="/admin/board/create" class="ui button primary right floated">게시판 추가</a>
</div>