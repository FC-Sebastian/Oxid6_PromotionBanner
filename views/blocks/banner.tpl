[{assign var="sClass" value=$oView->getClassName()}]

[{if $sClass === "alist"}]
    [{assign var="oCat" value=$oView->getActiveCategory()}]
    [{if $oCat->getPromotionActive() === true}]
        <img src="[{$oCat->getSebBannerUrl()}]" class="categoryPicture img-responsive img-thumbnail">
    [{/if}]
[{elseif $sClass === "details"}]
    [{assign var="oProduct" value=$oView->getProduct()}]
    [{if $oProduct->getPromotionActive() === true}]
        <img src="[{$oProduct->getSebBannerUrl()}]" class="categoryPicture img-responsive img-thumbnail">
    [{/if}]
[{/if}]

[{$smarty.block.parent}]