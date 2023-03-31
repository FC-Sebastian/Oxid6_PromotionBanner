<?php

/**
 * Copyright © OXID eSales AG. All rights reserved.
 * See LICENSE file for license details.
 */

namespace seb\banner\Model;

use oxRegistry;
use oxField;

/**
 * Banner list manager.
 * Collects list of banners according to collection rules (activ, etc.).
 *
 */
class BannerList extends \OxidEsales\Eshop\Core\Model\ListModel
{
    /**
     * Banner root.
     *
     * @var \stdClass
     */
    protected $_oRoot = null;

    /**
     * Banner tree path.
     *
     * @var array
     */
    protected $_aPath = [];

    /**
     * To show banner article count or not
     *
     * @var bool
     */
    protected $_blShowBannerArticleCnt = false;

    /**
     * Active banner object
     *
     * @var Banner
     */
    protected $_oClickedBanner = null;

    /**
     * Calls parent constructor and defines if Article banner count is shown
     */
    public function __construct()
    {
        $this->setShowBannerArticleCnt($this->getConfig()->getConfigParam('bl_perfShowActionCatArticleCnt'));
        parent::__construct(Banner::class);
    }

    /**
     * Enables/disables banner article count calculation
     *
     * @param bool $blShowBannerArticleCnt to show article count or not
     */
    public function setShowBannerArticleCnt($blShowBannerArticleCnt = false)
    {
        $this->_blShowBannerArticleCnt = $blShowBannerArticleCnt;
    }

    /**
     * Loads simple banner list
     */
    public function loadBannerList()
    {
        $oBaseObject = $this->getBaseObject();
        $sFieldList = $oBaseObject->getSelectFields();
        $sViewName = $oBaseObject->getViewName();
        $this->getBaseObject()->setShowArticleCnt($this->_blShowBannerArticleCnt);

        $sWhere = '';
        if (!$this->isAdmin()) {
            $sWhere = $oBaseObject->getSqlActiveSnippet();
            $sWhere = $sWhere ? " where $sWhere and " : ' where ';
            $sWhere .= "{$sViewName}.oxtitle != '' ";
        }

        $sSelect = "select {$sFieldList} from {$sViewName} {$sWhere} order by {$sViewName}.oxtitle";
        $this->selectString($sSelect);
    }

    /**
     * Returns banner path array
     *
     * @return array
     */
    public function getPath()
    {
        return $this->_aPath;
    }

    /**
     * Sets active (open) banner object
     *
     * @param Banner $oBanner active banner
     */
    public function setClickBanner($oBanner)
    {
        $this->_oClickedBanner = $oBanner;
    }

    /**
     * returns active (open) banner object
     *
     * @return Banner
     */
    public function getClickBanner()
    {
        return $this->_oClickedBanner;
    }

    /**
     * Processes banner category URLs
     * @deprecated underscore prefix violates PSR12, will be renamed to "seoSetBannerData" in next major
     */
    protected function _seoSetBannerData() // phpcs:ignore PSR2.Methods.MethodDeclaration.Underscore
    {
        // only when SEO id on and in front end
        if (\OxidEsales\Eshop\Core\Registry::getUtils()->seoIsActive() && !$this->isAdmin()) {
            $oEncoder = \OxidEsales\Eshop\Core\Registry::get(\OxidEsales\Eshop\Application\Model\SeoEncoderBanner::class);

            // preparing root banner category
            if ($this->_oRoot) {
                $oEncoder->getBannerUrl($this->_oRoot);
            }

            // encoding banner category
            foreach ($this as $sVndId => $value) {
                $oEncoder->getBannerUrl($this->_aArray[$sVndId]);
            }
        }
    }
}
