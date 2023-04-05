<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace seb\banner\Model;

use OxidEsales\Eshop\Core\Registry;
use oxRegistry;
use oxField;

/**
 * Banner manager
 *
 */
class Banner extends \OxidEsales\Eshop\Core\Model\MultiLanguageModel implements \OxidEsales\Eshop\Core\Contract\IUrl
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
     * Returns raw content seo url
     *
     * @param int $iLang language id
     * @param int $iPage page number [optional]
     *
     * @return string
     */
    public function getBaseSeoLink($iLang, $iPage = 0)
    {
        $oEncoder = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Application\Model\SeoEncoderBanner::class);
        if (!$iPage) {
            return $oEncoder->getBannerUrl($this, $iLang);
        }

        return $oEncoder->getBannerPageUrl($this, $iPage, $iLang);
    }

    /**
     * Returns banner link Url
     *
     * @param int $iLang language id [optional]
     *
     * @return string
     */
    public function getLink($iLang = null)
    {
        if (!\OxidEsales\Eshop\Core\Registry::getUtils()->seoIsActive()) {
            return $this->getStdLink($iLang);
        }

        if ($iLang === null) {
            $iLang = $this->getLanguage();
        }

        if (!isset($this->_aSeoUrls[$iLang])) {
            $this->_aSeoUrls[$iLang] = $this->getBaseSeoLink($iLang);
        }

        return $this->_aSeoUrls[$iLang];
    }

    /**
     * Returns base dynamic url: shopurl/index.php?cl=details
     *
     * @param int  $iLang   language id
     * @param bool $blAddId add current object id to url or not
     * @param bool $blFull  return full including domain name [optional]
     *
     * @return string
     */
    public function getBaseStdLink($iLang, $blAddId = true, $blFull = true)
    {
        $sUrl = '';
        if ($blFull) {
            //always returns shop url, not admin
            $sUrl = $this->getConfig()->getShopUrl($iLang, false);
        }

        return $sUrl . "index.php?cl=bannerlist" . ($blAddId ? "&amp;cnid=v_" . $this->getId() : "");
    }

    /**
     * Returns standard URL to banner
     *
     * @param int   $iLang   language
     * @param array $aParams additional params to use [optional]
     *
     * @return string
     */
    public function getStdLink($iLang = null, $aParams = [])
    {
        if ($iLang === null) {
            $iLang = $this->getLanguage();
        }

        return \OxidEsales\Eshop\Core\Registry::getUtilsUrl()->processUrl($this->getBaseStdLink($iLang), true, $aParams, $iLang);
    }

    /**
     * Returns banner title
     *
     * @return string
     */
    public function getTo()
    {
        return $this->oxsebbanner__oxactiveto->value;
    }

    /**
     * Returns banner title
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->oxsebbanner__oxactivefrom->value;
    }

    public function getOxBannerPic()
    {
        return $this->oxsebbanner__oxbannerpic->value;
    }

    public function getPictureUrl($sPath, $sFile = false)
    {
        $sBase = "pictures/master/";
        $sDir = $sBase.$sPath;
        if ($sFile === false) {
            $sFile = $this->getOxBannerPic();
        }
        return Registry::getConfig()->getUrl($sFile,$sDir);
    }
}
