<?php

namespace fcSeb\banner\Controller\Admin;

use fcSeb\banner\Controller\Admin\SebBaseController;
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

        if ($this->isURL($aParams["oxsebbanner__oxbannerlink"]) === true) {

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
        } else {
            $this->_aViewData["bannerUrlValid"] = false;
            $this->_aViewData["bannerUrl"] = $aParams["oxsebbanner__oxbannerlink"];

        }
    }

    /**
     * stores object of currently edited article in _oArticle and returns it
     *
     * @return mixed|\OxidEsales\Eshop\Application\Model\Article|null
     */
    public function getArticle()
    {
        if ($this->_oArticle !== null) {
            return $this->_oArticle;
        }

        $oProduct = oxNew(\OxidEsales\Eshop\Application\Model\Article::class);
        $oProduct->load($this->getEditObjectId());

        return $this->_oArticle = $oProduct;
    }
}