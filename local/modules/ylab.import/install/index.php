<?php

use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\IO\Directory;
use Bitrix\Main\IO\File;
use Bitrix\Main\ModuleManager;

/**
 * Class ylab_import
 * Модуль импорта товаров
 */
class ylab_import extends CModule
{
    /**
     * ID модуля
     * @var string
     */
    public $MODULE_ID = 'ylab.import';

    /**
     * constructor
     */
    public function __construct()
    {
        $arModuleVersion = [];

        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion) && array_key_exists('VERSION', $arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion['VERSION'];
            $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];
        }

        $this->MODULE_NAME = Loc::getMessage('YLAB_IMPORT_MODULE_NAME');
        $this->MODULE_DESCRIPTION = Loc::getMessage('YLAB_IMPORT_MODULE_DESCRIPTION');
    }

    /**
     * @return bool|void
     */
    public function DoInstall()
    {
        global $DOCUMENT_ROOT, $APPLICATION;
        if($_GET['step'] == 3) {
            $this->installDB();
            $this->installFiles();
            ModuleManager::registerModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(Loc::getMessage('YLAB_IMPORT_MODULE_STEP3'), $DOCUMENT_ROOT."/local/modules/ylab.import/install/step3.php");
        }elseif ($_GET['step'] == 2){
            $APPLICATION->IncludeAdminFile(Loc::getMessage('YLAB_IMPORT_MODULE_STEP2'), $DOCUMENT_ROOT."/local/modules/ylab.import/install/step2.php");

        }else{
            $APPLICATION->IncludeAdminFile(Loc::getMessage('YLAB_IMPORT_MODULE_STEP1'), $DOCUMENT_ROOT."/local/modules/ylab.import/install/step.php");
        }

    }

    /**
     * @return bool|void
     */
    public function DoUninstall()
    {
        $this->uninstallDB();
        $this->uninstallFiles();

        ModuleManager::unregisterModule($this->MODULE_ID);
        return true;
    }

    /**
     * @param array $arParams
     * @return bool|void
     */
    public function installFiles($arParams = array())
    {
        $root = Application::getDocumentRoot();

        CopyDirFiles(__DIR__ . '/components/', $root . '/local/components', true, true);

        if (is_dir($sPachDir = $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/admin')) {
            if ($sDir = opendir($sPachDir)) {
                while (false !== $sItem = readdir($sDir)) {
                    if ($sItem == '..' || $sItem == '.' || $sItem == 'menu.php') {
                        continue;
                    }

                    file_put_contents($file = $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $sItem,
                        '<' . '? require($_SERVER["DOCUMENT_ROOT"] . "/local/modules/' . $this->MODULE_ID . '/admin/' . $sItem . '");?' . '>');
                }

                closedir($sDir);
            }
        }


        return true;
    }

    /**
     * @return bool|void
     */
    public function uninstallFiles()
    {
        if (Directory::isDirectoryExists($path = $this->GetPath() . '/admin')) {
            DeleteDirFiles($_SERVER['DOCUMENT_ROOT'] . $this->GetPath() . '/admin/',
                $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin');

            if ($dir = opendir($path)) {
                while (false !== $item = readdir($dir)) {
                    File::deleteFile($_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin/' . $this->MODULE_ID . '_' . $item);
                }

                closedir($dir);
            }
        }

        DeleteDirFiles(__DIR__ . "/components", $_SERVER["DOCUMENT_ROOT"] . "/bitrix/components");

        return true;
    }

    /**
     * @return bool
     */
    public function installDB()
    {
        $sPath = $this->getPath() . '/install/db/mysql/up/';
        $oConn = Application::getConnection();
        $arFiles = scandir($sPath, SCANDIR_SORT_NONE);

        foreach ($arFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $sQuery = file_get_contents($sPath . $file);
            $oConn->executeSqlBatch($sQuery);
        }

        COption::SetOptionString($this->MODULE_ID, "limit_to_import", $_GET["limit_to_import"]);
        COption::SetOptionString($this->MODULE_ID, "textarea", $_GET["textarea"]);
        COption::SetOptionString($this->MODULE_ID, "password", $_GET["password"]);
        COption::SetOptionString($this->MODULE_ID, "checkbox", $_GET["checkbox"]);

        return true;
    }

    /**
     * @return bool|void
     */
    public function uninstallDB()
    {
        $sPath = $this->getPath() . '/install/db/mysql/down/';
        $oConn = Application::getConnection();
        $arFiles = scandir($sPath, SCANDIR_SORT_NONE);

        foreach ($arFiles as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }

            $sQuery = file_get_contents($sPath . $file);
            $oConn->executeSqlBatch($sQuery);
        }

        return true;
    }

    /**
     * @param bool $bNotDocumentRoot
     * @return mixed|string
     */
    public function GetPath($bNotDocumentRoot = false)
    {
        if ($bNotDocumentRoot) {
            return str_ireplace(Application::getDocumentRoot(), '', str_replace('\\', '/', dirname(__DIR__)));
        }

        return dirname(__DIR__);
    }
}