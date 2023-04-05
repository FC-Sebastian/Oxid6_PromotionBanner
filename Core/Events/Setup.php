<?php

namespace seb\banner\Core\Events;

use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\DbMetaDataHandler;
use OxidEsales\Eshop\Core\Registry;

class Setup extends Base
{

    public static function onActivate()
    {
        self::alterDbTables();
        self::updateDbViews();
    }

    public static function alterDbTables()
    {
        $db = DatabaseProvider::getDb();
        if ($db->getOne("SHOW COLUMNS FROM oxarticles LIKE 'OXSEBBANNERID'") === false) {
            $db->execute("ALTER TABLE oxarticles ADD OXSEBBANNERID CHAR(32) NULL");
            $db->execute("ALTER TABLE oxcategories ADD OXSEBBANNERID CHAR(32) NULL");
            $db->execute("ALTER TABLE oxmanufacturers ADD OXSEBBANNERID CHAR(32) NULL");
            $db->execute("CREATE TABLE oxsebbanner (OXID CHAR(32) COLLATE latin1_general_ci,OXSHOPID INT(11) DEFAULT 1, OXACTIVEFROM DATETIME, OXACTIVETO DATETIME, OXBANNERPIC VARCHAR(128) COLLATE utf8_general_ci, PRIMARY KEY (OXID))");
        }
    }

    public static function updateDbViews()
    {
        if (Registry::getSession()->getVariable("malladmin")){
            $meta = oxNew(DbMetaDataHandler::class);
            $meta->updateViews();
        }
    }
}