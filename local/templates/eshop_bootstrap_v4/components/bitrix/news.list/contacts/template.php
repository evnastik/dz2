<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="news-list">
    <? if ($arParams["DISPLAY_TOP_PAGER"]): ?>
        <?= $arResult["NAV_STRING"] ?><br/>
    <? endif; ?>
    <? foreach ($arResult["ITEMS"] as $arItem): ?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
    <p class="news-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
        <? if ($arParams["DISPLAY_NAME"] != "N" && $arItem["NAME"]): ?>
            <? if (!$arParams["HIDE_LINK_WHEN_NO_DETAIL"] || ($arItem["DETAIL_TEXT"] && $arResult["USER_HAVE_ACCESS"])): ?>
                <a href="<? echo $arItem["DETAIL_PAGE_URL"] ?>"><b><? echo $arItem["NAME"] ?></b></a><br/>
            <? else: ?>
                <b><? echo $arItem["NAME"] ?></b><br/>
            <? endif; ?>
        <? endif; ?>
        <? if ($arParams["DISPLAY_PREVIEW_TEXT"] != "N" && $arItem["PREVIEW_TEXT"]): ?>
            <? echo $arItem["PREVIEW_TEXT"]; ?>
        <? endif; ?>
        <? if ($arParams["DISPLAY_PICTURE"] != "N" && is_array($arItem["PREVIEW_PICTURE"])): ?>
            <div style="clear:both"></div>
        <? endif ?>
        <? foreach ($arItem["FIELDS"] as $code => $value): ?>
            <small>
                <?= GetMessage("IBLOCK_FIELD_" . $code) ?>:&nbsp;<?= $value; ?>
            </small><br/>
        <? endforeach; ?>
        <? foreach ($arItem["DISPLAY_PROPERTIES"] as $pid => $arProperty): ?>
            <?
            if ($arProperty["CODE"] == "address") {/*
                if ($arItem["PROPERTIES"]["address"]["VALUE"]) {

                    $props = CIBlockElement::GetByID($arItem["PROPERTIES"]["address"]["VALUE"])->GetNextElement()->GetProperties();
                    ?>
                    <small>
                        <?= $props["city"]["NAME"] ?>:&nbsp;<?= $props["city"]["~VALUE"] ?><br/>
                        <?= $props["street"]["NAME"] ?>:&nbsp;<?= $props["street"]["~VALUE"] ?><br/>
                        <?= $props["house"]["NAME"] ?>:&nbsp;<?= $props["house"]["~VALUE"] ?><br/>
                        <?= $props["flat"]["NAME"] ?>:&nbsp;<?= $props["flat"]["~VALUE"] ?>
                    </small><br/>
                <? } */
            } else {
                ?>
                <small>
                    <?= $arProperty["NAME"] ?>:&nbsp;
                    <? if (is_array($arProperty["DISPLAY_VALUE"])): ?>
                        <?= implode("&nbsp;/&nbsp;", $arProperty["DISPLAY_VALUE"]); ?>
                    <? else: ?>
                        <?= $arProperty["DISPLAY_VALUE"]; ?>
                    <? endif ?>
                </small><br/>
            <? } ?>
        <? endforeach; ?>
        <small>
            <?= GetMessage("IBLOCK_FIELD_CITY") ?>:&nbsp;<?= $arItem["PROPERTY_ADDRESS_PROPERTY_CITY_VALUE"] ?>
        </small><br/>
        <small>
            <?= GetMessage("IBLOCK_FIELD_STREET") ?>:&nbsp;<?= $arItem["PROPERTY_ADDRESS_PROPERTY_STREET_VALUE"] ?>
        </small><br/>
        <small>
            <?= GetMessage("IBLOCK_FIELD_HOUSE") ?>:&nbsp;<?= $arItem["PROPERTY_ADDRESS_PROPERTY_HOUSE_VALUE"] ?>
        </small><br/>
        <small>
            <?= GetMessage("IBLOCK_FIELD_FLAT") ?>:&nbsp;<?= $arItem["PROPERTY_ADDRESS_PROPERTY_FLAT_VALUE"] ?>
        </small><br/>
        </p>
    <? endforeach; ?>
    <? if ($arParams["DISPLAY_BOTTOM_PAGER"]): ?>
        <br/><?= $arResult["NAV_STRING"] ?>
    <? endif; ?>
</div>
