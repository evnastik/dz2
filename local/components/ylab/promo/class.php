<?php

namespace Ylab\Components;

use Bitrix\Main\Context;
use Bitrix\Main\Loader;
use Bitrix\Sale\Fuser;
use CBitrixComponent;
use Bitrix\Sale\Basket;
use Bitrix\Main\Localization\Loc;


class PromoComponent extends CBitrixComponent{

    private $totalCost = 1500;

    public function executeComponent()
    {
        Loader::includeModule("catalog");
        $podarok_id = \CIBlockFindTools::GetElementID(false,"podarok", false, false, false);
        if(isset($_GET["PODAROK_QUANTITY"]) && !empty($_GET["PODAROK_QUANTITY"])){
            $this->addItemsToBasket($podarok_id, $_GET["PODAROK_QUANTITY"]);
            echo Loc::getMessage("YLAB.PROMO.ADD_TO_BASKET") . " ( " . $_GET["PODAROK_QUANTITY"] . Loc::getMessage("YLAB.PROMO.QUANTITY") . ")";
        }
        $basket = \Bitrix\Sale\Basket::LoadItemsForFUser(
            \Bitrix\Sale\Fuser::getId(),
            SITE_ID
        );
        if($this->countItems($basket->getBasketItems()) >= 3){
            $this->addItemsToBasket($podarok_id, 1);
        }
        $basket = \Bitrix\Sale\Basket::LoadItemsForFUser(
            \Bitrix\Sale\Fuser::getId(),
            SITE_ID
        );
        $this->arResult['BASKET_ITEMS'] = $basket->getBasketItems();
        $this->arResult['IF_PROMO'] = $this->checkIfGivePromo($basket->getPrice());
        $this->includeComponentTemplate();
    }
    public function checkIfGivePromo(float $total): bool
    {
        return $total > $this->totalCost;
    }
    public function countItems($basketItems)
    {
        $countItem500 = 0;
        foreach ($basketItems as $basketItem) {
            if($basketItem->getField('NAME') == "Подарок"){
                $countItem500 = 0;
                break;
            }
            if($basketItem->getPrice() >= 500){
                $countItem500 += $basketItem->getQuantity();
            }
        }
        return $countItem500;
    }
    public function addItemsToBasket($productId, $quantity)
    {
        $result = \Bitrix\Catalog\Product\Basket::addProduct(['PRODUCT_ID' => $productId, 'QUANTITY' => $quantity]);
        if (!$result->isSuccess()) {
            var_dump($result->getErrorMessage());
        }
    }
}
?>