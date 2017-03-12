<?php

namespace Module\Member;

use Core\Router;

class Base extends \Core\Module\Base
{
	public function __construct()
	{
		Router::fixed('auth/login', 'member.view.login');
		Router::fixed('auth/logout', 'member.view.logout');

		Router::fixed('join', 'member.view.join');
		Router::fixed('login/kakao', 'member.view.loginKakao');

		Router::post('login', 'member.controller.login');
		Router::post('join', 'member.controller.join');
		Router::post('logout', 'member.controller.logout');

		Router::fixed('admin/member', 'member.AdminView.memberList');
		Router::fixed('admin/member/signup', 'member.AdminView.memberSignupForm');
		Router::fixed('admin/member/group', 'member.AdminView.memberGroupList');
		Router::fixed('admin/member/add', 'member.AdminView.memberCreate');

		Router::get('^@[a-zA-Z0-9_]+$', 'member.view.memberPage');

		Router::get('admin/member/edit/[0-9]+', 'member.AdminView.memberEdit');

		// Admin Process Routes
		Router::post('admin/member/add', 'member.AdminController.addMember');
		Router::post('admin/member/deleteMember.do', 'member.AdminController.deleteMember');

		$this->registerMenu();
	}

	public function registerMenu()
	{

	}
}
