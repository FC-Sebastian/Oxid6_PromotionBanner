<?php

namespace seb\banner\Model;

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
    public function getPromotionActive()
    {
        $oBanner = oxNew(Banner::class);
        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "") {
            $oBanner->load($this->getSebBannerId());
            return $oBanner->getActive();
        }
        return false;
    }

    public function getSebBannerUrl()
    {
        $oBanner = oxNew(Banner::class);
        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "") {
            $oBanner->load($this->getSebBannerId());
            return $oBanner->getPictureUrl("product/banner");
        }
    }
}