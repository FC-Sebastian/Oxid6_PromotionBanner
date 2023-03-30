<?php

namespace seb\banner\Core\Events;

use OxidEsales\Eshop\Core\Base;

class Setup extends Base
{

    public static function onActivate()
    {
        self::alterDbTables();
        self::updateDbViews();
    }

    public static function alterDbTables()
    {

    }

    public static function updateDbViews()
    {

    }
}