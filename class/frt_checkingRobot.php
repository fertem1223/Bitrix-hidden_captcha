<?php

class checkingRobot
{
    //Проверка форм из модуля веб форм
    function checkWebForm()
    {
        global $APPLICATION;

        //Проверяем бот ли заполнил форму
        if ($_REQUEST['testing_humanity'] != 'Qj8o#EcaF2K3KY1') {
            $APPLICATION->ThrowException('Вы не прошли проверку на робота');
            return false;
        }
    }
}
