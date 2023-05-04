<?php

namespace fcSeb\banner\Model;

use OxidEsales\Eshop\Core\Registry;

/**
 * extending Category model to add/modify necessary functions
 */
class Category extends Category_Parent
{
    protected $_oBanner = false;

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
     * returns this or a parent category's active banner as object
     * returns false if no active banner was found
     *
     * @param $blIsParent
     * @return bool|mixed|null
     */
    public function getActiveBanner($blIsParent = false)
    {
        if ($this->_oBanner !== false) {
            return $this->_oBanner;
        } else {
            $oBanner = oxNew(Banner::class);
            $sBannerId = $this->getSebBannerId();

            if ($blIsParent === true && $sBannerId !== null && $sBannerId !== "" && intval($this->getSebBannerHeredity()) === 1 && $oBanner->getActive($sBannerId) === true) {
                $oBanner->load($sBannerId);
                return $this->_oBanner = $oBanner;
            } elseif ($blIsParent === false && $sBannerId !== null && $sBannerId !== "" && $oBanner->getActive($sBannerId) === true) {
                $oBanner->load($sBannerId);
                return $this->_oBanner = $oBanner;
            }

            $oParent = $this;
            if ($oParent->load($this->getParentId()) === true) {
                return $this->_oBanner = $oParent->getActiveBanner(true);
            }
            return false;
        }
    }

    /**
     * returns banner picture url
     *
     * @return string
     */
    public function getSebBannerUrl()
    {
        $oBanner = $this->getActiveBanner();

        if ($oBanner !== false) {
            $sUrl = $oBanner->getPictureUrl("category/banner");

            if (Registry::getUtilsFile()->urlValidate($sUrl) === false) {
                return false;
            }
            return $sUrl;
        }
        return false;
    }
}