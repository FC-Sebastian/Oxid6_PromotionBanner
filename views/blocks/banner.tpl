[{assign var="sClass" value=$oView->getClassName()}]

[{if $sClass === "alist"}]
    [{assign var="oCat" value=$oView->getActiveCategory()}]
    [{assign var="sOxid" value=$oCat->oxcategories__oxid->value}]

[{elseif $sClass === "details"}]
    [{assign var="oProduct" value=$oView->getProduct()}]
    [{assign var="sOxid" value=$oProduct->oxarticles__oxid->value}]

[{/if}]

[{$smarty.block.parent}]