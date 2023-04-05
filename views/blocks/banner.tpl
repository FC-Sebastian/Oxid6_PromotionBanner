[{assign var="sClass" value=$oView->getClassName()}]

[{if $sClass === "alist"}]
    [{assign var="oCat" value=$oView->getActiveCategory()}]
[{elseif $sClass === "details"}]
    [{assign var="oProduct" value=$oView->getProduct()}]
    [{if $oProduct->getPromotionActive() === true}]
        <img src="[{$oProduct->getSebBannerUrl()}]" class="categoryPicture img-responsive img-thumbnail">
    [{/if}]
[{/if}]

[{$smarty.block.parent}]