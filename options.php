<?php
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\HttpApplication;
use Bitrix\Main\Config\Option;

require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_admin_after.php');

$request = HttpApplication::getInstance()->getContext()->getRequest();
$module_id = htmlspecialchars($request['mid'] != '' ? $request['mid'] : $request['id']);

//Формируем массив вкладок
$aTabs = [];

$rsSites = CSite::GetList($by = 'sort', $order = "asc", ['ACTIVE' => 'Y']);
$indexSite = 0;
while ($arSite = $rsSites->Fetch()) {
?>
	<?
	//Вкладка «Дополнительные настройки»
	$aTabs[$indexSite] = [
		'DIV'     => 'settings_' . $arSite['LID'],
		'TAB'     => $arSite['NAME'],
		'TITLE'   => $arSite['NAME'],
		"ONSELECT" => "additionalHandler()",
		'OPTIONS' => [
			'Настройки модуля',
			[
				'hidden_captcha_activity_' . $arSite['LID'],
				'Использовать капчу на формах сайта',
				'',
				['checkbox', 'N']
			]
		]
	];
	$indexSite++;
	?>
<?
}
//Выводим список вкладок.
$tabControl = new CAdminTabControl(
	'tabControl',
	$aTabs
);
//Создаем форму для редактирвания параметров модуля
?>
<form action="<?= $APPLICATION->getCurPage(); ?>?mid=<?= $module_id; ?>&lang=<?= LANGUAGE_ID; ?>" method="post">
	<?
	// Отобразим заголовки закладок
	$tabControl->begin();
	?>
	<?= bitrix_sessid_post(); // Проверка идентификатора сессии
	foreach ($aTabs as $aTab) { // Цикл по вкладкам
		$tabControl->beginNextTab();
		//Если есть параметры для текущей вкладки то генерируем содержимое вкладки из них
		if ($aTab['OPTIONS']) {
			__AdmSettingsDrawList($module_id, $aTab['OPTIONS']);
		};
	?>
	<?
	};
	//Вывод кнопок кастомный
	$tabControl->buttons(); ?>
	<input type="submit" name="apply" value="Сохранить настройки" class="adm-btn-save" />
	<? $tabControl->end(); ?>
</form>

<? \Bitrix\Main\UI\Extension::load("ui.notification"); ?>

<?
//Обрабатываем данные после отправки формы
if ($request->isPost() && check_bitrix_sessid()) {
	foreach ($aTabs as $aTab) { // цикл по вкладкам
		foreach ($aTab['OPTIONS'] as $arOption) {
			if (!is_array($arOption)) { // если это название секции
				continue;
			}
			if ($request['update']) {
				if ($arOption[0] == "ACTIVE_COMPONENT") {
					if ($arOption[2] == '') {
						$arOption[2] = 'N';
					};
					Option::set($module_id, $arOption[0], $arOption[2]);
				}
			}
			if ($arOption['note']) { // если это примечание
				continue;
			}
			if ($request['apply']) { // сохраняем введенные настройки
				$optionValue = $request->getPost($arOption[0]);
				if ($arOption[0] == 'switch_on' && $arOption[0] == 'jquery_on') {
					if ($optionValue == '') {
						$optionValue = 'N';
					}
				}
				Option::set($module_id, $arOption[0], is_array($optionValue) ? implode(',', $optionValue) : $optionValue);
			}
		}
	}

	LocalRedirect($APPLICATION->getCurPage() . '?mid=' . $module_id . '&lang=' . LANGUAGE_ID);
}
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/epilog_admin.php");
?>