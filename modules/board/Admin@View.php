<?php
namespace Module\Board;

use Core\Frontend as FrontEnd;
use Core\Uri;
use Core\Template;
use Core\Response;
use Core\Input;
use Core\Theme;
use Core\Database as DB;

class AdminView extends \Core\Module\View
{
	public function __construct()
	{
		$this->module = 'board';
		$this->db = DB::getConnection();
	}

	public function boardList()
	{
		$result = $this->db->select('*')->from('st_instances')->where('type', 'board')->get();

		$row = array();

		while($obj = $result->fetch_object())
		{
			$row[] = $obj;
		}

		$result->close();

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar(['instances' => $row]);
		$this->setTemplatePath('./modules/board/view/');
		$this->setTemplateFile('board_list');
	}

	public function boardCreate()
	{
		FrontEnd::addJs('/modules/board/view/js/create.js');

		$var = array(
			'siteThemes' => Theme::getInstalledThemes()
		);

		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplatePath('./modules/board/view/');
		$this->setTemplateFile('boardCreate');
	}

	public function edit()
	{
		if(!isset($_SESSION['TOAST_TYPE']))
		{
			$_SESSION['TOAST_TYPE'] = '';
		}

		if(!isset($_SESSION['TOAST_MESSAGE']))
		{
			$_SESSION['TOAST_MESSAGE'] = '';
		}

		FrontEnd::addCss('/assets/core/plugins/css/jquery.toast.css');
		FrontEnd::addJs('/modules/board/view/js/edit.js');
		FrontEnd::addJs('/assets/core/plugins/js/jquery.toast.js');

		$instanceId = intval(Uri::get(3));

		$result = $this->db->query('SELECT * FROM `st_instances` WHERE `type` = "board" AND `instanceId` = ' . $instanceId)->fetch_object();
		$result->config = \Core\Module\Instance\Handler::getConfig($instanceId);

		$section = Input::get('section');
		if(!isset($section))
		{
			$section = '';
		}

		$var = array(
			'board' => $result,
			'section' => $section,
			'TOAST_MESSAGE' => $_SESSION['TOAST_MESSAGE'],
			'TOAST' => array(
				'type' => $_SESSION['TOAST_TYPE'],
				'message' => $_SESSION['TOAST_MESSAGE']
			),
		);

		$templateFile = 'board_edit';

		switch($section)
		{
			case 'permisson':
				$templateFile = 'boardPermission';
				break;
			default:
				$var['siteThemes'] = Theme::getInstalledThemes();
		}

		$_SESSION['TOAST_TYPE'] = '';
		$_SESSION['TOAST_MESSAGE'] = '';


		$this->setLayoutPath('modules/admin/view/_layout.php');
		$this->setTemplateVar($var);
		$this->setTemplatePath('./modules/board/view/');
		$this->setTemplateFile($templateFile);
	}
}
