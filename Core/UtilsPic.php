<?php

namespace fc_seb\banner\Core;

/**
 * extending \OxidEsales\Eshop\Core\UtilsPic to add pictureDelete() method to bypass _isPicDeletable of safePictureDelete()
 */
class UtilsPic extends UtilsPic_Parent
{
    /**
     * deletes file via filename and absolute path
     *
     * @param $sFile
     * @param $sPath
     * @return mixed
     */
    public function pictureDelete($sFile, $sPath)
    {
        return $this->_deletePicture($sFile, $sPath);
    }
}