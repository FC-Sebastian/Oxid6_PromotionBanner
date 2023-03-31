<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace seb\banner\Model;

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
    protected $_sClassName = 'oxseb_banner';

    /**
     * Marker to load banner article count info
     *
     * @var bool
     */
    protected $_blShowArticleCnt = false;

    /**
     * Banner article count (default is -1, which means not calculated)
     *
     * @var int
     */
    protected $_iNrOfArticles = -1;

    /**
     * Marks that current object is managed by SEO
     *
     * @var bool
     */
    protected $_blIsSeoObject = true;

    /**
     * Visibility of a banner
     *
     * @var int
     */
    protected $_blIsVisible;

    /**
     * has visible endors state of a category
     *
     * @var int
     */
    protected $_blHasVisibleSubCats;

    /**
     * Seo article urls for languages
     *
     * @var array
     */
    protected $_aSeoUrls = [];

    /**
     * Class constructor, initiates parent constructor (parent::oxI18n()).
     */
    public function __construct()
    {
        $this->setShowArticleCnt($this->getConfig()->getConfigParam('bl_perfShowActionCatArticleCnt'));
        parent::__construct();
        $this->init('oxseb_banner');
    }

    /**
     * Marker to load banner article count info setter
     *
     * @param bool $blShowArticleCount Marker to load banner article count
     */
    public function setShowArticleCnt($blShowArticleCount = false)
    {
        $this->_blShowArticleCnt = $blShowArticleCount;
    }

    /**
     * Assigns to $this object some base parameters/values.
     *
     * @param array $dbRecord parameters/values
     */
    public function assign($dbRecord)
    {
        parent::assign($dbRecord);

        // banner article count is stored in cache
        if ($this->_blShowArticleCnt && !$this->isAdmin()) {
            $this->_iNrOfArticles = \OxidEsales\Eshop\Core\Registry::getUtilsCount()->getBannerArticleCount($this->getId());
        }

        $this->oxseb_banner__oxnrofarticles = new \OxidEsales\Eshop\Core\Field($this->_iNrOfArticles, \OxidEsales\Eshop\Core\Field::T_RAW);
    }

    /**
     * Loads object data from DB (object data ID is passed to method). Returns
     * true on success.
     *
     * @param string $sOxid object id
     *
     * @return bool
     */
    public function load($sOxid)
    {
        if ($sOxid == 'root') {
            return $this->_setRootObjectData();
        }

        return parent::load($sOxid);
    }

    /**
     * Sets root banner data. Returns true
     *
     * @return bool
     * @deprecated underscore prefix violates PSR12, will be renamed to "setRootObjectData" in next major
     */
    protected function _setRootObjectData() // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        $this->setId('root');
        $this->oxseb_banner__oxicon = new \OxidEsales\Eshop\Core\Field('', \OxidEsales\Eshop\Core\Field::T_RAW);
        $this->oxseb_banner__oxtitle = new \OxidEsales\Eshop\Core\Field(\OxidEsales\Eshop\Core\Registry::getLang()->translateString('BY_VENDOR', $this->getLanguage(), false), \OxidEsales\Eshop\Core\Field::T_RAW);
        $this->oxseb_banner__oxshortdesc = new \OxidEsales\Eshop\Core\Field('', \OxidEsales\Eshop\Core\Field::T_RAW);

        return true;
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
     * returns number or articles of this banner
     *
     * @return integer
     */
    public function getNrOfArticles()
    {
        if (!$this->_blShowArticleCnt || $this->isAdmin()) {
            return -1;
        }

        return $this->_iNrOfArticles;
    }

    /**
     * returns the sub category array
     */
    public function getSubCats()
    {
    }

    /**
     * returns the visibility of a banner
     *
     * @return bool
     */
    public function getIsVisible()
    {
        return $this->_blIsVisible;
    }

    /**
     * sets the visibilty of a category
     *
     * @param bool $blVisible banners visibility status setter
     */
    public function setIsVisible($blVisible)
    {
        $this->_blIsVisible = $blVisible;
    }

    /**
     * returns if a banner has visible sub categories
     *
     * @return bool
     */
    public function getHasVisibleSubCats()
    {
        if (!isset($this->_blHasVisibleSubCats)) {
            $this->_blHasVisibleSubCats = false;
        }

        return $this->_blHasVisibleSubCats;
    }

    /**
     * sets the state of has visible sub banners
     *
     * @param bool $blHasVisibleSubcats marker if banner has visible subcategories
     */
    public function setHasVisibleSubCats($blHasVisibleSubcats)
    {
        $this->_blHasVisibleSubCats = $blHasVisibleSubcats;
    }

    /**
     * Empty method, called in templates when banner is used in same code like category
     */
    public function getContentCats()
    {
    }

    /**
     * Delete this object from the database, returns true on success.
     *
     * @param string $oxid Object ID(default null)
     *
     * @return bool
     */
    public function delete($oxid = null)
    {
        if ($oxid) {
            $this->load($oxid);
        } else {
            $oxid = $this->getId();
        }

        if (parent::delete($oxid)) {
            \OxidEsales\Eshop\Core\Registry::get(\seb\banner\Model\SeoEncoderBanner::class)->onDeleteBanner($this);

            return true;
        }

        return false;
    }

    /**
     * Returns banner title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->oxseb_banner__oxtitle->value;
    }

    /**
     * Returns banner title
     *
     * @return string
     */
    public function getTo()
    {
        return $this->oxseb_banner__oxactiveto->value;
    }

    /**
     * Returns banner title
     *
     * @return string
     */
    public function getFrom()
    {
        return $this->oxseb_banner__oxactivefrom->value;
    }
}
