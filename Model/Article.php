<?php

namespace fc_seb\banner\Model;

use OxidEsales\Eshop\Application\Model\Manufacturer;

use OxidEsales\Eshop\Core\Registry;

use function OxidEsales\EshopCommunity\Tests\Unit\Application\Controller\getSeoProcType;

/**
 * extending article model to modify/add necessary functions
 */
class Article extends Article_Parent
{
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
     * verifies if banner is active
     * loads banner object of article or article manufacturer
     * then returns getActive method of banner object
     *
     * @return bool
     */
    public function getPromotionActive()
    {
        $oBanner = oxNew(Banner::class);
        $sBannerId = $this->getSebBannerId();
        $oActive = false;

        if ($sBannerId !== null && $sBannerId !== "" && $oBanner->getActive($sBannerId) === true) {
            $oActive = true;
        } else {
            $oManu = $this->getManufacturer();
            $oActive = $oBanner->getActive($oManu->getSebBannerId());
        }
        return $oActive;
    }

    /**
     * if article has banner returns its url
     * otherwise returns url of manufacturers banner
     *
     * @return string
     */
    public function getSebBannerUrl()
    {
        $oBanner = oxNew(Banner::class);
        $sBannerId = $this->getSebBannerId();
        $sUrl = false;

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