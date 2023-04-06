<?php

namespace seb\banner\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use seb\banner\Controller\Admin\SebBaseController;

class ManufacturerBannerController extends SebBaseController
{
    protected $_oManufacturer;

    protected $_sThisTemplate = "manufacturer_banner.tpl";

    public function render()
    {
        parent::render();

        $this->_aViewData['edit'] = $oManufacturer = $this->getManufacturer();
        $this->_aViewData['editBanner'] = $this->getBanner($oManufacturer);
        return "manufacturer_banner.tpl";
    }

    public function save()
    {
        parent::save();

        $oManufacturer = $this->getManufacturer();
        $oBanner = $this->getBanner($oManufacturer);
        $aParams = Registry::getConfig()->getRequestParameter("editval");
        $oBanner->assign($aParams);

        if ($this->checkFileUpload("MBAN@oxsebbanner__oxbannerpic") === true) {
            $oBanner->deletePicture("manufacturer/banner");
            $oBanner = Registry::getUtilsFile()->processFiles($oBanner);
        }
        $oBanner->save();

        $sBannerId = $oBanner->getId();
        $oManufacturer->setSebBannerId($sBannerId);
        $oManufacturer->setLanguage($this->_iEditLang);
        $oManufacturer->save();
    }

    public function getManufacturer($blReset = false)
    {
        if ($this->_oManufacturer !== null && !$blReset) {
            return $this->_oManufacturer;
        }
        $sProductId = $this->getEditObjectId();

        $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Manufacturer::class);
        $oProduct->load($sProductId);

        return $this->_oManufacturer = $oProduct;
    }
}