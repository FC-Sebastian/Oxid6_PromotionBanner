<?php

namespace seb\banner\Model;

use OxidEsales\Eshop\Application\Model\Manufacturer;

use function OxidEsales\EshopCommunity\Tests\Unit\Application\Controller\getSeoProcType;

class Article extends Article_Parent
{
     public function getSebBannerId()
     {
         return $this->oxarticles__oxsebbannerid->value;
     }

    public function setSebBannerId($sBannerId)
    {
        $this->oxarticles__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
    }

    public function getPromotionActive()
    {
        $oBanner = oxNew(Banner::class);
        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "") {
            $oBanner->load($this->getSebBannerId());
        } else {
            $oManu = $this->getManufacturer();
            $oBanner->load($oManu->getSebBannerId());
        }
        return $oBanner->getActive();
    }

    public function getSebBannerUrl()
    {
        $oBanner = oxNew(Banner::class);
        if ($this->getSebBannerId() !== null && $this->getSebBannerId() !== "") {
            $oBanner->load($this->getSebBannerId());
            return $oBanner->getPictureUrl("product/banner");
        } else {
            $oManu = $this->getManufacturer();
            $oBanner->load($oManu->getSebBannerId());
            return $oBanner->getPictureUrl("manufacturer/banner");
        }
    }
}