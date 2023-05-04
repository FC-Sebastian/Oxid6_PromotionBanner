[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]

[{if $readonly}]
    [{assign var="readonly" value="readonly disabled"}]
[{else}]
    [{assign var="readonly" value=""}]
[{/if}]

<form name="transfer" id="transfer" action="[{$oViewConf->getSelfLink()}]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="cl" value="category_pictures">
    <input type="hidden" name="editlanguage" value="[{$editlanguage}]">
</form>

<form name="myedit" id="myedit" enctype="multipart/form-data" action="[{$oViewConf->getSelfLink()}]" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="[{$iMaxUploadFileSize}]">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="category_banner">
    <input type="hidden" name="fnc" value="">
    <input type="hidden" name="oxid" value="[{$oxid}]">
    <input type="hidden" name="editval[oxcategories__oxid]" value="[{$oxid}]">

    [{if $bannerUrlValid === false}]
    <div class="warning">"[{$bannerUrl}]", [{oxmultilang ident="SEB_BANNER_URL_INVALID"}]</div>
    [{/if}]

    <table cellspacing="0" cellpadding="0" width="100%" border="0" class="listTable">
        <tr>
            <th colspan="4" valign="top">
                [{oxmultilang ident="SEB_BANNER_HEADER"}]
            </th>
        </tr>

        <tr>
            <td class="edittext">
                [{oxmultilang ident="SEB_BANNER_UPLOAD_LABEL"}]
                [{oxinputhelp ident="SEB_BANNER_UPLOAD_HELP"}]
            </td>

            <td class="text">
                [{assign var="sPicFile" value=$editBanner->getOxBannerPic()}]
                [{assign var="blPicUplodaded" value=true}]

                [{if $sPicFile == "nopic.jpg" || $sPicFile == ""}]
                    [{assign var="blPicUplodaded" value=false}]
                    <span class="notActive">-------</span>
                [{else}]
                    <b>[{$sPicFile}]</b>
                [{/if}]
            </td>

            <td class="edittext">
                <input class="editinput" name="myfile[CBAN@oxsebbanner__oxbannerpic]" type="file">
            </td>

            <td nowrap="nowrap">
                [{if $blPicUplodaded && !$readonly}]
                [{assign var="sPicUrl" value=$editBanner->getPictureUrl('product/banner')}]
                <a href="[{$sPicUrl}]" class="zoomText" target="_blank"><span class="ico"></span><span class="float: left;>">[{oxmultilang ident="ARTICLE_PICTURES_PREVIEW"}]</span></a>
                [{/if}]
            </td>
        </tr>
        <tr>
            <td class="edittext">
                [{oxmultilang ident="SEB_BANNER_LINK"}]
                [{oxinputhelp ident="SEB_BANNER_LINK_HELP"}]
            </td>
            <td></td>
            <td class="edittext">
                <input class="editinput" name="editval[oxsebbanner__oxbannerlink]" type="text" value="[{$editBanner->oxsebbanner__oxbannerlink->value}]" style="width: 50%">
            </td>
            <td class="edittext">
                [{oxmultilang ident="SEB_BANNER_NEW_TAB"}]
                <input type="checkbox" class="editinput" name="editval[oxsebbanner__oxnewtab]" value="1" [{if $editBanner->getNewTab() === true}]checked[{/if}]>
            </td>
        </tr>
        <tr>
            <td class="edittext">
                [{oxmultilang ident="SEB_BANNER_TIME_LABEL"}]
                [{oxinputhelp ident="SEB_BANNER_TIME_HELP"}]
            </td>
            <td></td>
            <td class="edittext">
                [{oxmultilang ident="SEB_BANNER_FROM"}]
                <input type="text" class="editinput" size="20" maxlength="20" name="editval[oxsebbanner__oxactivefrom]" value="[{$editBanner->getFrom()|oxformdate}]">
            </td>
            <td class="edittext">
                [{oxmultilang ident="SEB_BANNER_TO"}]
                <input type="text" class="editinput" size="20" maxlength="20" name="editval[oxsebbanner__oxactiveto]" value="[{$editBanner->getTo()|oxformdate}]">
            </td>
        </tr>
        <tr>
            <td colspan="2" class="edittext">
                [{oxmultilang ident="SEB_BANNER_HEREDITY"}]
                [{oxinputhelp ident="SEB_BANNER_CATEGORY_HELP"}]
            </td>
            <td colspan="2" class="edittext">
                <input type="hidden" name="editval[oxcategories__oxsebbannerheredity]" value="0">
                <input type="checkbox" class="edittext" name="editval[oxcategories__oxsebbannerheredity]" value="1" [{if $edit->getSebBannerHeredity() == 1}]checked[{/if}]>
            </td>
        </tr>
    </table>
    <input type="submit" class="editinput" name="save" value="[{ oxmultilang ident="SEB_BANNER_SAVE" }]" onClick="Javascript:document.myedit.fnc.value='save'" [{$readonly}]><br>
</form>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]