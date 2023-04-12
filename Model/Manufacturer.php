<?php

namespace fc_seb\banner\Model;

/**
 * extends Manufacturer model to add/modify the necessary functions
 */
class Manufacturer extends Manufacturer_Parent
{
    /**
     * returns OXSEBBANNERID of manufacturer
     *
     * @return mixed
     */
    public function getSebBannerId()
    {
        return $this->oxmanufacturers__oxsebbannerid->value;
    }

    /**
     * sets OXSEBBANNERID of manufacturer
     *
     * @param $sBannerId
     * @return void
     */
    public function setSebBannerId($sBannerId)
    {
        $this->oxmanufacturers__oxsebbannerid = new \OxidEsales\Eshop\Core\Field($sBannerId);
    }

    /**
     * deletes banner of manufacturer to be deleted
     * then calls manufacturer delete method
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
            $oBanner->deletePicture("manufacturer/banner");
            $oBanner->delete();
        }

        parent::delete($sOXID);
    }
}