[{assign var="sClass" value=$oView->getClassName()}]

[{if $sClass === "alist"}]
    [{assign var="oCat" value=$oView->getActiveCategory()}]
    [{if $oCat->getPromotionActive() === true && $oCat->getSebBannerUrl() !== false}]
        <img src="[{$oCat->getSebBannerUrl()}]" class="" style="width: 100%">
    [{/if}]
[{elseif $sClass === "details"}]
    [{assign var="oProduct" value=$oView->getProduct()}]
    [{if $oProduct->getPromotionActive() === true && $oProduct->getSebBannerUrl() !== false}]
        <img src="[{$oProduct->getSebBannerUrl()}]" class="" style="width: 100%">
    [{/if}]
[{/if}]

[{$smarty.block.parent}]