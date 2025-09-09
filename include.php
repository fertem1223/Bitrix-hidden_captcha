<?php
if (COption::GetOptionString('frt.hidden_captcha', "hidden_captcha_activity_" . SITE_ID) == 'Y') {

	global $USER, $APPLICATION;
	$APPLICATION->AddHeadScript('/bitrix/js/frt.hidden_captcha/script.js');
	$APPLICATION->SetAdditionalCss('/bitrix/css/frt.hidden_captcha/style.css');
	
	//Подключаем класс
	include(__DIR__ . "/class/frt_checkingRobot.php");
	//Подключаем обработчики
	include(__DIR__ . "/events.php");
}
