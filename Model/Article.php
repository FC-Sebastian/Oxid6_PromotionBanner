<?php

namespace fcSeb\banner\Model;

use OxidEsales\Eshop\Application\Model\Manufacturer;

use OxidEsales\Eshop\Core\Registry;

/**
 * extending article model to modify/add necessary functions
 */
class Article extends Article_Parent
{
    protected $_oBanner = false;

    /**
     * returns OXSEBBANNERID of article
     *
     * @return mixed
     */
     public function getSebBannerId()
     {
         return $this->oxarticles__oxsebbannerid->value;
     }

    /**
     * sets OXSEBBANNERID of article
     *
     * @param $sBannerId
     * @return void
     */
    public function setSebBannerId($sBannerId)
    {
        $this->oxarticles__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
    }

    /**
     * returns active banner object of product or manufacturer
     * returns false if none exist
     *
     * @return bool|Banner|mixed
     */
    public function getActiveBanner()
    {
        if ($this->_oBanner !== false) {
            return $this->_oBanner;
        }

        $oBanner = oxNew(Banner::class);
        $sBannerId = $this->getSebBannerId();

        if ($sBannerId !== null && $sBannerId !== "" && $oBanner->getActive($sBannerId) === true) {
            $oBanner->load($sBannerId);
            return $this->_oBanner = $oBanner;
        }

        $oManu = $this->getManufacturer();
        if($oBanner->getActive($oManu->getSebBannerId()) === true) {
            $oBanner->load($sBannerId);
            return $this->_oBanner = $oBanner;
        }

        return false;
    }

    /**
     * if article has banner returns url of banner picture
     * otherwise returns url of manufacturers banner picture
     *
     * @return string
     */
    public function getSebBannerPicUrl()
    {
        $oBanner = oxNew(Banner::class);
        $sBannerId = $this->getSebBannerId();

        if ($sBannerId !== null && $sBannerId !== "" && $oBanner->getActive($sBannerId) === true) {
            $sUrl = $oBanner->getPictureUrl("product/banner");
        } else {
            $oManu = $this->getManufacturer();
            $oBanner->load($oManu->getSebBannerId());
            $sUrl = $oBanner->getPictureUrl("manufacturer/banner");
        }

        if (Registry::getUtilsFile()->urlValidate($sUrl) === false) {
            return false;
        }
        return $sUrl;
    }

    /**
     * deletes banner of article to be deleted if one exists
     * then calls article delete method
     *
     * @param $sOXID
     * @return void
     */
    public function delete($sOXID = false)
    {
        if (!$sOXID) {
            $sOXID = $this->getId();
        }
        $this->load($sOXID);
        $sBannerId = $this->getSebBannerId();

        if ($sBannerId !== null && $sBannerId !== "") {
            $oBanner = oxNew(Banner::class);
            $oBanner->load($sBannerId);
            $oBanner->deletePicture("product/banner");
            $oBanner->delete();
        }

        parent::delete($sOXID);
    }
}