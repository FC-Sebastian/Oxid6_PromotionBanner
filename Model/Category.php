<?php

namespace fcSeb\banner\Model;

use OxidEsales\Eshop\Core\Registry;

/**
 * extending Category model to add/modify necessary functions
 */
class Category extends Category_Parent
{
    /**
     * returns OXSEBBANNERID of category
     *
     * @return mixed
     */
    public function getSebBannerId()
    {
        return $this->oxcategories__oxsebbannerid->value;
    }

    /**
     * sets OXSEBBANNERID of category
     *
     * @param $sBannerId
     * @return void
     */
    public function setSebBannerId($sBannerId)
    {
        $this->oxcategories__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
    }

    /**
     * returns OXSEBBANNERHEREDITY of category
     *
     * @return mixed
     */
    public function getSebBannerHeredity()
    {
        return $this->oxcategories__oxsebbannerheredity->value;
    }

    /**
     * returns OXPARENTID of category
     *
     * @return mixed
     */
    public function getParentId()
    {
        return $this->oxcategories__oxparentid->value;
    }

    /**
     * deletes banner of category if one exists
     * then calls category delete method
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
            $oBanner->deletePicture("category/banner");
            $oBanner->delete();
        }

        parent::delete($sOXID);
    }

    /**
     * returns activity status of category or parent banner if one exists
     * also checks whether a banner is inherited from a parent
     *
     * @return bool
     */
    public function getPromotionActive($blIsParent = false)
    {
        $oActive = false;
        $oBanner = oxNew(Banner::class);
        $sBannerId = $this->getSebBannerId();

        if ($blIsParent === true && $sBannerId !== null && $sBannerId !== "" && intval($this->getSebBannerHeredity()) === 1 && $oBanner->getActive($sBannerId) === true){
            $oActive = true;
        } elseif ($blIsParent === false && $sBannerId !== null && $sBannerId !== ""  && $oBanner->getActive($sBannerId) === true) {
            $oActive = true;
        } else {
            $oParent = $this;
            if ($oParent->load($this->getParentId()) === true) {
                $oActive = $oParent->getPromotionActive(true);
            }
        }
        return $oActive;
    }

    /**
     * returns banner picture url
     *
     * @return string
     */
    public function getSebBannerUrl()
    {
        $oBanner = oxNew(Banner::class);
        $sBannerId = $this->getSebBannerId();

        if ($sBannerId !== null && $sBannerId !== "" && $oBanner->getActive($sBannerId) === true) {
            $oBanner->load($this->getSebBannerId());
        } else {
            $oBanner->load($this->getParentBannerId());
        }
        $sUrl = $oBanner->getPictureUrl("category/banner");

        if (Registry::getUtilsFile()->urlValidate($sUrl) === false) {
            return false;
        }

        return $sUrl;
    }

    /**
     * returns banner id of category if it passes on its banner
     * or calls getParentBannerId() of parent category
     *
     * @return false|mixed
     */
    public function getParentBannerId()
    {
        $sBannerId = false;
        $oBanner = oxNew(Banner::class);

        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "" && intval($this->getSebBannerHeredity()) === 1 && $oBanner->getActive($this->getSebBannerId()) === true) {
            $sBannerId = $this->getSebBannerId();
        } else {
            $oParent = $this;
            if ($oParent->load($this->getParentId()) === true) {
                $sBannerId = $oParent->getParentBannerId();
            }
        }
        return $sBannerId;
    }
}