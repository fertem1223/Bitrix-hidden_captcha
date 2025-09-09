<?php

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

class frt_hidden_captcha extends CModule
{
	var $MODULE_ID;
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;

	public function __construct()
	{
		$arModuleVersion = array();

		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path . "/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)) {
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_ID = 'frt.hidden_captcha';

		$this->MODULE_NAME = Loc::getMessage('hidden_captcha_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('hidden_captcha_MODULE_DESCRIPTION');
		$this->PARTNER_NAME = Loc::getMessage('hidden_captcha_PARTNER_NAME');
		$this->PARTNER_URI = Loc::getMessage('hidden_captcha_PARTNER_URI');
	}

	public function doInstall()
	{
		$this->InstallFiles();
		ModuleManager::registerModule($this->MODULE_ID);
		RegisterModuleDependences("main", "OnBeforeProlog", $this->MODULE_ID);
	}

	public function doUninstall()
	{
		ModuleManager::unRegisterModule($this->MODULE_ID);
		UnRegisterModuleDependences("main", "OnBeforeProlog", $this->MODULE_ID);
		$this->UnInstallFiles();
	}

	public function InstallFiles()
	{
		CopyDirFiles(__DIR__ . "/js", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/js/frt.hidden_captcha", true, true);
		CopyDirFiles(__DIR__ . "/css", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/css/frt.hidden_captcha", true, true);
		return true;
	}

	public function UnInstallFiles()
	{
		DeleteDirFilesEx("/bitrix/js/frt.hidden_captcha/script.js");
		DeleteDirFilesEx("/bitrix/css/frt.hidden_captcha/style.css");
		return true;
	}
}
