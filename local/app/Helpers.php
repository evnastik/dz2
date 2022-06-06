<?php

namespace Ylab;

use mysql_xdevapi\Exception;

class Helpers
{
    public static function getIblockIdByCode($code)
    {
        if(!\Bitrix\Main\Loader::includeModule('iblock')){
            return;
        }
        $IB = \Bitrix\Iblock\IblockTable::getList([
            'select' => ['ID'],
            'filter' => ['CODE' => $code],
            'limit' => 1,
            'cache' => ['ttl' => 3600],
        ]);
        $return = $IB->fetch();
        if(!$return){
            throw new \Exception('Iblock with code"'.$code.'" not found!');
        }
        return $return['ID'];
    }
}