<?php
require_once $_SERVER["DOCUMENT_ROOT"]. "/bitrix/header.php";
?>
<?php
$APPLICATION->IncludeComponent(
    'ylab:promo',
    '.default',
    []
)
?>
<?php
require_once $_SERVER["DOCUMENT_ROOT"]. "/bitrix/footer.php";
?>