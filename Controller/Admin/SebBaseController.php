<?php

namespace fcSeb\banner\Controller\Admin;

use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use fcSeb\banner\Model\Banner;

/**
 * base controller for this model, extends AdminDetailsController
 */
class SebBaseController extends AdminDetailsController
{
    /**
     * loads banner object via getSebBannerId() of given model object and returns it
     *
     * @param $oModel
     * @return mixed|Banner
     */
    public function getBanner($oModel)
    {
        $oBanner = oxNew(Banner::class);
        if ($oModel->getSebBannerId() !== null && $oModel->getSebBannerId() !== ""){
            $oBanner->load($oModel->getSebBannerId());
        }
        return $oBanner;
    }

    /**
     * returns true if a file is uploaded via $sInput input field
     *
     * @param $sInput
     * @return bool
     */
    public function checkFileUpload($sInput)
    {
        return $_FILES["myfile"]["name"][$sInput] !== "";
    }
}