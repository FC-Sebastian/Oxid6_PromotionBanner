<?php

namespace seb\banner\Core;

class UtilsPic extends UtilsPic_Parent
{
    public function pictureDelete($sFile, $sPath)
    {
        return $this->_deletePicture($sFile, $sPath);
    }
}