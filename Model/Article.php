<?php

namespace seb\banner\Model;

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
        return true;
    }
}