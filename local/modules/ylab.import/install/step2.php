<?if(!check_bitrix_sessid()) return;?>
<?
use Bitrix\Main\Localization\Loc;
?>
<form action="<?= $APPLICATION->getCurPage(); ?>" name="form2">
    <?= bitrix_sessid_post() ?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="hidden" name="step" value="3" />
    <input type="hidden" name="id" value="ylab.import">
    <input type="hidden" name="install" value="Y">
    <input type="hidden" name="limit_to_import" value="<?=$_GET["limit_to_import"]?>">
    <input type="hidden" name="textarea" value="<?=$_GET["textarea"]?>">
    <input type="hidden" name="install" value="Y">
    <table>
        <tr style="vertical-align: top">
            <td  style="padding: 10px"><label>password</label></td>
            <td  style="padding: 10px"><input type="password" size="20" maxlength="255" value="" name="password" autocomplete="new-password"></td>
        </tr>
        <tr style="vertical-align: top">
            <td  style="padding: 10px"><label for="checkbox">checkbox</label></td>
            <td  style="padding: 10px"><input type="checkbox" id="checkbox" name="checkbox" value="Y" checked="" onclick="" ></td>
        </tr>
    </table>
    <input type="submit" value="<?=Loc::getMessage('YLAB_IMPORT_MODULE_NEXT')?>">
</form>