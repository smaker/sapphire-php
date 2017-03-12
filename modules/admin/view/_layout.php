<div id="menu" class="ui top attached menu">
	<a id="sidebarToggler" class="item">
		<i class="sidebar icon"></i>
	</a>
	<div class="right menu">
		<div id="language" class="ui dropdown">
			<div class="text"><i class="flag kr"></i> 한국어</div>
			<i class="dropdown icon"></i>
			<div class="menu">
				<div class="item">
					<i class="flag kr"></i> 한국어
				</div>
			</div>
		</div>
	</div>
</div>

<aside class="ui bottom attached segment pushable">
	<div class="ui <?php if(isset($_COOKIE['ST_ADMIN_OPEN']) && $_COOKIE['ST_ADMIN_OPEN'] == 'Y') { ?>visible <?php } ?>inverted left vertical inline menu sidebar">
		<div class="item">
			<img src="/assets/core/img/sensitivecms_dark.png" alt="" class="item">
		</div>
		<a href="/admin" class="active item">
			Dashboard
			<i class="dashboard icon"></i>
		</a>
		<div class="item hasChild">
			<a href="/admin/member/">회원</a>
			<i class="user icon"></i>
			<div class="menu">
				<a href="/admin/member/" class="item">회원 목록</a>
				<a href="/admin/member/group/" class="item">회원 그룹</a>
				<a href="/admin/member/point/" class="item">포인트 관리</a>
			</div>
		</div>
		{{ @foreach ($admin_menu as $key => $menu) }}
		<div class="item{{ @if ($menu->itemCount) }} hasChild{{ @end }}">
			<a href="{{ $menu->link }}" class="item">
				{{ $menu->title }} {{ @if ($menu->icon) }}<i class="icon {{ $menu->icon }}"></i>{{ @end }}
			</a>
			{{ @if ($menu->itemCount) }}
			<div class="menu">
				{{ @foreach ($menu->items as $k => $item) }}
				<a href="{{ $item->link }}" class="item">{{ $item->title }}</a>
				{{ @endforeach }}
			</div>
			{{ @end }}
		</div>
		{{ @end }}
		<a href="/admin/page/" class="item">
			페이지 관리 <i class="sitemap icon"></i>
		</a>
		<a href="/admin/menu/" class="item">
		  메뉴 관리 <i class="sitemap icon"></i>
		</a>
		<a href="/admin/plugins/" class="item">
		  플러그인 <i class="puzzle icon"></i>
		</a>
		<a href="/admin/modules/" class="item">
		  모듈 <i class="cube icon"></i>
		</a>
		<div class="item">
			<a href="/admin/design/">디자인 설정</a>
			<i class="theme icon"></i>
		</div>
		<div class="item hasChild">
			<a href="/admin/settings/">사이트 설정</a>
			<i class="setting icon"></i>
			<div class="menu">
				<a href="/admin/settings" class="item">기본 설정</a>
				<a href="/admin/settings/seo" class="item">SEO 설정</a>
			</div>
		</div>
	</div>
	<div id="body" class="pusher">
		<div class="ui basic segment">
			<div class="ui breadcrumb">
				<a class="section">Home</a>
				<i class="right chevron icon divider"></i>
				<div class="active section">Dashboard</div>
			</div>
		</div>
		<div class="ui basic segment">{{ $admin_content }}</div>
	</div>
</aside>
