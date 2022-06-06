<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true){
    die();
}

use Bitrix\Main\Localization\Loc;

?>

    <div>
        <b><?= Loc::getMessage("YLAB.PROMO.IF_YES")?></b>
        <?php if($arResult['IF_PROMO']){?>
            <?= Loc::getMessage("YLAB.PROMO.YES")?>
        <?php } else { ?>
            <?= Loc::getMessage("YLAB.PROMO.NO")?>
        <?php } ?>
    </div>
    <div class="list">
    <b><?= Loc::getMessage("YLAB.PROMO.ITEMS")?></b>
        <?php $countItem500 = 0; ?>
<?php foreach ($arResult['BASKET_ITEMS'] as $basketItem){ ?>
        <?php if($basketItem->getPrice() >= 500){
            $countItem500 += $basketItem->getQuantity();
    }?>
    <div>
        <p><?= $basketItem->getField('NAME') . ' - ' . $basketItem->getQuantity() . ' - ' . $basketItem->getPrice() .' руб.<br/>' ?></p>
    </div>
    <hr/>
<?php } ?>
    </div>
<form action="/lesson2/">
    <p><?= Loc::getMessage("YLAB.PROMO.PODAROK_QUANTITY")?></p>
    <input type="text" name="PODAROK_QUANTITY" value="<?=$_GET['PODAROK_QUANTITY']?>">
    <input type="submit" value="<?= Loc::getMessage("YLAB.PROMO.BTN")?>">
</form>
