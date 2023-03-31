[{$smarty.block.parent}]

<tr>
    <td class="edittext">
        [{oxmultilang ident="SEB_BANNER_LABEL"}]
    </td>
    <td class="edittext">
        [{oxmultilang ident="SEB_BANNER_FROM"}]
        <input type="text" class="editinput" size="20" maxlength="20" name="editval[oxseb_banner__oxactivefrom]" value="0000-00-00 00:00:00">
        [{oxmultilang ident="SEB_BANNER_TO"}]
        <input type="text" class="editinput" size="20" maxlength="20" name="editval[oxseb_banner__oxactiveto]" value="0000-00-00 00:00:00">
    </td>
</tr>
<tr>
    <td class="edittext">
        [{oxmultilang ident="SEB_BANNER_UPLOAD_LABEL"}]
    </td>
    <td>
        <input class="editinput" name="myfile[PICO@oxseb_banner__oxbannerpic]" type="file">
    </td>
</tr>
