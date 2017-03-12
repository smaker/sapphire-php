<?php
/**
 * Index Page
 * @author Simplecode <simplecode@sensitivecms.com>
 * @link http://sensitivecms.com
 */

// PHP 버전을 확인하고, 이를 만족하지 못하면 실행을 중단한다.
if(version_compare(PHP_VERSION, '5.3.3', '<'))
{
	header('Content-Type: text/html; charset=utf-8');
	echo '현재 사용중인 PHP 버전은 호환되지 않는 버전이기 때문에 어플리케이션 실행을 중단합니다. PHP 버전을 업데이트 해주세요.';
	echo '<br><br>현재 사용중인 PHP 버전은 <b>'. PHP_VERSION . '</b>입니다.';
	exit;
}

// 설치 경로
define('BASEDIR', __DIR__ . '/');

// 부트엔진 로드
require dirname(__FILE__) . '/_core/bootloader.php';
