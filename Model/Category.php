<?php

namespace seb\banner\Model;

use OxidEsales\Eshop\Core\Registry;

class Category extends Category_Parent
{
    public function getSebBannerId()
    {
        return $this->oxcategories__oxsebbannerid->value;
    }

    public function setSebBannerId($sBannerId)
    {
        $this->oxcategories__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
    }

    public function getSebBannerHeredity()
    {
        return $this->oxcategories__oxsebbannerheredity->value;
    }

    public function getParentId()
    {
        return $this->oxcategories__oxparentid->value;
    }

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

    public function getParentBannerId()
    {
        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "" && intval($this->getSebBannerHeredity()) === 1) {
            return $this->getSebBannerId();
        } else {
            $oParent = $this;
            if ($oParent->load($this->getParentId()) === true) {
                return $oParent->getParentBannerId();
            }
        }
    }

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
}