[{oxstyle include=$oViewConf->getModuleUrl("fcSeb_banner", "out/src/css/sebBanner.css")}]
[{assign var="sClass" value=$oView->getClassName()}]

[{if $sClass === "alist"}]
    [{assign var="oCat" value=$oView->getActiveCategory()}]
    [{assign var="oBanner" value=$oCat->getActiveBanner()}]

    [{if $oBanner !== false && $oCat->getSebBannerUrl() !== false}]
        <a href="[{$oBanner->oxsebbanner__oxbannerlink->value}]" [{if $oBanner->getNewTab() === true}]target="_blank"[{/if}]><img src="[{$oCat->getSebBannerUrl()}]" class="sebBannerPic"></a>
    [{/if}]
[{elseif $sClass === "details"}]
    [{assign var="oProduct" value=$oView->getProduct()}]
    [{assign var="oBanner" value=$oProduct->getActiveBanner()}]

    [{if $oBanner !== false && $oProduct->getSebBannerPicUrl() !== false}]
        <a href="[{$oBanner->oxsebbanner__oxbannerlink->value}]" [{if $oBanner->getNewTab() === true}]target="_blank"[{/if}]><img src="[{$oProduct->getSebBannerPicUrl()}]" class="sebBannerPic"></a>
    [{/if}]
[{/if}]

[{$smarty.block.parent}]