<div class="ui header">
	<h1><i class="theme icon"></i>테마 설정</h1>
</div>
<div class="ui divided items">
	{{ @foreach (\Core\Theme::getInstalledThemes() as $theme) }}
	<div class="item">
		<div class="image">
			<img src="http://semantic-ui.com/images/wireframe/image.png">
		</div>
		<div class="content">
			<a href="{{ url('/admin/design/default') }}" class="header">{{ $theme->title }}</a>
			<div class="meta">
				<span class="author"><i class="user icon"></i> {{ $theme->author }}</span>
				<span class="website"><i class="world icon"></i> http://sensitivecms.com</span>
			</div>
			<div class="description">
				<p>{{ $theme->description }}</p>
			  </div>
			<div class="extra">
				<div class="ui label"><i class="desktop icon"></i> PC</div>
				<div class="ui label"><i class="mobile icon"></i> 모바일</div>
				<button type="button" class="ui right floated positive button toggleDefaultTheme" data-theme="default" data-theme-is-using="true">
					사용중
					<i class="right checkmark icon"></i>
				</button>
			</div>
		</div>
	</div>
	{{ @endforeach }}
	<div class="item">
		<div class="image">
			<img src="http://semantic-ui.com/images/wireframe/image.png">
		</div>
		<div class="content">
			<a class="header">Watchmen</a>
			<div class="meta">
				<span class="cinema">IFC</span>
			</div>
			<div class="description">
				<p></p>
			</div>
			<div class="extra">
				<div class="ui right floated primary button">
				사용하기
				<i class="right chevron icon"></i>
			</div>
		</div>
	</div>
</div>
