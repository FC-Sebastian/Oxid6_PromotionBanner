<?php

namespace fcSeb\banner\Controller\Admin;

use OxidEsales\Eshop\Core\Registry;
use fcSeb\banner\Controller\Admin\SebBaseController;

/**
 * controller for manufacturer banner tab
 */
class ManufacturerBannerController extends SebBaseController
{
    protected $_oManufacturer;

    protected $_sThisTemplate = "manufacturer_banner.tpl";

    /**
     * calls parent render method then stores manufacturer and banner objects in aViewData object
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $this->_aViewData['edit'] = $oManufacturer = $this->getManufacturer();
        $this->_aViewData['editBanner'] = $this->getBanner($oManufacturer);

        return "manufacturer_banner.tpl";
    }

    /**
     * saves manufacturer and banner objects
     *
     * @return void
     * @throws \Exception
     */
    public function save()
    {
        parent::save();

        $oManufacturer = $this->getManufacturer();
        $oBanner = $this->getBanner($oManufacturer);
        $aParams = Registry::getConfig()->getRequestParameter("editval");

        if ($this->isURL($aParams["oxsebbanner__oxbannerlink"]) === true) {
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
        } else {
            $this->_aViewData["bannerUrlValid"] = false;
            $this->_aViewData["bannerUrl"] = $aParams["oxsebbanner__oxbannerlink"];

        }
    }

    /**
     * stores manufacturer object in _oManufacturer and returns it
     *
     * @return mixed|\OxidEsales\Eshop\Application\Model\Manufacturer
     */
    public function getManufacturer()
    {
        if ($this->_oManufacturer !== null) {
            return $this->_oManufacturer;
        }

        $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Manufacturer::class);
        $oProduct->load($this->getEditObjectId());

        return $this->_oManufacturer = $oProduct;
    }
}