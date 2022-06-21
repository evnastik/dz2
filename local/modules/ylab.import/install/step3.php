<?if(!check_bitrix_sessid()) return;?>
<?
use Bitrix\Main\Localization\Loc;
echo CAdminMessage::ShowNote(Loc::getMessage('YLAB_IMPORT_MODULE_SUCCESS'));
?>
<form action="<?= $APPLICATION->getCurPage(); ?>">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="submit" value="<?=Loc::getMessage('YLAB_IMPORT_MODULE_PREV')?>">
</form>