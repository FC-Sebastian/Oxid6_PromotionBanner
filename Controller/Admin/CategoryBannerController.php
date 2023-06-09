<?php

namespace fcSeb\banner\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use fcSeb\banner\Controller\Admin\SebBaseController;
use stdClass;

/**
 * controller for category banner tab
 */
class CategoryBannerController extends SebBaseController
{
    protected $_sThisTemplate = "category_banner.tpl";

    protected $_oCategory = null;

    /**
     * calls render method of parent and stores category and banner object in aViewData array
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $this->_aViewData['edit'] = $this->getCategory();
        $this->_aViewData['editBanner'] = $this->getBanner($this->getCategory());

        return "category_banner.tpl";
    }

    /**
     * saves category and banner to db
     *
     * @return void
     * @throws \Exception
     */
    public function save()
    {
        parent::save();
        $oConf = Registry::getConfig();
        $oCategory = $this->getCategory();
        $oBanner = $this->getBanner($oCategory);
        $aParams = $oConf->getRequestParameter("editval");

        if ($this->isURL($aParams["oxsebbanner__oxbannerlink"]) === true) {
            $oCategory->assign($aParams);
            $oBanner->assign($aParams);

            if ($this->checkFileUpload("CBAN@oxsebbanner__oxbannerpic") === true) {
                $oBanner->deletePicture("category/banner");
                $oBanner = Registry::getUtilsFile()->processFiles($oBanner);
            }
            $oBanner->save();
            $sBannerId = $oBanner->getId();

            $oCategory->setSebBannerId($sBannerId);
            $oCategory->setLanguage($this->_iEditLang);
            $oCategory->save();
        } else {
            $this->_aViewData["bannerUrlValid"] = false;
            $this->_aViewData["bannerUrl"] = $aParams["oxsebbanner__oxbannerlink"];

        }
    }

    /**
     * stores object of current category in _oCategory and returns it
     *
     * @return mixed|\OxidEsales\Eshop\Application\Model\Category|null
     */
    public function getCategory()
    {
        if ($this->_oCategory !== null) {
            return $this->_oCategory;
        }

        $oCat = oxNew(\OxidEsales\Eshop\Application\Model\Category::class);
        $oCat->load($this->getEditObjectId());

        return $this->_oCategory = $oCat;
    }
}