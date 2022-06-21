<?php
require_once __DIR__ . '/../vendor/autoload.php';
define("LOG_FILENAME", $_SERVER["DOCUMENT_ROOT"]."/local/log/log.txt");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("MyClass", "OnAfterIBlockElementAddHandler"));

class MyClass
{
    // создаем обработчик события "OnAfterIBlockElementAdd"
    function OnAfterIBlockElementAddHandler(&$arFields)
    {
        if($arFields["ID"]>0 && $arFields["IBLOCK_ID"] == 2)
            AddMessage2Log("Запись с кодом ".$arFields["ID"]." добавлена.");
        else
            AddMessage2Log("Ошибка добавления записи (".$arFields["RESULT_MESSAGE"].").");
    }
}