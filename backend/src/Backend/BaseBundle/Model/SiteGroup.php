<?php

namespace Backend\BaseBundle\Model;

use Backend\BaseBundle\Model\om\BaseSiteGroup;

class SiteGroup extends BaseSiteGroup
{
    use Traits\RoleTrait;

    public function getRoles()
    {
        return array_merge($this->getDefaultRoles(), $this->getCustomRoles());
    }
}
