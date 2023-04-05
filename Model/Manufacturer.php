<?php

namespace seb\banner\Model;

class Manufacturer extends Manufacturer_Parent
{
    public function getSebBannerId()
    {
        return $this->oxmanufacturer__oxsebbannerid->value;
    }

    public function setSebBannerId($sBannerId)
    {
        $this->oxmanufacturer__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
    }
}