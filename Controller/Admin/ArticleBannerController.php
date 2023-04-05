<?php

namespace seb\banner\Controller\Admin;

use OxidEsales\Eshop\Application\Controller\Admin\AdminDetailsController;
use OxidEsales\Eshop\Core\Registry;
use seb\banner\Model\Banner;

class ArticleBannerController extends AdminDetailsController
{
    protected $_sThisTemplate = "article_banner.tpl";

    protected $_oArticle = null;

    public function render()
    {
        parent::render();

        $oArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $soxId = $this->getEditObjectId();

        if (isset($soxId) && $soxId != "-1") {
            // load object
            $oArticle->load($soxId);

            // variant handling
            if ($oArticle->oxarticles__oxparentid->value) {
                $oParentArticle = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
                $oParentArticle->load($oArticle->oxarticles__oxparentid->value);
                $this->_aViewData["parentarticle"] = $oParentArticle;
                $this->_aViewData["oxparentid"] = $oArticle->oxarticles__oxparentid->value;
            }
        }
        $this->_aViewData["editBanner"] = $this->getBanner($oArticle);
        $this->_aViewData["edit"] = $oArticle;

        return "article_banner.tpl";
    }

    public function save()
    {
        $oConf = Registry::getConfig();

        if ($oConf->isDemoShop()) {
            // disabling uploading pictures if this is demo shop
            $oEx = oxNew(\OxidEsales\Eshop\Core\Exception\ExceptionToDisplay::class);
            $oEx->setMessage('ARTICLE_PICTURES_UPLOADISDISABLED');
            \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay($oEx, false);

            return;
        }

        parent::save();

        $oArticle = $this->getArticle();
        $oBanner = $this->getBanner($oArticle);
        $aParams = $oConf->getRequestParameter("editval");

        $oBanner->assign($aParams);
        $oBanner = Registry::getUtilsFile()->processFiles($oBanner);
        $oBanner->save();

        $sBannerId = $oBanner->getId();
        $oArticle->setSebBannerId($sBannerId);
        $oArticle->save();
    }

    public function getArticle($blReset = false)
    {
        if ($this->_oArticle !== null && !$blReset) {
            return $this->_oArticle;
        }
        $sProductId = $this->getEditObjectId();

        $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $oProduct->load($sProductId);

        return $this->_oArticle = $oProduct;
    }

    public function getBanner($oArticle)
    {
        $oBanner = oxNew(Banner::class);
        if ($oArticle->getSebBannerId() !== null && $oArticle->getSebBannerId() !== ""){
            $oBanner->load($oArticle->getSebBannerId());
        }
        return $oBanner;
    }
}