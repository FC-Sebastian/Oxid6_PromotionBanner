<?php

namespace seb\banner\Model;

class Manufacturer extends Manufacturer_Parent
{
    public function getSebBannerId()
    {
        return $this->oxmanufacturers__oxsebbannerid->value;
    }

    public function setSebBannerId($sBannerId)
    {
        $this->oxmanufacturers__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
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
            $oBanner->deletePicture("manufacturer/banner");
            $oBanner->delete();
        }

        parent::delete($sOXID);
    }
}