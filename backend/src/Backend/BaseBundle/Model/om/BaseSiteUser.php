<?php

namespace Backend\BaseBundle\Model\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Backend\BaseBundle\Model\OperationLog;
use Backend\BaseBundle\Model\OperationLogQuery;
use Backend\BaseBundle\Model\SiteGroup;
use Backend\BaseBundle\Model\SiteGroupQuery;
use Backend\BaseBundle\Model\SiteUser;
use Backend\BaseBundle\Model\SiteUserGroup;
use Backend\BaseBundle\Model\SiteUserGroupQuery;
use Backend\BaseBundle\Model\SiteUserPeer;
use Backend\BaseBundle\Model\SiteUserQuery;
use Widget\StockBundle\Model\StockLog;
use Widget\StockBundle\Model\StockLogQuery;
use Widget\StockBundle\Model\StockStyleLog;
use Widget\StockBundle\Model\StockStyleLogQuery;

abstract class BaseSiteUser extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'Backend\\BaseBundle\\Model\\SiteUserPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        SiteUserPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinite loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the id field.
     * @var        string
     */
    protected $id;

    /**
     * The value for the login_name field.
     * @var        string
     */
    protected $login_name;

    /**
     * The value for the first_name field.
     * @var        string
     */
    protected $first_name;

    /**
     * The value for the last_name field.
     * @var        string
     */
    protected $last_name;

    /**
     * The value for the email field.
     * @var        string
     */
    protected $email;

    /**
     * The value for the password field.
     * @var        string
     */
    protected $password;

    /**
     * The value for the salt field.
     * @var        string
     */
    protected $salt;

    /**
     * The value for the enabled field.
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $enabled;

    /**
     * The value for the confirm_token field.
     * @var        string
     */
    protected $confirm_token;

    /**
     * The value for the password_expired_at field.
     * @var        string
     */
    protected $password_expired_at;

    /**
     * The value for the token_expired_at field.
     * @var        string
     */
    protected $token_expired_at;

    /**
     * The value for the default_roles field.
     * @var        array
     */
    protected $default_roles;

    /**
     * The unserialized $default_roles value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var        object
     */
    protected $default_roles_unserialized;

    /**
     * The value for the custom_roles field.
     * @var        array
     */
    protected $custom_roles;

    /**
     * The unserialized $custom_roles value - i.e. the persisted object.
     * This is necessary to avoid repeated calls to unserialize() at runtime.
     * @var        object
     */
    protected $custom_roles_unserialized;

    /**
     * The value for the last_login field.
     * @var        string
     */
    protected $last_login;

    /**
     * The value for the created_at field.
     * @var        string
     */
    protected $created_at;

    /**
     * The value for the updated_at field.
     * @var        string
     */
    protected $updated_at;

    /**
     * @var        PropelObjectCollection|OperationLog[] Collection to store aggregation of OperationLog objects.
     */
    protected $collOperationLogs;
    protected $collOperationLogsPartial;

    /**
     * @var        PropelObjectCollection|SiteUserGroup[] Collection to store aggregation of SiteUserGroup objects.
     */
    protected $collSiteUserGroups;
    protected $collSiteUserGroupsPartial;

    /**
     * @var        PropelObjectCollection|StockLog[] Collection to store aggregation of StockLog objects.
     */
    protected $collStockLogs;
    protected $collStockLogsPartial;

    /**
     * @var        PropelObjectCollection|StockStyleLog[] Collection to store aggregation of StockStyleLog objects.
     */
    protected $collStockStyleLogs;
    protected $collStockStyleLogsPartial;

    /**
     * @var        PropelObjectCollection|SiteGroup[] Collection to store aggregation of SiteGroup objects.
     */
    protected $collSiteGroups;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $siteGroupsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $operationLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $siteUserGroupsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $stockLogsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $stockStyleLogsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->enabled = true;
    }

    /**
     * Initializes internal state of BaseSiteUser object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {

        return $this->id;
    }

    /**
     * Get the [login_name] column value.
     *
     * @return string
     */
    public function getLoginName()
    {

        return $this->login_name;
    }

    /**
     * Get the [first_name] column value.
     *
     * @return string
     */
    public function getFirstName()
    {

        return $this->first_name;
    }

    /**
     * Get the [last_name] column value.
     *
     * @return string
     */
    public function getLastName()
    {

        return $this->last_name;
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {

        return $this->email;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {

        return $this->password;
    }

    /**
     * Get the [salt] column value.
     *
     * @return string
     */
    public function getSalt()
    {

        return $this->salt;
    }

    /**
     * Get the [enabled] column value.
     *
     * @return boolean
     */
    public function getEnabled()
    {

        return $this->enabled;
    }

    /**
     * Get the [confirm_token] column value.
     *
     * @return string
     */
    public function getConfirmToken()
    {

        return $this->confirm_token;
    }

    /**
     * Get the [optionally formatted] temporal [password_expired_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getPasswordExpiredAt($format = null)
    {
        if ($this->password_expired_at === null) {
            return null;
        }

        if ($this->password_expired_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->password_expired_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->password_expired_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [token_expired_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTokenExpiredAt($format = null)
    {
        if ($this->token_expired_at === null) {
            return null;
        }

        if ($this->token_expired_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->token_expired_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->token_expired_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [default_roles] column value.
     *
     * @return array
     */
    public function getDefaultRoles()
    {
        if (null === $this->default_roles_unserialized) {
            $this->default_roles_unserialized = array();
        }
        if (!$this->default_roles_unserialized && null !== $this->default_roles) {
            $default_roles_unserialized = substr($this->default_roles, 2, -2);
            $this->default_roles_unserialized = $default_roles_unserialized ? explode(' | ', $default_roles_unserialized) : array();
        }

        return $this->default_roles_unserialized;
    }

    /**
     * Test the presence of a value in the [default_roles] array column value.
     * @param mixed $value
     *
     * @return boolean
     */
    public function hasDefaultRole($value)
    {
        return in_array($value, $this->getDefaultRoles());
    } // hasDefaultRole()

    /**
     * Get the [custom_roles] column value.
     *
     * @return array
     */
    public function getCustomRoles()
    {
        if (null === $this->custom_roles_unserialized) {
            $this->custom_roles_unserialized = array();
        }
        if (!$this->custom_roles_unserialized && null !== $this->custom_roles) {
            $custom_roles_unserialized = substr($this->custom_roles, 2, -2);
            $this->custom_roles_unserialized = $custom_roles_unserialized ? explode(' | ', $custom_roles_unserialized) : array();
        }

        return $this->custom_roles_unserialized;
    }

    /**
     * Test the presence of a value in the [custom_roles] array column value.
     * @param mixed $value
     *
     * @return boolean
     */
    public function hasCustomRole($value)
    {
        return in_array($value, $this->getCustomRoles());
    } // hasCustomRole()

    /**
     * Get the [optionally formatted] temporal [last_login] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getLastLogin($format = null)
    {
        if ($this->last_login === null) {
            return null;
        }

        if ($this->last_login === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->last_login);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->last_login, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [created_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getCreatedAt($format = null)
    {
        if ($this->created_at === null) {
            return null;
        }

        if ($this->created_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->created_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->created_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [updated_at] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null, and 0 if column value is 0000-00-00 00:00:00
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdatedAt($format = null)
    {
        if ($this->updated_at === null) {
            return null;
        }

        if ($this->updated_at === '0000-00-00 00:00:00') {
            // while technically this is not a default value of null,
            // this seems to be closest in meaning.
            return null;
        }

        try {
            $dt = new DateTime($this->updated_at);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->updated_at, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [id] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[] = SiteUserPeer::ID;
        }


        return $this;
    } // setId()

    /**
     * Set the value of [login_name] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setLoginName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->login_name !== $v) {
            $this->login_name = $v;
            $this->modifiedColumns[] = SiteUserPeer::LOGIN_NAME;
        }


        return $this;
    } // setLoginName()

    /**
     * Set the value of [first_name] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setFirstName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->first_name !== $v) {
            $this->first_name = $v;
            $this->modifiedColumns[] = SiteUserPeer::FIRST_NAME;
        }


        return $this;
    } // setFirstName()

    /**
     * Set the value of [last_name] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setLastName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->last_name !== $v) {
            $this->last_name = $v;
            $this->modifiedColumns[] = SiteUserPeer::LAST_NAME;
        }


        return $this;
    } // setLastName()

    /**
     * Set the value of [email] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[] = SiteUserPeer::EMAIL;
        }


        return $this;
    } // setEmail()

    /**
     * Set the value of [password] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[] = SiteUserPeer::PASSWORD;
        }


        return $this;
    } // setPassword()

    /**
     * Set the value of [salt] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setSalt($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->salt !== $v) {
            $this->salt = $v;
            $this->modifiedColumns[] = SiteUserPeer::SALT;
        }


        return $this;
    } // setSalt()

    /**
     * Sets the value of the [enabled] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setEnabled($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->enabled !== $v) {
            $this->enabled = $v;
            $this->modifiedColumns[] = SiteUserPeer::ENABLED;
        }


        return $this;
    } // setEnabled()

    /**
     * Set the value of [confirm_token] column.
     *
     * @param  string $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setConfirmToken($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->confirm_token !== $v) {
            $this->confirm_token = $v;
            $this->modifiedColumns[] = SiteUserPeer::CONFIRM_TOKEN;
        }


        return $this;
    } // setConfirmToken()

    /**
     * Sets the value of [password_expired_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SiteUser The current object (for fluent API support)
     */
    public function setPasswordExpiredAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->password_expired_at !== null || $dt !== null) {
            $currentDateAsString = ($this->password_expired_at !== null && $tmpDt = new DateTime($this->password_expired_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->password_expired_at = $newDateAsString;
                $this->modifiedColumns[] = SiteUserPeer::PASSWORD_EXPIRED_AT;
            }
        } // if either are not null


        return $this;
    } // setPasswordExpiredAt()

    /**
     * Sets the value of [token_expired_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SiteUser The current object (for fluent API support)
     */
    public function setTokenExpiredAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->token_expired_at !== null || $dt !== null) {
            $currentDateAsString = ($this->token_expired_at !== null && $tmpDt = new DateTime($this->token_expired_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->token_expired_at = $newDateAsString;
                $this->modifiedColumns[] = SiteUserPeer::TOKEN_EXPIRED_AT;
            }
        } // if either are not null


        return $this;
    } // setTokenExpiredAt()

    /**
     * Set the value of [default_roles] column.
     *
     * @param  array $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setDefaultRoles($v)
    {
        if ($this->default_roles_unserialized !== $v) {
            $this->default_roles_unserialized = $v;
            $this->default_roles = '| ' . implode(' | ', (array) $v) . ' |';
            $this->modifiedColumns[] = SiteUserPeer::DEFAULT_ROLES;
        }


        return $this;
    } // setDefaultRoles()

    /**
     * Adds a value to the [default_roles] array column value.
     * @param mixed $value
     *
     * @return SiteUser The current object (for fluent API support)
     */
    public function addDefaultRole($value)
    {
        $currentArray = $this->getDefaultRoles();
        $currentArray []= $value;
        $this->setDefaultRoles($currentArray);

        return $this;
    } // addDefaultRole()

    /**
     * Removes a value from the [default_roles] array column value.
     * @param mixed $value
     *
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeDefaultRole($value)
    {
        $targetArray = array();
        foreach ($this->getDefaultRoles() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setDefaultRoles($targetArray);

        return $this;
    } // removeDefaultRole()

    /**
     * Set the value of [custom_roles] column.
     *
     * @param  array $v new value
     * @return SiteUser The current object (for fluent API support)
     */
    public function setCustomRoles($v)
    {
        if ($this->custom_roles_unserialized !== $v) {
            $this->custom_roles_unserialized = $v;
            $this->custom_roles = '| ' . implode(' | ', (array) $v) . ' |';
            $this->modifiedColumns[] = SiteUserPeer::CUSTOM_ROLES;
        }


        return $this;
    } // setCustomRoles()

    /**
     * Adds a value to the [custom_roles] array column value.
     * @param mixed $value
     *
     * @return SiteUser The current object (for fluent API support)
     */
    public function addCustomRole($value)
    {
        $currentArray = $this->getCustomRoles();
        $currentArray []= $value;
        $this->setCustomRoles($currentArray);

        return $this;
    } // addCustomRole()

    /**
     * Removes a value from the [custom_roles] array column value.
     * @param mixed $value
     *
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeCustomRole($value)
    {
        $targetArray = array();
        foreach ($this->getCustomRoles() as $element) {
            if ($element != $value) {
                $targetArray []= $element;
            }
        }
        $this->setCustomRoles($targetArray);

        return $this;
    } // removeCustomRole()

    /**
     * Sets the value of [last_login] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SiteUser The current object (for fluent API support)
     */
    public function setLastLogin($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->last_login !== null || $dt !== null) {
            $currentDateAsString = ($this->last_login !== null && $tmpDt = new DateTime($this->last_login)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->last_login = $newDateAsString;
                $this->modifiedColumns[] = SiteUserPeer::LAST_LOGIN;
            }
        } // if either are not null


        return $this;
    } // setLastLogin()

    /**
     * Sets the value of [created_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SiteUser The current object (for fluent API support)
     */
    public function setCreatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->created_at !== null || $dt !== null) {
            $currentDateAsString = ($this->created_at !== null && $tmpDt = new DateTime($this->created_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->created_at = $newDateAsString;
                $this->modifiedColumns[] = SiteUserPeer::CREATED_AT;
            }
        } // if either are not null


        return $this;
    } // setCreatedAt()

    /**
     * Sets the value of [updated_at] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return SiteUser The current object (for fluent API support)
     */
    public function setUpdatedAt($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->updated_at !== null || $dt !== null) {
            $currentDateAsString = ($this->updated_at !== null && $tmpDt = new DateTime($this->updated_at)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->updated_at = $newDateAsString;
                $this->modifiedColumns[] = SiteUserPeer::UPDATED_AT;
            }
        } // if either are not null


        return $this;
    } // setUpdatedAt()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->enabled !== true) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which resultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->id = ($row[$startcol + 0] !== null) ? (string) $row[$startcol + 0] : null;
            $this->login_name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->first_name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->last_name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->email = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->password = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->salt = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->enabled = ($row[$startcol + 7] !== null) ? (boolean) $row[$startcol + 7] : null;
            $this->confirm_token = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->password_expired_at = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->token_expired_at = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->default_roles = $row[$startcol + 11];
            $this->default_roles_unserialized = null;
            $this->custom_roles = $row[$startcol + 12];
            $this->custom_roles_unserialized = null;
            $this->last_login = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->created_at = ($row[$startcol + 14] !== null) ? (string) $row[$startcol + 14] : null;
            $this->updated_at = ($row[$startcol + 15] !== null) ? (string) $row[$startcol + 15] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);

            return $startcol + 16; // 16 = SiteUserPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating SiteUser object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = SiteUserPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collOperationLogs = null;

            $this->collSiteUserGroups = null;

            $this->collStockLogs = null;

            $this->collStockStyleLogs = null;

            $this->collSiteGroups = null;
        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = SiteUserQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                if (!$this->isColumnModified(SiteUserPeer::CREATED_AT)) {
                    $this->setCreatedAt(time());
                }
                if (!$this->isColumnModified(SiteUserPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
                // addrandompk behavior
                $this->prepareId();
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(SiteUserPeer::UPDATED_AT)) {
                    $this->setUpdatedAt(time());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                SiteUserPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->siteGroupsScheduledForDeletion !== null) {
                if (!$this->siteGroupsScheduledForDeletion->isEmpty()) {
                    $pks = array();
                    $pk = $this->getPrimaryKey();
                    foreach ($this->siteGroupsScheduledForDeletion->getPrimaryKeys(false) as $remotePk) {
                        $pks[] = array($pk, $remotePk);
                    }
                    SiteUserGroupQuery::create()
                        ->filterByPrimaryKeys($pks)
                        ->delete($con);
                    $this->siteGroupsScheduledForDeletion = null;
                }

                foreach ($this->getSiteGroups() as $siteGroup) {
                    if ($siteGroup->isModified()) {
                        $siteGroup->save($con);
                    }
                }
            } elseif ($this->collSiteGroups) {
                foreach ($this->collSiteGroups as $siteGroup) {
                    if ($siteGroup->isModified()) {
                        $siteGroup->save($con);
                    }
                }
            }

            if ($this->operationLogsScheduledForDeletion !== null) {
                if (!$this->operationLogsScheduledForDeletion->isEmpty()) {
                    OperationLogQuery::create()
                        ->filterByPrimaryKeys($this->operationLogsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->operationLogsScheduledForDeletion = null;
                }
            }

            if ($this->collOperationLogs !== null) {
                foreach ($this->collOperationLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->siteUserGroupsScheduledForDeletion !== null) {
                if (!$this->siteUserGroupsScheduledForDeletion->isEmpty()) {
                    SiteUserGroupQuery::create()
                        ->filterByPrimaryKeys($this->siteUserGroupsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->siteUserGroupsScheduledForDeletion = null;
                }
            }

            if ($this->collSiteUserGroups !== null) {
                foreach ($this->collSiteUserGroups as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stockLogsScheduledForDeletion !== null) {
                if (!$this->stockLogsScheduledForDeletion->isEmpty()) {
                    foreach ($this->stockLogsScheduledForDeletion as $stockLog) {
                        // need to save related object because we set the relation to null
                        $stockLog->save($con);
                    }
                    $this->stockLogsScheduledForDeletion = null;
                }
            }

            if ($this->collStockLogs !== null) {
                foreach ($this->collStockLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->stockStyleLogsScheduledForDeletion !== null) {
                if (!$this->stockStyleLogsScheduledForDeletion->isEmpty()) {
                    foreach ($this->stockStyleLogsScheduledForDeletion as $stockStyleLog) {
                        // need to save related object because we set the relation to null
                        $stockStyleLog->save($con);
                    }
                    $this->stockStyleLogsScheduledForDeletion = null;
                }
            }

            if ($this->collStockStyleLogs !== null) {
                foreach ($this->collStockStyleLogs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(SiteUserPeer::ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(SiteUserPeer::LOGIN_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`login_name`';
        }
        if ($this->isColumnModified(SiteUserPeer::FIRST_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`first_name`';
        }
        if ($this->isColumnModified(SiteUserPeer::LAST_NAME)) {
            $modifiedColumns[':p' . $index++]  = '`last_name`';
        }
        if ($this->isColumnModified(SiteUserPeer::EMAIL)) {
            $modifiedColumns[':p' . $index++]  = '`email`';
        }
        if ($this->isColumnModified(SiteUserPeer::PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = '`password`';
        }
        if ($this->isColumnModified(SiteUserPeer::SALT)) {
            $modifiedColumns[':p' . $index++]  = '`salt`';
        }
        if ($this->isColumnModified(SiteUserPeer::ENABLED)) {
            $modifiedColumns[':p' . $index++]  = '`enabled`';
        }
        if ($this->isColumnModified(SiteUserPeer::CONFIRM_TOKEN)) {
            $modifiedColumns[':p' . $index++]  = '`confirm_token`';
        }
        if ($this->isColumnModified(SiteUserPeer::PASSWORD_EXPIRED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`password_expired_at`';
        }
        if ($this->isColumnModified(SiteUserPeer::TOKEN_EXPIRED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`token_expired_at`';
        }
        if ($this->isColumnModified(SiteUserPeer::DEFAULT_ROLES)) {
            $modifiedColumns[':p' . $index++]  = '`default_roles`';
        }
        if ($this->isColumnModified(SiteUserPeer::CUSTOM_ROLES)) {
            $modifiedColumns[':p' . $index++]  = '`custom_roles`';
        }
        if ($this->isColumnModified(SiteUserPeer::LAST_LOGIN)) {
            $modifiedColumns[':p' . $index++]  = '`last_login`';
        }
        if ($this->isColumnModified(SiteUserPeer::CREATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`created_at`';
        }
        if ($this->isColumnModified(SiteUserPeer::UPDATED_AT)) {
            $modifiedColumns[':p' . $index++]  = '`updated_at`';
        }

        $sql = sprintf(
            'INSERT INTO `site_user` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_STR);
                        break;
                    case '`login_name`':
                        $stmt->bindValue($identifier, $this->login_name, PDO::PARAM_STR);
                        break;
                    case '`first_name`':
                        $stmt->bindValue($identifier, $this->first_name, PDO::PARAM_STR);
                        break;
                    case '`last_name`':
                        $stmt->bindValue($identifier, $this->last_name, PDO::PARAM_STR);
                        break;
                    case '`email`':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case '`password`':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case '`salt`':
                        $stmt->bindValue($identifier, $this->salt, PDO::PARAM_STR);
                        break;
                    case '`enabled`':
                        $stmt->bindValue($identifier, (int) $this->enabled, PDO::PARAM_INT);
                        break;
                    case '`confirm_token`':
                        $stmt->bindValue($identifier, $this->confirm_token, PDO::PARAM_STR);
                        break;
                    case '`password_expired_at`':
                        $stmt->bindValue($identifier, $this->password_expired_at, PDO::PARAM_STR);
                        break;
                    case '`token_expired_at`':
                        $stmt->bindValue($identifier, $this->token_expired_at, PDO::PARAM_STR);
                        break;
                    case '`default_roles`':
                        $stmt->bindValue($identifier, $this->default_roles, PDO::PARAM_STR);
                        break;
                    case '`custom_roles`':
                        $stmt->bindValue($identifier, $this->custom_roles, PDO::PARAM_STR);
                        break;
                    case '`last_login`':
                        $stmt->bindValue($identifier, $this->last_login, PDO::PARAM_STR);
                        break;
                    case '`created_at`':
                        $stmt->bindValue($identifier, $this->created_at, PDO::PARAM_STR);
                        break;
                    case '`updated_at`':
                        $stmt->bindValue($identifier, $this->updated_at, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggregated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objects otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            if (($retval = SiteUserPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collOperationLogs !== null) {
                    foreach ($this->collOperationLogs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSiteUserGroups !== null) {
                    foreach ($this->collSiteUserGroups as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStockLogs !== null) {
                    foreach ($this->collStockLogs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStockStyleLogs !== null) {
                    foreach ($this->collStockStyleLogs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SiteUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getLoginName();
                break;
            case 2:
                return $this->getFirstName();
                break;
            case 3:
                return $this->getLastName();
                break;
            case 4:
                return $this->getEmail();
                break;
            case 5:
                return $this->getPassword();
                break;
            case 6:
                return $this->getSalt();
                break;
            case 7:
                return $this->getEnabled();
                break;
            case 8:
                return $this->getConfirmToken();
                break;
            case 9:
                return $this->getPasswordExpiredAt();
                break;
            case 10:
                return $this->getTokenExpiredAt();
                break;
            case 11:
                return $this->getDefaultRoles();
                break;
            case 12:
                return $this->getCustomRoles();
                break;
            case 13:
                return $this->getLastLogin();
                break;
            case 14:
                return $this->getCreatedAt();
                break;
            case 15:
                return $this->getUpdatedAt();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['SiteUser'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['SiteUser'][$this->getPrimaryKey()] = true;
        $keys = SiteUserPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getLoginName(),
            $keys[2] => $this->getFirstName(),
            $keys[3] => $this->getLastName(),
            $keys[4] => $this->getEmail(),
            $keys[5] => $this->getPassword(),
            $keys[6] => $this->getSalt(),
            $keys[7] => $this->getEnabled(),
            $keys[8] => $this->getConfirmToken(),
            $keys[9] => $this->getPasswordExpiredAt(),
            $keys[10] => $this->getTokenExpiredAt(),
            $keys[11] => $this->getDefaultRoles(),
            $keys[12] => $this->getCustomRoles(),
            $keys[13] => $this->getLastLogin(),
            $keys[14] => $this->getCreatedAt(),
            $keys[15] => $this->getUpdatedAt(),
        );
        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collOperationLogs) {
                $result['OperationLogs'] = $this->collOperationLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSiteUserGroups) {
                $result['SiteUserGroups'] = $this->collSiteUserGroups->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStockLogs) {
                $result['StockLogs'] = $this->collStockLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStockStyleLogs) {
                $result['StockStyleLogs'] = $this->collStockStyleLogs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = SiteUserPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setLoginName($value);
                break;
            case 2:
                $this->setFirstName($value);
                break;
            case 3:
                $this->setLastName($value);
                break;
            case 4:
                $this->setEmail($value);
                break;
            case 5:
                $this->setPassword($value);
                break;
            case 6:
                $this->setSalt($value);
                break;
            case 7:
                $this->setEnabled($value);
                break;
            case 8:
                $this->setConfirmToken($value);
                break;
            case 9:
                $this->setPasswordExpiredAt($value);
                break;
            case 10:
                $this->setTokenExpiredAt($value);
                break;
            case 11:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setDefaultRoles($value);
                break;
            case 12:
                if (!is_array($value)) {
                    $v = trim(substr($value, 2, -2));
                    $value = $v ? explode(' | ', $v) : array();
                }
                $this->setCustomRoles($value);
                break;
            case 13:
                $this->setLastLogin($value);
                break;
            case 14:
                $this->setCreatedAt($value);
                break;
            case 15:
                $this->setUpdatedAt($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = SiteUserPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setLoginName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFirstName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setLastName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setEmail($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setPassword($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSalt($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setEnabled($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setConfirmToken($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setPasswordExpiredAt($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setTokenExpiredAt($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setDefaultRoles($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setCustomRoles($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setLastLogin($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setCreatedAt($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setUpdatedAt($arr[$keys[15]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(SiteUserPeer::DATABASE_NAME);

        if ($this->isColumnModified(SiteUserPeer::ID)) $criteria->add(SiteUserPeer::ID, $this->id);
        if ($this->isColumnModified(SiteUserPeer::LOGIN_NAME)) $criteria->add(SiteUserPeer::LOGIN_NAME, $this->login_name);
        if ($this->isColumnModified(SiteUserPeer::FIRST_NAME)) $criteria->add(SiteUserPeer::FIRST_NAME, $this->first_name);
        if ($this->isColumnModified(SiteUserPeer::LAST_NAME)) $criteria->add(SiteUserPeer::LAST_NAME, $this->last_name);
        if ($this->isColumnModified(SiteUserPeer::EMAIL)) $criteria->add(SiteUserPeer::EMAIL, $this->email);
        if ($this->isColumnModified(SiteUserPeer::PASSWORD)) $criteria->add(SiteUserPeer::PASSWORD, $this->password);
        if ($this->isColumnModified(SiteUserPeer::SALT)) $criteria->add(SiteUserPeer::SALT, $this->salt);
        if ($this->isColumnModified(SiteUserPeer::ENABLED)) $criteria->add(SiteUserPeer::ENABLED, $this->enabled);
        if ($this->isColumnModified(SiteUserPeer::CONFIRM_TOKEN)) $criteria->add(SiteUserPeer::CONFIRM_TOKEN, $this->confirm_token);
        if ($this->isColumnModified(SiteUserPeer::PASSWORD_EXPIRED_AT)) $criteria->add(SiteUserPeer::PASSWORD_EXPIRED_AT, $this->password_expired_at);
        if ($this->isColumnModified(SiteUserPeer::TOKEN_EXPIRED_AT)) $criteria->add(SiteUserPeer::TOKEN_EXPIRED_AT, $this->token_expired_at);
        if ($this->isColumnModified(SiteUserPeer::DEFAULT_ROLES)) $criteria->add(SiteUserPeer::DEFAULT_ROLES, $this->default_roles);
        if ($this->isColumnModified(SiteUserPeer::CUSTOM_ROLES)) $criteria->add(SiteUserPeer::CUSTOM_ROLES, $this->custom_roles);
        if ($this->isColumnModified(SiteUserPeer::LAST_LOGIN)) $criteria->add(SiteUserPeer::LAST_LOGIN, $this->last_login);
        if ($this->isColumnModified(SiteUserPeer::CREATED_AT)) $criteria->add(SiteUserPeer::CREATED_AT, $this->created_at);
        if ($this->isColumnModified(SiteUserPeer::UPDATED_AT)) $criteria->add(SiteUserPeer::UPDATED_AT, $this->updated_at);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(SiteUserPeer::DATABASE_NAME);
        $criteria->add(SiteUserPeer::ID, $this->id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param  string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of SiteUser (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setLoginName($this->getLoginName());
        $copyObj->setFirstName($this->getFirstName());
        $copyObj->setLastName($this->getLastName());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setSalt($this->getSalt());
        $copyObj->setEnabled($this->getEnabled());
        $copyObj->setConfirmToken($this->getConfirmToken());
        $copyObj->setPasswordExpiredAt($this->getPasswordExpiredAt());
        $copyObj->setTokenExpiredAt($this->getTokenExpiredAt());
        $copyObj->setDefaultRoles($this->getDefaultRoles());
        $copyObj->setCustomRoles($this->getCustomRoles());
        $copyObj->setLastLogin($this->getLastLogin());
        $copyObj->setCreatedAt($this->getCreatedAt());
        $copyObj->setUpdatedAt($this->getUpdatedAt());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getOperationLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOperationLog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSiteUserGroups() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSiteUserGroup($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStockLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockLog($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStockStyleLogs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStockStyleLog($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return SiteUser Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return SiteUserPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new SiteUserPeer();
        }

        return self::$peer;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('OperationLog' == $relationName) {
            $this->initOperationLogs();
        }
        if ('SiteUserGroup' == $relationName) {
            $this->initSiteUserGroups();
        }
        if ('StockLog' == $relationName) {
            $this->initStockLogs();
        }
        if ('StockStyleLog' == $relationName) {
            $this->initStockStyleLogs();
        }
    }

    /**
     * Clears out the collOperationLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SiteUser The current object (for fluent API support)
     * @see        addOperationLogs()
     */
    public function clearOperationLogs()
    {
        $this->collOperationLogs = null; // important to set this to null since that means it is uninitialized
        $this->collOperationLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collOperationLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialOperationLogs($v = true)
    {
        $this->collOperationLogsPartial = $v;
    }

    /**
     * Initializes the collOperationLogs collection.
     *
     * By default this just sets the collOperationLogs collection to an empty array (like clearcollOperationLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOperationLogs($overrideExisting = true)
    {
        if (null !== $this->collOperationLogs && !$overrideExisting) {
            return;
        }
        $this->collOperationLogs = new PropelObjectCollection();
        $this->collOperationLogs->setModel('OperationLog');
    }

    /**
     * Gets an array of OperationLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SiteUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|OperationLog[] List of OperationLog objects
     * @throws PropelException
     */
    public function getOperationLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collOperationLogsPartial && !$this->isNew();
        if (null === $this->collOperationLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOperationLogs) {
                // return empty collection
                $this->initOperationLogs();
            } else {
                $collOperationLogs = OperationLogQuery::create(null, $criteria)
                    ->filterBySiteUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collOperationLogsPartial && count($collOperationLogs)) {
                      $this->initOperationLogs(false);

                      foreach ($collOperationLogs as $obj) {
                        if (false == $this->collOperationLogs->contains($obj)) {
                          $this->collOperationLogs->append($obj);
                        }
                      }

                      $this->collOperationLogsPartial = true;
                    }

                    $collOperationLogs->getInternalIterator()->rewind();

                    return $collOperationLogs;
                }

                if ($partial && $this->collOperationLogs) {
                    foreach ($this->collOperationLogs as $obj) {
                        if ($obj->isNew()) {
                            $collOperationLogs[] = $obj;
                        }
                    }
                }

                $this->collOperationLogs = $collOperationLogs;
                $this->collOperationLogsPartial = false;
            }
        }

        return $this->collOperationLogs;
    }

    /**
     * Sets a collection of OperationLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $operationLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SiteUser The current object (for fluent API support)
     */
    public function setOperationLogs(PropelCollection $operationLogs, PropelPDO $con = null)
    {
        $operationLogsToDelete = $this->getOperationLogs(new Criteria(), $con)->diff($operationLogs);


        $this->operationLogsScheduledForDeletion = $operationLogsToDelete;

        foreach ($operationLogsToDelete as $operationLogRemoved) {
            $operationLogRemoved->setSiteUser(null);
        }

        $this->collOperationLogs = null;
        foreach ($operationLogs as $operationLog) {
            $this->addOperationLog($operationLog);
        }

        $this->collOperationLogs = $operationLogs;
        $this->collOperationLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OperationLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related OperationLog objects.
     * @throws PropelException
     */
    public function countOperationLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collOperationLogsPartial && !$this->isNew();
        if (null === $this->collOperationLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOperationLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getOperationLogs());
            }
            $query = OperationLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySiteUser($this)
                ->count($con);
        }

        return count($this->collOperationLogs);
    }

    /**
     * Method called to associate a OperationLog object to this object
     * through the OperationLog foreign key attribute.
     *
     * @param    OperationLog $l OperationLog
     * @return SiteUser The current object (for fluent API support)
     */
    public function addOperationLog(OperationLog $l)
    {
        if ($this->collOperationLogs === null) {
            $this->initOperationLogs();
            $this->collOperationLogsPartial = true;
        }

        if (!in_array($l, $this->collOperationLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOperationLog($l);

            if ($this->operationLogsScheduledForDeletion and $this->operationLogsScheduledForDeletion->contains($l)) {
                $this->operationLogsScheduledForDeletion->remove($this->operationLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	OperationLog $operationLog The operationLog object to add.
     */
    protected function doAddOperationLog($operationLog)
    {
        $this->collOperationLogs[]= $operationLog;
        $operationLog->setSiteUser($this);
    }

    /**
     * @param	OperationLog $operationLog The operationLog object to remove.
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeOperationLog($operationLog)
    {
        if ($this->getOperationLogs()->contains($operationLog)) {
            $this->collOperationLogs->remove($this->collOperationLogs->search($operationLog));
            if (null === $this->operationLogsScheduledForDeletion) {
                $this->operationLogsScheduledForDeletion = clone $this->collOperationLogs;
                $this->operationLogsScheduledForDeletion->clear();
            }
            $this->operationLogsScheduledForDeletion[]= clone $operationLog;
            $operationLog->setSiteUser(null);
        }

        return $this;
    }

    /**
     * Clears out the collSiteUserGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SiteUser The current object (for fluent API support)
     * @see        addSiteUserGroups()
     */
    public function clearSiteUserGroups()
    {
        $this->collSiteUserGroups = null; // important to set this to null since that means it is uninitialized
        $this->collSiteUserGroupsPartial = null;

        return $this;
    }

    /**
     * reset is the collSiteUserGroups collection loaded partially
     *
     * @return void
     */
    public function resetPartialSiteUserGroups($v = true)
    {
        $this->collSiteUserGroupsPartial = $v;
    }

    /**
     * Initializes the collSiteUserGroups collection.
     *
     * By default this just sets the collSiteUserGroups collection to an empty array (like clearcollSiteUserGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSiteUserGroups($overrideExisting = true)
    {
        if (null !== $this->collSiteUserGroups && !$overrideExisting) {
            return;
        }
        $this->collSiteUserGroups = new PropelObjectCollection();
        $this->collSiteUserGroups->setModel('SiteUserGroup');
    }

    /**
     * Gets an array of SiteUserGroup objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SiteUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|SiteUserGroup[] List of SiteUserGroup objects
     * @throws PropelException
     */
    public function getSiteUserGroups($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSiteUserGroupsPartial && !$this->isNew();
        if (null === $this->collSiteUserGroups || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSiteUserGroups) {
                // return empty collection
                $this->initSiteUserGroups();
            } else {
                $collSiteUserGroups = SiteUserGroupQuery::create(null, $criteria)
                    ->filterBySiteUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSiteUserGroupsPartial && count($collSiteUserGroups)) {
                      $this->initSiteUserGroups(false);

                      foreach ($collSiteUserGroups as $obj) {
                        if (false == $this->collSiteUserGroups->contains($obj)) {
                          $this->collSiteUserGroups->append($obj);
                        }
                      }

                      $this->collSiteUserGroupsPartial = true;
                    }

                    $collSiteUserGroups->getInternalIterator()->rewind();

                    return $collSiteUserGroups;
                }

                if ($partial && $this->collSiteUserGroups) {
                    foreach ($this->collSiteUserGroups as $obj) {
                        if ($obj->isNew()) {
                            $collSiteUserGroups[] = $obj;
                        }
                    }
                }

                $this->collSiteUserGroups = $collSiteUserGroups;
                $this->collSiteUserGroupsPartial = false;
            }
        }

        return $this->collSiteUserGroups;
    }

    /**
     * Sets a collection of SiteUserGroup objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $siteUserGroups A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SiteUser The current object (for fluent API support)
     */
    public function setSiteUserGroups(PropelCollection $siteUserGroups, PropelPDO $con = null)
    {
        $siteUserGroupsToDelete = $this->getSiteUserGroups(new Criteria(), $con)->diff($siteUserGroups);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->siteUserGroupsScheduledForDeletion = clone $siteUserGroupsToDelete;

        foreach ($siteUserGroupsToDelete as $siteUserGroupRemoved) {
            $siteUserGroupRemoved->setSiteUser(null);
        }

        $this->collSiteUserGroups = null;
        foreach ($siteUserGroups as $siteUserGroup) {
            $this->addSiteUserGroup($siteUserGroup);
        }

        $this->collSiteUserGroups = $siteUserGroups;
        $this->collSiteUserGroupsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related SiteUserGroup objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related SiteUserGroup objects.
     * @throws PropelException
     */
    public function countSiteUserGroups(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSiteUserGroupsPartial && !$this->isNew();
        if (null === $this->collSiteUserGroups || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSiteUserGroups) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getSiteUserGroups());
            }
            $query = SiteUserGroupQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySiteUser($this)
                ->count($con);
        }

        return count($this->collSiteUserGroups);
    }

    /**
     * Method called to associate a SiteUserGroup object to this object
     * through the SiteUserGroup foreign key attribute.
     *
     * @param    SiteUserGroup $l SiteUserGroup
     * @return SiteUser The current object (for fluent API support)
     */
    public function addSiteUserGroup(SiteUserGroup $l)
    {
        if ($this->collSiteUserGroups === null) {
            $this->initSiteUserGroups();
            $this->collSiteUserGroupsPartial = true;
        }

        if (!in_array($l, $this->collSiteUserGroups->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSiteUserGroup($l);

            if ($this->siteUserGroupsScheduledForDeletion and $this->siteUserGroupsScheduledForDeletion->contains($l)) {
                $this->siteUserGroupsScheduledForDeletion->remove($this->siteUserGroupsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	SiteUserGroup $siteUserGroup The siteUserGroup object to add.
     */
    protected function doAddSiteUserGroup($siteUserGroup)
    {
        $this->collSiteUserGroups[]= $siteUserGroup;
        $siteUserGroup->setSiteUser($this);
    }

    /**
     * @param	SiteUserGroup $siteUserGroup The siteUserGroup object to remove.
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeSiteUserGroup($siteUserGroup)
    {
        if ($this->getSiteUserGroups()->contains($siteUserGroup)) {
            $this->collSiteUserGroups->remove($this->collSiteUserGroups->search($siteUserGroup));
            if (null === $this->siteUserGroupsScheduledForDeletion) {
                $this->siteUserGroupsScheduledForDeletion = clone $this->collSiteUserGroups;
                $this->siteUserGroupsScheduledForDeletion->clear();
            }
            $this->siteUserGroupsScheduledForDeletion[]= clone $siteUserGroup;
            $siteUserGroup->setSiteUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SiteUser is new, it will return
     * an empty collection; or if this SiteUser has previously
     * been saved, it will retrieve related SiteUserGroups from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SiteUser.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|SiteUserGroup[] List of SiteUserGroup objects
     */
    public function getSiteUserGroupsJoinSiteGroup($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = SiteUserGroupQuery::create(null, $criteria);
        $query->joinWith('SiteGroup', $join_behavior);

        return $this->getSiteUserGroups($query, $con);
    }

    /**
     * Clears out the collStockLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SiteUser The current object (for fluent API support)
     * @see        addStockLogs()
     */
    public function clearStockLogs()
    {
        $this->collStockLogs = null; // important to set this to null since that means it is uninitialized
        $this->collStockLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collStockLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialStockLogs($v = true)
    {
        $this->collStockLogsPartial = $v;
    }

    /**
     * Initializes the collStockLogs collection.
     *
     * By default this just sets the collStockLogs collection to an empty array (like clearcollStockLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockLogs($overrideExisting = true)
    {
        if (null !== $this->collStockLogs && !$overrideExisting) {
            return;
        }
        $this->collStockLogs = new PropelObjectCollection();
        $this->collStockLogs->setModel('StockLog');
    }

    /**
     * Gets an array of StockLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SiteUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|StockLog[] List of StockLog objects
     * @throws PropelException
     */
    public function getStockLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStockLogsPartial && !$this->isNew();
        if (null === $this->collStockLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStockLogs) {
                // return empty collection
                $this->initStockLogs();
            } else {
                $collStockLogs = StockLogQuery::create(null, $criteria)
                    ->filterBySiteUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStockLogsPartial && count($collStockLogs)) {
                      $this->initStockLogs(false);

                      foreach ($collStockLogs as $obj) {
                        if (false == $this->collStockLogs->contains($obj)) {
                          $this->collStockLogs->append($obj);
                        }
                      }

                      $this->collStockLogsPartial = true;
                    }

                    $collStockLogs->getInternalIterator()->rewind();

                    return $collStockLogs;
                }

                if ($partial && $this->collStockLogs) {
                    foreach ($this->collStockLogs as $obj) {
                        if ($obj->isNew()) {
                            $collStockLogs[] = $obj;
                        }
                    }
                }

                $this->collStockLogs = $collStockLogs;
                $this->collStockLogsPartial = false;
            }
        }

        return $this->collStockLogs;
    }

    /**
     * Sets a collection of StockLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $stockLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SiteUser The current object (for fluent API support)
     */
    public function setStockLogs(PropelCollection $stockLogs, PropelPDO $con = null)
    {
        $stockLogsToDelete = $this->getStockLogs(new Criteria(), $con)->diff($stockLogs);


        $this->stockLogsScheduledForDeletion = $stockLogsToDelete;

        foreach ($stockLogsToDelete as $stockLogRemoved) {
            $stockLogRemoved->setSiteUser(null);
        }

        $this->collStockLogs = null;
        foreach ($stockLogs as $stockLog) {
            $this->addStockLog($stockLog);
        }

        $this->collStockLogs = $stockLogs;
        $this->collStockLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StockLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related StockLog objects.
     * @throws PropelException
     */
    public function countStockLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStockLogsPartial && !$this->isNew();
        if (null === $this->collStockLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockLogs());
            }
            $query = StockLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySiteUser($this)
                ->count($con);
        }

        return count($this->collStockLogs);
    }

    /**
     * Method called to associate a StockLog object to this object
     * through the StockLog foreign key attribute.
     *
     * @param    StockLog $l StockLog
     * @return SiteUser The current object (for fluent API support)
     */
    public function addStockLog(StockLog $l)
    {
        if ($this->collStockLogs === null) {
            $this->initStockLogs();
            $this->collStockLogsPartial = true;
        }

        if (!in_array($l, $this->collStockLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStockLog($l);

            if ($this->stockLogsScheduledForDeletion and $this->stockLogsScheduledForDeletion->contains($l)) {
                $this->stockLogsScheduledForDeletion->remove($this->stockLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	StockLog $stockLog The stockLog object to add.
     */
    protected function doAddStockLog($stockLog)
    {
        $this->collStockLogs[]= $stockLog;
        $stockLog->setSiteUser($this);
    }

    /**
     * @param	StockLog $stockLog The stockLog object to remove.
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeStockLog($stockLog)
    {
        if ($this->getStockLogs()->contains($stockLog)) {
            $this->collStockLogs->remove($this->collStockLogs->search($stockLog));
            if (null === $this->stockLogsScheduledForDeletion) {
                $this->stockLogsScheduledForDeletion = clone $this->collStockLogs;
                $this->stockLogsScheduledForDeletion->clear();
            }
            $this->stockLogsScheduledForDeletion[]= $stockLog;
            $stockLog->setSiteUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SiteUser is new, it will return
     * an empty collection; or if this SiteUser has previously
     * been saved, it will retrieve related StockLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SiteUser.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|StockLog[] List of StockLog objects
     */
    public function getStockLogsJoinStock($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StockLogQuery::create(null, $criteria);
        $query->joinWith('Stock', $join_behavior);

        return $this->getStockLogs($query, $con);
    }

    /**
     * Clears out the collStockStyleLogs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SiteUser The current object (for fluent API support)
     * @see        addStockStyleLogs()
     */
    public function clearStockStyleLogs()
    {
        $this->collStockStyleLogs = null; // important to set this to null since that means it is uninitialized
        $this->collStockStyleLogsPartial = null;

        return $this;
    }

    /**
     * reset is the collStockStyleLogs collection loaded partially
     *
     * @return void
     */
    public function resetPartialStockStyleLogs($v = true)
    {
        $this->collStockStyleLogsPartial = $v;
    }

    /**
     * Initializes the collStockStyleLogs collection.
     *
     * By default this just sets the collStockStyleLogs collection to an empty array (like clearcollStockStyleLogs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStockStyleLogs($overrideExisting = true)
    {
        if (null !== $this->collStockStyleLogs && !$overrideExisting) {
            return;
        }
        $this->collStockStyleLogs = new PropelObjectCollection();
        $this->collStockStyleLogs->setModel('StockStyleLog');
    }

    /**
     * Gets an array of StockStyleLog objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SiteUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|StockStyleLog[] List of StockStyleLog objects
     * @throws PropelException
     */
    public function getStockStyleLogs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStockStyleLogsPartial && !$this->isNew();
        if (null === $this->collStockStyleLogs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStockStyleLogs) {
                // return empty collection
                $this->initStockStyleLogs();
            } else {
                $collStockStyleLogs = StockStyleLogQuery::create(null, $criteria)
                    ->filterBySiteUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStockStyleLogsPartial && count($collStockStyleLogs)) {
                      $this->initStockStyleLogs(false);

                      foreach ($collStockStyleLogs as $obj) {
                        if (false == $this->collStockStyleLogs->contains($obj)) {
                          $this->collStockStyleLogs->append($obj);
                        }
                      }

                      $this->collStockStyleLogsPartial = true;
                    }

                    $collStockStyleLogs->getInternalIterator()->rewind();

                    return $collStockStyleLogs;
                }

                if ($partial && $this->collStockStyleLogs) {
                    foreach ($this->collStockStyleLogs as $obj) {
                        if ($obj->isNew()) {
                            $collStockStyleLogs[] = $obj;
                        }
                    }
                }

                $this->collStockStyleLogs = $collStockStyleLogs;
                $this->collStockStyleLogsPartial = false;
            }
        }

        return $this->collStockStyleLogs;
    }

    /**
     * Sets a collection of StockStyleLog objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $stockStyleLogs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SiteUser The current object (for fluent API support)
     */
    public function setStockStyleLogs(PropelCollection $stockStyleLogs, PropelPDO $con = null)
    {
        $stockStyleLogsToDelete = $this->getStockStyleLogs(new Criteria(), $con)->diff($stockStyleLogs);


        $this->stockStyleLogsScheduledForDeletion = $stockStyleLogsToDelete;

        foreach ($stockStyleLogsToDelete as $stockStyleLogRemoved) {
            $stockStyleLogRemoved->setSiteUser(null);
        }

        $this->collStockStyleLogs = null;
        foreach ($stockStyleLogs as $stockStyleLog) {
            $this->addStockStyleLog($stockStyleLog);
        }

        $this->collStockStyleLogs = $stockStyleLogs;
        $this->collStockStyleLogsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StockStyleLog objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related StockStyleLog objects.
     * @throws PropelException
     */
    public function countStockStyleLogs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStockStyleLogsPartial && !$this->isNew();
        if (null === $this->collStockStyleLogs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStockStyleLogs) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getStockStyleLogs());
            }
            $query = StockStyleLogQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterBySiteUser($this)
                ->count($con);
        }

        return count($this->collStockStyleLogs);
    }

    /**
     * Method called to associate a StockStyleLog object to this object
     * through the StockStyleLog foreign key attribute.
     *
     * @param    StockStyleLog $l StockStyleLog
     * @return SiteUser The current object (for fluent API support)
     */
    public function addStockStyleLog(StockStyleLog $l)
    {
        if ($this->collStockStyleLogs === null) {
            $this->initStockStyleLogs();
            $this->collStockStyleLogsPartial = true;
        }

        if (!in_array($l, $this->collStockStyleLogs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStockStyleLog($l);

            if ($this->stockStyleLogsScheduledForDeletion and $this->stockStyleLogsScheduledForDeletion->contains($l)) {
                $this->stockStyleLogsScheduledForDeletion->remove($this->stockStyleLogsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param	StockStyleLog $stockStyleLog The stockStyleLog object to add.
     */
    protected function doAddStockStyleLog($stockStyleLog)
    {
        $this->collStockStyleLogs[]= $stockStyleLog;
        $stockStyleLog->setSiteUser($this);
    }

    /**
     * @param	StockStyleLog $stockStyleLog The stockStyleLog object to remove.
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeStockStyleLog($stockStyleLog)
    {
        if ($this->getStockStyleLogs()->contains($stockStyleLog)) {
            $this->collStockStyleLogs->remove($this->collStockStyleLogs->search($stockStyleLog));
            if (null === $this->stockStyleLogsScheduledForDeletion) {
                $this->stockStyleLogsScheduledForDeletion = clone $this->collStockStyleLogs;
                $this->stockStyleLogsScheduledForDeletion->clear();
            }
            $this->stockStyleLogsScheduledForDeletion[]= $stockStyleLog;
            $stockStyleLog->setSiteUser(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this SiteUser is new, it will return
     * an empty collection; or if this SiteUser has previously
     * been saved, it will retrieve related StockStyleLogs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in SiteUser.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|StockStyleLog[] List of StockStyleLog objects
     */
    public function getStockStyleLogsJoinStockStyle($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StockStyleLogQuery::create(null, $criteria);
        $query->joinWith('StockStyle', $join_behavior);

        return $this->getStockStyleLogs($query, $con);
    }

    /**
     * Clears out the collSiteGroups collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return SiteUser The current object (for fluent API support)
     * @see        addSiteGroups()
     */
    public function clearSiteGroups()
    {
        $this->collSiteGroups = null; // important to set this to null since that means it is uninitialized
        $this->collSiteGroupsPartial = null;

        return $this;
    }

    /**
     * Initializes the collSiteGroups collection.
     *
     * By default this just sets the collSiteGroups collection to an empty collection (like clearSiteGroups());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @return void
     */
    public function initSiteGroups()
    {
        $this->collSiteGroups = new PropelObjectCollection();
        $this->collSiteGroups->setModel('SiteGroup');
    }

    /**
     * Gets a collection of SiteGroup objects related by a many-to-many relationship
     * to the current object by way of the site_user_group cross-reference table.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this SiteUser is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param PropelPDO $con Optional connection object
     *
     * @return PropelObjectCollection|SiteGroup[] List of SiteGroup objects
     */
    public function getSiteGroups($criteria = null, PropelPDO $con = null)
    {
        if (null === $this->collSiteGroups || null !== $criteria) {
            if ($this->isNew() && null === $this->collSiteGroups) {
                // return empty collection
                $this->initSiteGroups();
            } else {
                $collSiteGroups = SiteGroupQuery::create(null, $criteria)
                    ->filterBySiteUser($this)
                    ->find($con);
                if (null !== $criteria) {
                    return $collSiteGroups;
                }
                $this->collSiteGroups = $collSiteGroups;
            }
        }

        return $this->collSiteGroups;
    }

    /**
     * Sets a collection of SiteGroup objects related by a many-to-many relationship
     * to the current object by way of the site_user_group cross-reference table.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $siteGroups A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return SiteUser The current object (for fluent API support)
     */
    public function setSiteGroups(PropelCollection $siteGroups, PropelPDO $con = null)
    {
        $this->clearSiteGroups();
        $currentSiteGroups = $this->getSiteGroups(null, $con);

        $this->siteGroupsScheduledForDeletion = $currentSiteGroups->diff($siteGroups);

        foreach ($siteGroups as $siteGroup) {
            if (!$currentSiteGroups->contains($siteGroup)) {
                $this->doAddSiteGroup($siteGroup);
            }
        }

        $this->collSiteGroups = $siteGroups;

        return $this;
    }

    /**
     * Gets the number of SiteGroup objects related by a many-to-many relationship
     * to the current object by way of the site_user_group cross-reference table.
     *
     * @param Criteria $criteria Optional query object to filter the query
     * @param boolean $distinct Set to true to force count distinct
     * @param PropelPDO $con Optional connection object
     *
     * @return int the number of related SiteGroup objects
     */
    public function countSiteGroups($criteria = null, $distinct = false, PropelPDO $con = null)
    {
        if (null === $this->collSiteGroups || null !== $criteria) {
            if ($this->isNew() && null === $this->collSiteGroups) {
                return 0;
            } else {
                $query = SiteGroupQuery::create(null, $criteria);
                if ($distinct) {
                    $query->distinct();
                }

                return $query
                    ->filterBySiteUser($this)
                    ->count($con);
            }
        } else {
            return count($this->collSiteGroups);
        }
    }

    /**
     * Associate a SiteGroup object to this object
     * through the site_user_group cross reference table.
     *
     * @param  SiteGroup $siteGroup The SiteUserGroup object to relate
     * @return SiteUser The current object (for fluent API support)
     */
    public function addSiteGroup(SiteGroup $siteGroup)
    {
        if ($this->collSiteGroups === null) {
            $this->initSiteGroups();
        }

        if (!$this->collSiteGroups->contains($siteGroup)) { // only add it if the **same** object is not already associated
            $this->doAddSiteGroup($siteGroup);
            $this->collSiteGroups[] = $siteGroup;

            if ($this->siteGroupsScheduledForDeletion and $this->siteGroupsScheduledForDeletion->contains($siteGroup)) {
                $this->siteGroupsScheduledForDeletion->remove($this->siteGroupsScheduledForDeletion->search($siteGroup));
            }
        }

        return $this;
    }

    /**
     * @param	SiteGroup $siteGroup The siteGroup object to add.
     */
    protected function doAddSiteGroup(SiteGroup $siteGroup)
    {
        // set the back reference to this object directly as using provided method either results
        // in endless loop or in multiple relations
        if (!$siteGroup->getSiteUsers()->contains($this)) { $siteUserGroup = new SiteUserGroup();
            $siteUserGroup->setSiteGroup($siteGroup);
            $this->addSiteUserGroup($siteUserGroup);

            $foreignCollection = $siteGroup->getSiteUsers();
            $foreignCollection[] = $this;
        }
    }

    /**
     * Remove a SiteGroup object to this object
     * through the site_user_group cross reference table.
     *
     * @param SiteGroup $siteGroup The SiteUserGroup object to relate
     * @return SiteUser The current object (for fluent API support)
     */
    public function removeSiteGroup(SiteGroup $siteGroup)
    {
        if ($this->getSiteGroups()->contains($siteGroup)) {
            $this->collSiteGroups->remove($this->collSiteGroups->search($siteGroup));
            if (null === $this->siteGroupsScheduledForDeletion) {
                $this->siteGroupsScheduledForDeletion = clone $this->collSiteGroups;
                $this->siteGroupsScheduledForDeletion->clear();
            }
            $this->siteGroupsScheduledForDeletion[]= $siteGroup;
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->id = null;
        $this->login_name = null;
        $this->first_name = null;
        $this->last_name = null;
        $this->email = null;
        $this->password = null;
        $this->salt = null;
        $this->enabled = null;
        $this->confirm_token = null;
        $this->password_expired_at = null;
        $this->token_expired_at = null;
        $this->default_roles = null;
        $this->default_roles_unserialized = null;
        $this->custom_roles = null;
        $this->custom_roles_unserialized = null;
        $this->last_login = null;
        $this->created_at = null;
        $this->updated_at = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volume/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collOperationLogs) {
                foreach ($this->collOperationLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSiteUserGroups) {
                foreach ($this->collSiteUserGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStockLogs) {
                foreach ($this->collStockLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStockStyleLogs) {
                foreach ($this->collStockStyleLogs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSiteGroups) {
                foreach ($this->collSiteGroups as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collOperationLogs instanceof PropelCollection) {
            $this->collOperationLogs->clearIterator();
        }
        $this->collOperationLogs = null;
        if ($this->collSiteUserGroups instanceof PropelCollection) {
            $this->collSiteUserGroups->clearIterator();
        }
        $this->collSiteUserGroups = null;
        if ($this->collStockLogs instanceof PropelCollection) {
            $this->collStockLogs->clearIterator();
        }
        $this->collStockLogs = null;
        if ($this->collStockStyleLogs instanceof PropelCollection) {
            $this->collStockStyleLogs->clearIterator();
        }
        $this->collStockStyleLogs = null;
        if ($this->collSiteGroups instanceof PropelCollection) {
            $this->collSiteGroups->clearIterator();
        }
        $this->collSiteGroups = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string The value of the 'login_name' column
     */
    public function __toString()
    {
        return (string) $this->getLoginName();
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     SiteUser The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[] = SiteUserPeer::UPDATED_AT;

        return $this;
    }

    // addrandompk behavior

    protected function prepareId()
    {
        if ($this->getId() === null) {
            $id = sprintf('%d%03d', floor(microtime(true) * 10000), rand(0, 999));
            $this->setId($id);
        }
    }

}
