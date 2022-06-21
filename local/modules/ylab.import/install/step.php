<?if(!check_bitrix_sessid()) return;?>
<?
    echo CAdminMessage::ShowNote("Модуль dv_module установлен");
?>
<form action="<?= $APPLICATION->getCurPage(); ?>">
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="Назад к списку модулей">
</form>
