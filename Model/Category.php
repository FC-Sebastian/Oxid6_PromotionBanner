<?php

namespace seb\banner\Model;

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
     *
     * @return bool
     */
    public function getPromotionActive()
    {
        $oActive = false;
        $oBanner = oxNew(Banner::class);

        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "") {
            $oBanner->load($this->getSebBannerId());
            $oActive = $oBanner->getActive();
        } else {
            $oParent = $this;
            if ($oParent->load($this->getParentId()) === true) {
                $oActive = $oParent->getParentPromotionActive();
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
        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "") {
            $oBanner->load($this->getSebBannerId());
        } else {
            $oBanner->load($this->getParentBannerId());
        }
        return $oBanner->getPictureUrl("category/banner");
    }

    /**
     * returns banner active status of category if it passes on its banner
     * or calls getParentPromotionActive() of parent category
     *
     * @return bool
     */
    public function getParentPromotionActive()
    {
        $oActive = false;
        $oBanner = oxNew(Banner::class);

        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "" && intval($this->getSebBannerHeredity()) === 1) {
            $oBanner->load($this->getSebBannerId());
            $oActive = $oBanner->getActive();
        } else {
            $oParent = $this;
            if ($oParent->load($this->getParentId()) === true) {
                $oActive = $oParent->getParentPromotionActive();
            }
        }
        return $oActive;
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

        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "" && intval($this->getSebBannerHeredity()) === 1) {
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