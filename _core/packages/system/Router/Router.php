<?php
namespace Core;

use Core\Template;
use Core\Response;
use Core\Theme;
use Core\Frontend as FrontEnd;
use Core\Theme as CoreTheme;

/**
 * 브라우저를 통해 들어온 요청을 처리하는 역할을 하는 class
 * @class Router
 * @author SimpleCode <master@sensitivecms.com>
 */
class Router
{
	/** @var array 등록된 route */
	private static $routes = array(
		'get' => array(),
		'post' => array(),
		'fixed' => array()
	);

	/**
	 * 라우터 초기화
	 */
	public static function init()
	{
		// 기본 route를 등록한다
		self::get('^[a-z0-9_]+$', function() {
			$siteInfo = \bootloader::getCurrentSiteInfo();

			$id = Uri::get(0);

			$instance = instance($id, $siteInfo->siteId);

			if(!isset($instance->id))
			{
				header('HTTP/1.0 404 Not Found');
				Response::notFound();
				exit();
			}

			Frontend::setTitle($instance->title);

			$moduleInfo = module($instance->type);

			$call = 'Module\\' .  ucfirst($instance->type) . '\\View';

			$method = $moduleInfo->defaultViewMethod;

			$module = new $call();
			$module->setModule($instance);
			$module->setTemplatePath($module->getViewPath());

			$view = $module->{$method}();

			// 템플릿 객체 생성
			$template = new Template($view->getTemplateFile(), $view->getTemplateVar());

			$siteTheme = $view->config->siteTheme;

			// 빈 사이트 테마를 사용한다면
			if($siteTheme == '@')
			{
				Response::toHTML($template);
				return TRUE;
			}

			$theme = CoreTheme::getTheme($siteTheme);
			$themeHtml = $theme->render($template);

			Response::toHTML($themeHtml);

			// Continue
			return TRUE;
		});
	}

	public static function destory()
	{
		self::$routes = NULL;
	}

	/**
	 * GET 요청을 처리하기 위한 route 등록
	 * @param string			$pattern	URL 규칙
	 * @param string|function	$callback	route 동작 방식을 정한다
	 * @return void
	 */
	public static function get($pattern, $callback)
	{
		self::$routes['get'][$pattern] = $callback;
	}

	/**
	 * POST 요청을 처리하기 위한 route 등록
	 * @param string			$pattern	URL 규칙
	 * @param string|function	$callback	route 동작 방식을 정한다
	 * @return void
	 */
	public static function post($pattern, $callback)
	{
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			self::$routes['post'][$pattern] = $callback;
		}
	}

	/**
	 * 고정된 URL 요청을 처리하기 위한 route 등록
	 * @param string			$pattern	URL 규칙
	 * @param string|function	$callback	route 동작 방식을 정한다
	 * @return void
	 */
	public static function fixed($pattern, $callback)
	{
		self::$routes['fixed'][$pattern] = $callback;
	}

	/**
	 * 등록된 모든 route를 반환한다
	 * @param string|null $type
	 * @return array
	 */
	public static function getRoutes($type = '')
	{
		if(!$type)
		{
			return self::$routes;
		}

		if($type == 'fixed' || $type == 'get' || $type == 'post')
		{
			return self::$routes[$type];
		}

		return array();
	}

	/**
	 * 요청받은 URL과 맞는 route를 검색
	 */
	public static function findRoute()
	{
		$path = \Core\Uri::getCurrentUri();

		$notFoundRoutes = TRUE;

		// GET 요청인 경우
		if($_SERVER['REQUEST_METHOD'] == 'GET')
		{
			$fixedRoutes = self::getRoutes('fixed');
			$getRoutes = self::getRoutes('get');

			// fixed route가 있는 경우
			if(isset($fixedRoutes[$path]))
			{
				// 해당 route가 module route인 경우
				if(is_string($fixedRoutes[$path]))
				{
					$parts = explode('.', $fixedRoutes[$path]);
					$module = $parts[0];
					$type = $parts[1];
					$method = $parts[2];


					$call = 'Module\\' . $module . '\\' . ucfirst($type);
					$view = new $call();

					// 해당 module에 method가 있는지 확인한다
					if(method_exists($view, $method))
					{
						$output = $view->{$method}();

						// view인 경우
						if($type == 'view' || $type == 'AdminView')
						{
							// view 템플릿 객체 생성
							$viewTemplate = new Template($view->getTemplateFile(), $view->getTemplateVar());

							// 레이아웃 템플릿 객체 생성
							$layoutTemplate = new Template($view->getLayoutPath());

							// adminView인 경우
							if($type == 'AdminView')
							{
								// 기본 브라우저 제목
								Frontend::setTitle('SenstiveCMS Admin');

								// 관리자 페이지용 css/js 로드
								FrontEnd::addCss('/modules/admin/view/css/admin.css');
								FrontEnd::addJs('/modules/admin/view/js/admin.js');

								$layoutTemplate->assign('admin_menu', module('admin')->getAdminMenu());
								$layoutTemplate->assign('admin_content', $viewTemplate);
							}
							// view인 경우
							else
							{
								$layoutTemplate->assign('content', $viewTemplate);
							}

							Response::toHTML($layoutTemplate);
						}

						return $output;
					}
					else
					{
						return 'fuck';
					}
				}
				elseif(is_callable($fixedRoutes[$path]))
				{
					return $fixedRoutes[$path];
				}
			}
			else
			{
				foreach($getRoutes as $pattern => $route)
				{
					if(preg_match('#' . $pattern . '#', $path))
					{
						// 해당 route가 module route인 경우
						if(is_string($route))
						{
							$parts = explode('.', $route);
							$module = $parts[0];
							$type = $parts[1];
							$method = $parts[2];


							$call = 'Module\\' . $module . '\\' . ucfirst($type);
							$view = new $call();

							// 해당 module에 method가 있는지 확인한다
							if(method_exists($view, $method))
							{
								$output = $view->{$method}();

								// view인 경우
								if($type == 'view' || $type == 'AdminView')
								{
									$viewTemplate = new Template($view->getTemplateFile(), $view->getTemplateVar());

									// 레이아웃 템플릿 객체 생성
									$layoutTemplate = new Template('./modules/admin/view/_layout.php');
									// adminView인 경우
									if($type == 'AdminView')
									{
										// 기본 브라우저 제목
										Frontend::setTitle('SenstiveCMS Admin');

										// 관리자 페이지용 css/js 로드
										FrontEnd::addCss('/modules/admin/view/css/admin.css');
										FrontEnd::addJs('/modules/admin/view/js/admin.js');

										$layoutTemplate->assign('admin_menu', module('admin')->getAdminMenu());
										$layoutTemplate->assign('admin_content', $viewTemplate);
										Response::toHTML($layoutTemplate);
									}
									// view인 경우
									else
									{
										$instanceConfig = \Core\Module\Instance\Handler::getConfig($output->instance->instanceId);

										$siteTheme = $instanceConfig->siteTheme;

										// 빈 사이트 테마를 사용하는 경우
										if($siteTheme == '@')
										{
											Response::toHTML($viewTemplate);
											return $output;
										}

										$theme = Theme::getTheme($siteTheme);
										$themeHtml = $theme->render($viewTemplate);

										Response::toHTML($themeHtml);
									}
								}

								return $output;
							}
						}
						elseif(is_callable($route))
						{
							return $route;
						}

						$notFoundRoutes = FALSE;
						break;
					}
				}
			}
		}
		// POST 요청인 경우
		elseif($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$postRoutes = self::getRoutes('post');

			foreach($postRoutes as $pattern => $route)
			{
				if(preg_match('#' . $pattern . '#', $path))
				{
					if(is_string($route))
					{
						$parts = explode('.', $route);
						$module = ucfirst($parts[0]);
						$type = ucfirst($parts[1]);
						$method = $parts[2];

						$call = 'Module\\' . $module . '\\' . $type;
						$view = new $call();
						return $view->{$method}();
					}
					elseif(is_callable($route))
					{
						return $route;
					}
					$notFoundRoutes = FALSE;
					break;
				}
			}
		}
		return !$notFoundRoutes;
	}
}
