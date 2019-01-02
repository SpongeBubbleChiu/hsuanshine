<?php

namespace Widget\PhotoBundle\Model;

use Widget\PhotoBundle\Model\om\BasePhoto;

class Photo extends BasePhoto
{
    public function __sleep()
    {
        return array_keys($this->toArray(\BasePeer::TYPE_FIELDNAME));
    }

    public function setInfo($v)
    {
        $this->updateSizeFromInfo($v);
        return parent::setInfo($v);
    }
    
    protected function updateSizeFromInfo($info)
    {
        $totalSize = 0;
        foreach ($info as $suffix => $define){
            if($suffix != $define['suffix']){
                continue;
            }
            $totalSize += $define['filesize'];
        }
        $this->setSize($totalSize);
    }
}
