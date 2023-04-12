<?php

namespace seb\banner\Controller\Admin;

use seb\banner\Controller\Admin\SebBaseController;
use OxidEsales\Eshop\Core\Registry;

/**
 * controller for article promotion banner tab
 */
class ArticleBannerController extends SebBaseController
{
    protected $_sThisTemplate = "article_banner.tpl";

    protected $_oArticle = null;

    /**
     * calls render method of parent and adds article and banner objects to ViewData array
     *
     * @return string
     */
    public function render()
    {
        parent::render();

        $this->_aViewData["edit"] = $this->getArticle();
        $this->_aViewData["editBanner"] = $this->getBanner($this->getArticle());

        return "article_banner.tpl";
    }

    /**
     * saves banner and article
     *
     * @return void
     * @throws \Exception
     */
    public function save()
    {
        $oConf = Registry::getConfig();

        parent::save();

        $oArticle = $this->getArticle();
        $oBanner = $this->getBanner($oArticle);
        $aParams = $oConf->getRequestParameter("editval");

        $oBanner->assign($aParams);

        if ($this->checkFileUpload("BAN@oxsebbanner__oxbannerpic") === true) {
            $oBanner->deletePicture("product/banner");
            $oBanner = Registry::getUtilsFile()->processFiles($oBanner);
        }
        $oBanner->save();
        $sBannerId = $oBanner->getId();

        $oArticle->setSebBannerId($sBannerId);
        $oArticle->setLanguage($this->_iEditLang);
        $oArticle->save();
    }

    /**
     * stores object of currently edited article in _oArticle and returns it
     *
     * @param $blReset
     * @return mixed|\OxidEsales\Eshop\Application\Model\Article|null
     */
    public function getArticle($blReset = false)
    {
        if ($this->_oArticle !== null && !$blReset) {
            return $this->_oArticle;
        }

        $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $oProduct->load($this->getEditObjectId());

        return $this->_oArticle = $oProduct;
    }
}