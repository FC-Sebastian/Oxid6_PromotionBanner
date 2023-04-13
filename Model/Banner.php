<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace fcSeb\banner\Model;

use OxidEsales\Eshop\Core\Registry;
use oxRegistry;
use oxField;

/**
 * Banner manager
 * gets and sets banner data and handles saving/deleting of banners
 */
class Banner extends \OxidEsales\Eshop\Core\Model\MultiLanguageModel
{
    protected static $_aRootBanner = [];

    /**
     * @var string Name of current class
     */
    protected $_sClassName = 'oxsebbanner';

    /**
     * Class constructor, initiates parent constructor (parent::oxI18n()).
     */
    public function __construct()
    {
        parent::__construct();
        $this->init('oxsebbanner');
    }

    /**
     * Returns value of banner OXACTIVETO db field
     *
     * @return string
     */
    public function getTo()
    {
        return $this->oxsebbanner__oxactiveto->value;
    }

    /**
     * Returns value of banner OXACTIVEFROM db field
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->oxsebbanner__oxactivefrom->value;
    }

    /**
     * Returns value of banner OXBANNERPIC db field
     *
     * @return mixed
     */
    public function getOxBannerPic()
    {
        return $this->oxsebbanner__oxbannerpic->value;
    }

    /**
     * returns url of picture via path and file
     * if file is not given loads banner picture name from db
     *
     * @param $sPath
     * @param $sFile
     * @return string
     */
    public function getPictureUrl($sPath, $sFile = false)
    {
        $sBase = "pictures/master/";
        $sDir = $sBase.$sPath;
        if ($sFile === false) {
            $sFile = $this->getOxBannerPic();
        }
        return Registry::getConfig()->getUrl($sFile,$sDir);
    }

    /**
     * returns absolute path of picture directory specified via path
     *
     * @param $sPath
     * @return bool|string
     */
    public function getPictureDir($sPath)
    {
        $sBase = "pictures/master/";
        $sDir = $sBase.$sPath;

        return Registry::getConfig()->getDir(null, $sDir, true);
    }

    /**
     * if sBannerId is given loads banner with it
     * returns true if current time is within timeframe specified by banner OXACTIVEFROM and OXACTIVETO
     *
     * @return bool
     */
    public function getActive($sBannerId = false)
    {
        if ($sBannerId !== false) {
            $this->load($sBannerId);
        }

        $sFrom = $this->getFrom();
        $sTo = $this->getTo();

        return strtotime($sFrom) <= time() && time() <= strtotime($sTo);
    }

    /**
     * deletes picture by getting absolute path via absolute path from getPictureDir
     * and filename via getOxBannerPic
     *
     * @param $sPath
     * @return void
     */
    public function deletePicture($sPath)
    {
        $sDir = $this->getPictureDir($sPath);
        Registry::getUtilsPic()->pictureDelete($this->getOxBannerPic(), $sDir);
    }
}
