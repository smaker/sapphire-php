{{ @if (!$isSiteExists) }}
<h2 class="ui header">
	<i class="icon child"></i> 환영합니다!
</h2>
{{ @endif }}

<div class="ui grid">
	{{ @if ($isSiteExists) }}
	<div class="row">
		<div class="six wide column">
			<a href=""><i class="icon setting"></i> 사이트 설정</a>
		</div>
	</div>
	{{ @else }}
	<div class="row">
		<div class="six wide column">
			<div class="ui info message">
				<div class="header">
				SensitiveCMS가 아주 잘 설치되었습니다.
				</div>
				<ul class="list">
					<li>SensitiveCMS에서는 단 한 번의 설치로 여러 개의 사이트를 만들 수 있습니다.</li>
					<li>처음 설치하셨다면 기본 사이트를 먼저 만들어보세요!</li>
				</ul>
			</div>
			
			<a href="/admin/site/create" class="ui primary button"><i class="icon add"></i> 사이트 생성</a>
		</div>
	</div>
	{{ @endif }}
	<div class="six wide column">
   		<h4 class="ui top attached inverted header">서버 환경</h4>
    	<div class="ui buttom attached segment">
    		<div class="ui bulleted list">
    			<div class="item">
    				OS : {{ PHP_OS }}
    			</div>
    			<div class="item">
    				웹 서버 : {{ $WebServer }}
    			</div>
    			<div class="item">
    				PHP : {{ PHP_VERSION }}
				</div>
    			<div class="item"
    				>설치경로 : {{ BASEDIR }}
    			</div>
    		</div>
    	</div>
    </div>
    <div class="six wide column">
    	<h4 class="ui top attached inverted header">스토리지 사용량</h4>
    	<div class="ui buttom attached segment">
    		<div class="ui bulleted list">
    			<div class="item">
    				캐시파일 : {{ $CacheUsage }}
    			</div>
    			<div class="item">
    				첨부파일 : 
    			</div>
    		</div>
    		<a href="#" class="ui button flushCache">캐시파일 비우기</a>
    	</div>
    </div>
</div>