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
}