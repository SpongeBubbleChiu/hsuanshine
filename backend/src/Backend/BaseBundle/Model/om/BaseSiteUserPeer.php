<?php

namespace Backend\BaseBundle\Model\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use Backend\BaseBundle\Model\SiteUser;
use Backend\BaseBundle\Model\SiteUserPeer;
use Backend\BaseBundle\Model\map\SiteUserTableMap;

abstract class BaseSiteUserPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'default';

    /** the table name for this class */
    const TABLE_NAME = 'site_user';

    /** the related Propel class for this table */
    const OM_CLASS = 'Backend\\BaseBundle\\Model\\SiteUser';

    /** the related TableMap class for this table */
    const TM_CLASS = 'Backend\\BaseBundle\\Model\\map\\SiteUserTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 16;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 16;

    /** the column name for the id field */
    const ID = 'site_user.id';

    /** the column name for the login_name field */
    const LOGIN_NAME = 'site_user.login_name';

    /** the column name for the first_name field */
    const FIRST_NAME = 'site_user.first_name';

    /** the column name for the last_name field */
    const LAST_NAME = 'site_user.last_name';

    /** the column name for the email field */
    const EMAIL = 'site_user.email';

    /** the column name for the password field */
    const PASSWORD = 'site_user.password';

    /** the column name for the salt field */
    const SALT = 'site_user.salt';

    /** the column name for the enabled field */
    const ENABLED = 'site_user.enabled';

    /** the column name for the confirm_token field */
    const CONFIRM_TOKEN = 'site_user.confirm_token';

    /** the column name for the password_expired_at field */
    const PASSWORD_EXPIRED_AT = 'site_user.password_expired_at';

    /** the column name for the token_expired_at field */
    const TOKEN_EXPIRED_AT = 'site_user.token_expired_at';

    /** the column name for the default_roles field */
    const DEFAULT_ROLES = 'site_user.default_roles';

    /** the column name for the custom_roles field */
    const CUSTOM_ROLES = 'site_user.custom_roles';

    /** the column name for the last_login field */
    const LAST_LOGIN = 'site_user.last_login';

    /** the column name for the created_at field */
    const CREATED_AT = 'site_user.created_at';

    /** the column name for the updated_at field */
    const UPDATED_AT = 'site_user.updated_at';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identity map to hold any loaded instances of SiteUser objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array SiteUser[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. SiteUserPeer::$fieldNames[SiteUserPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('Id', 'LoginName', 'FirstName', 'LastName', 'Email', 'Password', 'Salt', 'Enabled', 'ConfirmToken', 'PasswordExpiredAt', 'TokenExpiredAt', 'DefaultRoles', 'CustomRoles', 'LastLogin', 'CreatedAt', 'UpdatedAt', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id', 'loginName', 'firstName', 'lastName', 'email', 'password', 'salt', 'enabled', 'confirmToken', 'passwordExpiredAt', 'tokenExpiredAt', 'defaultRoles', 'customRoles', 'lastLogin', 'createdAt', 'updatedAt', ),
        BasePeer::TYPE_COLNAME => array (SiteUserPeer::ID, SiteUserPeer::LOGIN_NAME, SiteUserPeer::FIRST_NAME, SiteUserPeer::LAST_NAME, SiteUserPeer::EMAIL, SiteUserPeer::PASSWORD, SiteUserPeer::SALT, SiteUserPeer::ENABLED, SiteUserPeer::CONFIRM_TOKEN, SiteUserPeer::PASSWORD_EXPIRED_AT, SiteUserPeer::TOKEN_EXPIRED_AT, SiteUserPeer::DEFAULT_ROLES, SiteUserPeer::CUSTOM_ROLES, SiteUserPeer::LAST_LOGIN, SiteUserPeer::CREATED_AT, SiteUserPeer::UPDATED_AT, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID', 'LOGIN_NAME', 'FIRST_NAME', 'LAST_NAME', 'EMAIL', 'PASSWORD', 'SALT', 'ENABLED', 'CONFIRM_TOKEN', 'PASSWORD_EXPIRED_AT', 'TOKEN_EXPIRED_AT', 'DEFAULT_ROLES', 'CUSTOM_ROLES', 'LAST_LOGIN', 'CREATED_AT', 'UPDATED_AT', ),
        BasePeer::TYPE_FIELDNAME => array ('id', 'login_name', 'first_name', 'last_name', 'email', 'password', 'salt', 'enabled', 'confirm_token', 'password_expired_at', 'token_expired_at', 'default_roles', 'custom_roles', 'last_login', 'created_at', 'updated_at', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. SiteUserPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'LoginName' => 1, 'FirstName' => 2, 'LastName' => 3, 'Email' => 4, 'Password' => 5, 'Salt' => 6, 'Enabled' => 7, 'ConfirmToken' => 8, 'PasswordExpiredAt' => 9, 'TokenExpiredAt' => 10, 'DefaultRoles' => 11, 'CustomRoles' => 12, 'LastLogin' => 13, 'CreatedAt' => 14, 'UpdatedAt' => 15, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('id' => 0, 'loginName' => 1, 'firstName' => 2, 'lastName' => 3, 'email' => 4, 'password' => 5, 'salt' => 6, 'enabled' => 7, 'confirmToken' => 8, 'passwordExpiredAt' => 9, 'tokenExpiredAt' => 10, 'defaultRoles' => 11, 'customRoles' => 12, 'lastLogin' => 13, 'createdAt' => 14, 'updatedAt' => 15, ),
        BasePeer::TYPE_COLNAME => array (SiteUserPeer::ID => 0, SiteUserPeer::LOGIN_NAME => 1, SiteUserPeer::FIRST_NAME => 2, SiteUserPeer::LAST_NAME => 3, SiteUserPeer::EMAIL => 4, SiteUserPeer::PASSWORD => 5, SiteUserPeer::SALT => 6, SiteUserPeer::ENABLED => 7, SiteUserPeer::CONFIRM_TOKEN => 8, SiteUserPeer::PASSWORD_EXPIRED_AT => 9, SiteUserPeer::TOKEN_EXPIRED_AT => 10, SiteUserPeer::DEFAULT_ROLES => 11, SiteUserPeer::CUSTOM_ROLES => 12, SiteUserPeer::LAST_LOGIN => 13, SiteUserPeer::CREATED_AT => 14, SiteUserPeer::UPDATED_AT => 15, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ID' => 0, 'LOGIN_NAME' => 1, 'FIRST_NAME' => 2, 'LAST_NAME' => 3, 'EMAIL' => 4, 'PASSWORD' => 5, 'SALT' => 6, 'ENABLED' => 7, 'CONFIRM_TOKEN' => 8, 'PASSWORD_EXPIRED_AT' => 9, 'TOKEN_EXPIRED_AT' => 10, 'DEFAULT_ROLES' => 11, 'CUSTOM_ROLES' => 12, 'LAST_LOGIN' => 13, 'CREATED_AT' => 14, 'UPDATED_AT' => 15, ),
        BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'login_name' => 1, 'first_name' => 2, 'last_name' => 3, 'email' => 4, 'password' => 5, 'salt' => 6, 'enabled' => 7, 'confirm_token' => 8, 'password_expired_at' => 9, 'token_expired_at' => 10, 'default_roles' => 11, 'custom_roles' => 12, 'last_login' => 13, 'created_at' => 14, 'updated_at' => 15, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = SiteUserPeer::getFieldNames($toType);
        $key = isset(SiteUserPeer::$fieldKeys[$fromType][$name]) ? SiteUserPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(SiteUserPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, SiteUserPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return SiteUserPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. SiteUserPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(SiteUserPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(SiteUserPeer::ID);
            $criteria->addSelectColumn(SiteUserPeer::LOGIN_NAME);
            $criteria->addSelectColumn(SiteUserPeer::FIRST_NAME);
            $criteria->addSelectColumn(SiteUserPeer::LAST_NAME);
            $criteria->addSelectColumn(SiteUserPeer::EMAIL);
            $criteria->addSelectColumn(SiteUserPeer::PASSWORD);
            $criteria->addSelectColumn(SiteUserPeer::SALT);
            $criteria->addSelectColumn(SiteUserPeer::ENABLED);
            $criteria->addSelectColumn(SiteUserPeer::CONFIRM_TOKEN);
            $criteria->addSelectColumn(SiteUserPeer::PASSWORD_EXPIRED_AT);
            $criteria->addSelectColumn(SiteUserPeer::TOKEN_EXPIRED_AT);
            $criteria->addSelectColumn(SiteUserPeer::DEFAULT_ROLES);
            $criteria->addSelectColumn(SiteUserPeer::CUSTOM_ROLES);
            $criteria->addSelectColumn(SiteUserPeer::LAST_LOGIN);
            $criteria->addSelectColumn(SiteUserPeer::CREATED_AT);
            $criteria->addSelectColumn(SiteUserPeer::UPDATED_AT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.login_name');
            $criteria->addSelectColumn($alias . '.first_name');
            $criteria->addSelectColumn($alias . '.last_name');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.password');
            $criteria->addSelectColumn($alias . '.salt');
            $criteria->addSelectColumn($alias . '.enabled');
            $criteria->addSelectColumn($alias . '.confirm_token');
            $criteria->addSelectColumn($alias . '.password_expired_at');
            $criteria->addSelectColumn($alias . '.token_expired_at');
            $criteria->addSelectColumn($alias . '.default_roles');
            $criteria->addSelectColumn($alias . '.custom_roles');
            $criteria->addSelectColumn($alias . '.last_login');
            $criteria->addSelectColumn($alias . '.created_at');
            $criteria->addSelectColumn($alias . '.updated_at');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(SiteUserPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            SiteUserPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(SiteUserPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return SiteUser
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = SiteUserPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return SiteUserPeer::populateObjects(SiteUserPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            SiteUserPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(SiteUserPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param SiteUser $obj A SiteUser object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getId();
            } // if key === null
            SiteUserPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A SiteUser object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof SiteUser) {
                $key = (string) $value->getId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or SiteUser object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(SiteUserPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return SiteUser Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(SiteUserPeer::$instances[$key])) {
                return SiteUserPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references) {
        foreach (SiteUserPeer::$instances as $instance) {
          $instance->clearAllReferences(true);
        }
      }
        SiteUserPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to site_user
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (string) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = SiteUserPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = SiteUserPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = SiteUserPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SiteUserPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (SiteUser object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = SiteUserPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = SiteUserPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + SiteUserPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SiteUserPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            SiteUserPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(SiteUserPeer::DATABASE_NAME)->getTable(SiteUserPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseSiteUserPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseSiteUserPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new \Backend\BaseBundle\Model\map\SiteUserTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return SiteUserPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a SiteUser or Criteria object.
     *
     * @param      mixed $values Criteria or SiteUser object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from SiteUser object
        }


        // Set the correct dbName
        $criteria->setDbName(SiteUserPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a SiteUser or Criteria object.
     *
     * @param      mixed $values Criteria or SiteUser object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(SiteUserPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(SiteUserPeer::ID);
            $value = $criteria->remove(SiteUserPeer::ID);
            if ($value) {
                $selectCriteria->add(SiteUserPeer::ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(SiteUserPeer::TABLE_NAME);
            }

        } else { // $values is SiteUser object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(SiteUserPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the site_user table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(SiteUserPeer::TABLE_NAME, $con, SiteUserPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            SiteUserPeer::clearInstancePool();
            SiteUserPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a SiteUser or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or SiteUser object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            SiteUserPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof SiteUser) { // it's a model object
            // invalidate the cache for this single object
            SiteUserPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SiteUserPeer::DATABASE_NAME);
            $criteria->add(SiteUserPeer::ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                SiteUserPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(SiteUserPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            SiteUserPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given SiteUser object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param SiteUser $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(SiteUserPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(SiteUserPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(SiteUserPeer::DATABASE_NAME, SiteUserPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param string $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return SiteUser
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = SiteUserPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(SiteUserPeer::DATABASE_NAME);
        $criteria->add(SiteUserPeer::ID, $pk);

        $v = SiteUserPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return SiteUser[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(SiteUserPeer::DATABASE_NAME);
            $criteria->add(SiteUserPeer::ID, $pks, Criteria::IN);
            $objs = SiteUserPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseSiteUserPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseSiteUserPeer::buildTableMap();

