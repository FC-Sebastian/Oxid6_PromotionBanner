<?php

namespace fcSeb\banner\Core;

/**
 * overriding $_aTypeToPath of \OxidEsales\Eshop\Core\UtilsFile to store pictures in custom directories
 */
class UtilsFile extends UtilsFile_Parent
{

    /**
     * Class constructor, initailizes pictures count info (_iMaxPicImgCount/_iMaxZoomImgCount)
     *
     * @return null
     */
    public function __construct()
    {
        parent::__construct();

        $this->_aTypeToPath['CBAN'] = 'master/category/banner';
        $this->_aTypeToPath['MBAN'] = 'master/manufacturer/banner';
        $this->_aTypeToPath['BAN'] = 'master/product/banner';
    }
}