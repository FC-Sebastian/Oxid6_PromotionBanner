<?php

namespace seb\banner\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use seb\banner\Controller\Admin\SebBaseController;
use stdClass;

class CategoryBannerController extends SebBaseController
{
    protected $_sThisTemplate = "category_banner.tpl";

    protected $_oCategory = null;

    public function render()
    {
        parent::render();

        $oCategory = oxNew(\OxidEsales\Eshop\Application\Model\Category::class);
        $soxId = $this->_aViewData["oxid"] = $this->getEditObjectId();

        if (isset($soxId) && $soxId != "-1") {
            // load object
            $iCatLang = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("catlang");

            if (!isset($iCatLang)) {
                $iCatLang = $this->_iEditLang;
            }

            $this->_aViewData["catlang"] = $iCatLang;

            $oCategory->loadInLang($iCatLang, $soxId);

            //Disable editing for derived items
            if ($oCategory->isDerived()) {
                $this->_aViewData['readonly'] = true;
            }

            foreach (\OxidEsales\Eshop\Core\Registry::getLang()->getLanguageNames() as $id => $language) {
                $oLang = new stdClass();
                $oLang->sLangDesc = $language;
                $oLang->selected = ($id == $this->_iEditLang);
                $this->_aViewData["otherlang"][$id] = clone $oLang;
            }
        }
        $this->_aViewData['edit'] = $oCategory;
        $this->_aViewData['editBanner'] = $this->getBanner($oCategory);
        return "category_banner.tpl";
    }

    public function save()
    {
        parent::save();
        $oConf = Registry::getConfig();
        $oCategory = $this->getCategory();
        $oBanner = $this->getBanner($oCategory);
        $aParams = $oConf->getRequestParameter("editval");
        $oBanner->assign($aParams);

        if ($this->checkFileUpload() === true) {
            $oBanner->deletePicture("category/banner");
            $oBanner = Registry::getUtilsFile()->processFiles($oBanner);
        }
        $oBanner->save();

        $sBannerId = $oBanner->getId();
        $oCategory->setSebBannerId($sBannerId);
        $oCategory->setLanguage($this->_iEditLang);
        $oCategory->save();
    }

    public function getCategory($blReset = false)
    {
        if ($this->_oCategory !== null && !$blReset) {
            return $this->_oCategory;
        }
        $sProductId = $this->getEditObjectId();

        $oCat = oxNew(\OxidEsales\Eshop\Application\Model\Category::class);
        $oCat->load($sProductId);

        return $this->_oCategory = $oCat;
    }
}