<?php

namespace seb\banner\Core\Events;

use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\DbMetaDataHandler;
use OxidEsales\Eshop\Core\Registry;

/**
 * handles oxid onActivate event
 */
class Setup extends Base
{

    /**
     * onActivate event function
     * changes db and updates db views
     *
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     * @return void
     */
    public static function onActivate()
    {
        self::alterDbTables();
        self::updateDbViews();
    }

    /**
     * adds necessary columns and table to db if not already done
     *
     * @return void
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseConnectionException
     * @throws \OxidEsales\Eshop\Core\Exception\DatabaseErrorException
     */
    public static function alterDbTables()
    {
        $db = DatabaseProvider::getDb();
        if ($db->getOne("SHOW COLUMNS FROM oxarticles LIKE 'OXSEBBANNERID'") === false) {
            $db->execute("ALTER TABLE oxarticles ADD OXSEBBANNERID CHAR(32) NULL");
            $db->execute("ALTER TABLE oxcategories ADD OXSEBBANNERID CHAR(32) NULL");
            $db->execute("ALTER TABLE oxcategories ADD OXSEBBANNERHEREDITY TINYINT(1) DEFAULT 0");
            $db->execute("ALTER TABLE oxmanufacturers ADD OXSEBBANNERID CHAR(32) NULL");
            $db->execute("CREATE TABLE oxsebbanner (OXID CHAR(32) COLLATE latin1_general_ci,OXSHOPID INT(11) DEFAULT 1, OXACTIVEFROM DATETIME, OXACTIVETO DATETIME, OXBANNERPIC VARCHAR(128) COLLATE utf8_general_ci, PRIMARY KEY (OXID))");
        }
    }

    /**
     * updates db views
     *
     * @return void
     */
    public static function updateDbViews()
    {
        if (Registry::getSession()->getVariable("malladmin")){
            $meta = oxNew(DbMetaDataHandler::class);
            $meta->updateViews();
        }
    }
}