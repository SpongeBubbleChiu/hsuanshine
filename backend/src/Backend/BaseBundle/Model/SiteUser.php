<?php
namespace Backend\BaseBundle\Model;

use Backend\BaseBundle\Model\om\BaseSiteUser;
use Backend\BaseBundle\Security\SecurityEncoderInterface;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Widget\PhotoBundle\File\PhotoUploadFile;

class SiteUser extends BaseSiteUser implements AdvancedUserInterface, SecurityEncoderInterface
{
    use Traits\RoleTrait;

    protected $plainPassword;
    protected $rolesCache = null;

    public function setSiteGroupsCollectionTransform(\PropelCollection $collection)
    {
        $ids = array_column($collection->toArray(), 'Id');
        $this->setSiteGroups(SiteGroupQuery::create()->findPks($ids));
    }

    public function getUsername()
    {
        return $this->getLoginName();
    }

    public function eraseCredentials()
    {
        $this->password = null;
        $this->salt = null;
        $this->plainPassword = null;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function regenerateSalt()
    {
        $this->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36));
    }

    public function setRoles(array $rolesCache)
    {
        $this->rolesCache = $rolesCache;
    }

    public function reload($deep = false, \PropelPDO $con = null)
    {
        $this->rolesCache = null;
        parent::reload($deep, $con);
    }

    public function getRoles()
    {
        if($this->rolesCache === null) {
            $rolesCache = array_merge($this->getDefaultRoles(), $this->getCustomRoles());
            foreach ($this->getSiteGroups() as $sitegroup) {
                $rolesCache = array_merge($rolesCache, $sitegroup->getRoles());
            }
            $this->rolesCache = array_unique($rolesCache);
        }
        return $this->rolesCache;
    }

    public function isSuperAdmin()
    {
        return in_array('ROLE_SUPERADMIN', $this->getRoles());
    }

    public function hasRoleOrSuperAdmin($role)
    {
        return $this->hasRole($role) || $this->isSuperAdmin();
    }

    public function generateToken()
    {
        $this->setConfirmToken(base_convert(md5(uniqid(mt_rand(), true)), 16, 36));
        $this->setTokenExpiredAt(time() + 1800);
    }

    /**
     * Checks whether the user's account has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw an AccountExpiredException and prevent login.
     *
     * @return bool true if the user's account is non expired, false otherwise
     *
     * @see AccountExpiredException
     */
    public function isAccountNonExpired()
    {
        return true;
    }

    /**
     * Checks whether the user is locked.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a LockedException and prevent login.
     *
     * @return bool true if the user is not locked, false otherwise
     *
     * @see LockedException
     */
    public function isAccountNonLocked()
    {
        return true;
    }

    /**
     * Checks whether the user's credentials (password) has expired.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a CredentialsExpiredException and prevent login.
     *
     * @return bool true if the user's credentials are non expired, false otherwise
     *
     * @see CredentialsExpiredException
     */
    public function isCredentialsNonExpired()
    {
       return true;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled()
    {
        return $this->getEnabled();
    }
}
