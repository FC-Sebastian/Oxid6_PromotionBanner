[{assign var="sClass" value=$oView->getClassName()}]

[{if $sClass === "alist"}]
    [{assign var="oCat" value=$oView->getActiveCategory()}]
[{elseif $sClass === "details"}]
    [{assign var="oProduct" value=$oView->getProduct()}]
    [{if $oProduct->getPromotionActive() === true}]
        <p>placeholder</p>
    [{/if}]
[{/if}]

[{$smarty.block.parent}]