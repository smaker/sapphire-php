<?php
/**
 * Index Page
 * @author SimpleCode <smaker@simplesoftcorp.com>
 * @link https://simplesoftcorp.com
 */

// 모든 오류를 출력한다
error_reporting(E_ALL);

// PHP 버전을 확인하고, 이를 만족하지 못하면 실행을 중단한다.
if(version_compare(PHP_VERSION, '7.4.0', '<'))
{
	header('Content-Type: text/html; charset=utf-8');
	echo '현재 사용중인 PHP 버전은 호환되지 않는 버전이기 때문에 어플리케이션 실행을 중단합니다. PHP 버전을 업데이트 해주세요.';
	echo '<br><br>현재 사용중인 PHP 버전은 <b>'. PHP_VERSION . '</b>입니다.';
	exit;
}

// 부트엔진 로드
require __DIR__ . '/_core/bootloader.php';
