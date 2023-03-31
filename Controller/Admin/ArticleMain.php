<?php

namespace seb\banner\Controller\Admin;

class ArticleMain extends ArticleMain_parent
{
    public function getSebBanners()
    {
        $oBannerList = oxNew(\seb\banner\Model\BannerList::class);
        $oBannerList->loadBannerList();

        return $oBannerList;
    }

    public function save()
    {
        parent::save();
    }
}