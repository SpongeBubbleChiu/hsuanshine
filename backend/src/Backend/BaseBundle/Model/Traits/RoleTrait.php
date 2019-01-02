<?php
namespace Backend\BaseBundle\Model\Traits;

trait RoleTrait
{
    public function addCustomRole($role)
    {
        if(!$this->hasCustomRole($role)){
            $roles = $this->getCustomRoles();
            $roles[] = $role;
            $this->setCustomRoles($roles);
        }
        return $this;
    }

    public function addDefaultRole($role)
    {
        if(!$this->hasDefaultRole($role)){
            $roles = $this->getDefaultRoles();
            $roles[] = $role;
            $this->setDefaultRoles($roles);
        }
        return $this;
    }

    public function hasRole($role)
    {
        $roles = $this->getRoles();
        return $roles && in_array($role, $roles);
    }

}