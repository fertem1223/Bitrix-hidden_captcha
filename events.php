<?php
use Bitrix\Main\EventManager;

$checkingRobot = new checkingRobot();

EventManager::getInstance()->addEventHandler('form', 'onBeforeResultAdd', [$checkingRobot, 'checkWebForm']);
EventManager::getInstance()->addEventHandler('blog', 'OnBeforeCommentAdd', [$checkingRobot, 'checkWebForm']);