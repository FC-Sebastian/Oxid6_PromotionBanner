<?php

namespace seb\banner\Controller\Admin;

use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use seb\banner\Model\Banner;

class SebBaseController extends AdminDetailsController
{
    public function getBanner($oModel)
    {
        $oBanner = oxNew(Banner::class);
        if ($oModel->getSebBannerId() !== null && $oModel->getSebBannerId() !== ""){
            $oBanner->load($oModel->getSebBannerId());
        }
        return $oBanner;
    }

    public function checkFileUpload($sInput)
    {
        return $_FILES["myfile"]["name"][$sInput] !== "";
    }
}