<?if(!check_bitrix_sessid()) return;?>
<?
use Bitrix\Main\Localization\Loc;
?>
<form action="<?= $APPLICATION->getCurPage(); ?>" name="form1">
    <?=bitrix_sessid_post()?>
    <input type="hidden" name="lang" value="<?= LANGUAGE_ID; ?>" />
    <input type="hidden" name="step" value="2" />
    <input type="hidden" name="id" value="ylab.import">
    <input type="hidden" name="install" value="Y">
    <table>
        <tr style="vertical-align: top">
            <td  style="padding: 10px"><label><?=Loc::getMessage('YLAB_IMPORT_MODULE_LIMIT')?></label></td>
            <td  style="padding: 10px"> <input type="text" size="" maxlength="255" value="200" name="limit_to_import"></td>
        </tr>
        <tr style="vertical-align: top">
            <td  style="padding: 10px"><label>textarea</label></td>
            <td  style="padding: 10px"><textarea rows="8" cols="60" name="textarea">аааа</textarea></td>
        </tr>
    </table>
    <br>
    <input type="submit" name="inst" value="<?=Loc::getMessage('YLAB_IMPORT_MODULE_NEXT')?>">
</form>
