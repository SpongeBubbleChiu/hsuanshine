<?php

namespace Backend\BaseBundle\Model\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use Backend\BaseBundle\Model\OperationLog;
use Backend\BaseBundle\Model\SiteGroup;
use Backend\BaseBundle\Model\SiteUser;
use Backend\BaseBundle\Model\SiteUserGroup;
use Backend\BaseBundle\Model\SiteUserPeer;
use Backend\BaseBundle\Model\SiteUserQuery;
use Widget\StockBundle\Model\StockLog;
use Widget\StockBundle\Model\StockStyleLog;

/**
 * @method SiteUserQuery orderById($order = Criteria::ASC) Order by the id column
 * @method SiteUserQuery orderByLoginName($order = Criteria::ASC) Order by the login_name column
 * @method SiteUserQuery orderByFirstName($order = Criteria::ASC) Order by the first_name column
 * @method SiteUserQuery orderByLastName($order = Criteria::ASC) Order by the last_name column
 * @method SiteUserQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method SiteUserQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method SiteUserQuery orderBySalt($order = Criteria::ASC) Order by the salt column
 * @method SiteUserQuery orderByEnabled($order = Criteria::ASC) Order by the enabled column
 * @method SiteUserQuery orderByConfirmToken($order = Criteria::ASC) Order by the confirm_token column
 * @method SiteUserQuery orderByPasswordExpiredAt($order = Criteria::ASC) Order by the password_expired_at column
 * @method SiteUserQuery orderByTokenExpiredAt($order = Criteria::ASC) Order by the token_expired_at column
 * @method SiteUserQuery orderByDefaultRoles($order = Criteria::ASC) Order by the default_roles column
 * @method SiteUserQuery orderByCustomRoles($order = Criteria::ASC) Order by the custom_roles column
 * @method SiteUserQuery orderByLastLogin($order = Criteria::ASC) Order by the last_login column
 * @method SiteUserQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method SiteUserQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method SiteUserQuery groupById() Group by the id column
 * @method SiteUserQuery groupByLoginName() Group by the login_name column
 * @method SiteUserQuery groupByFirstName() Group by the first_name column
 * @method SiteUserQuery groupByLastName() Group by the last_name column
 * @method SiteUserQuery groupByEmail() Group by the email column
 * @method SiteUserQuery groupByPassword() Group by the password column
 * @method SiteUserQuery groupBySalt() Group by the salt column
 * @method SiteUserQuery groupByEnabled() Group by the enabled column
 * @method SiteUserQuery groupByConfirmToken() Group by the confirm_token column
 * @method SiteUserQuery groupByPasswordExpiredAt() Group by the password_expired_at column
 * @method SiteUserQuery groupByTokenExpiredAt() Group by the token_expired_at column
 * @method SiteUserQuery groupByDefaultRoles() Group by the default_roles column
 * @method SiteUserQuery groupByCustomRoles() Group by the custom_roles column
 * @method SiteUserQuery groupByLastLogin() Group by the last_login column
 * @method SiteUserQuery groupByCreatedAt() Group by the created_at column
 * @method SiteUserQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method SiteUserQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SiteUserQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SiteUserQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SiteUserQuery leftJoinOperationLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the OperationLog relation
 * @method SiteUserQuery rightJoinOperationLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the OperationLog relation
 * @method SiteUserQuery innerJoinOperationLog($relationAlias = null) Adds a INNER JOIN clause to the query using the OperationLog relation
 *
 * @method SiteUserQuery leftJoinSiteUserGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the SiteUserGroup relation
 * @method SiteUserQuery rightJoinSiteUserGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SiteUserGroup relation
 * @method SiteUserQuery innerJoinSiteUserGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the SiteUserGroup relation
 *
 * @method SiteUserQuery leftJoinStockLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the StockLog relation
 * @method SiteUserQuery rightJoinStockLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StockLog relation
 * @method SiteUserQuery innerJoinStockLog($relationAlias = null) Adds a INNER JOIN clause to the query using the StockLog relation
 *
 * @method SiteUserQuery leftJoinStockStyleLog($relationAlias = null) Adds a LEFT JOIN clause to the query using the StockStyleLog relation
 * @method SiteUserQuery rightJoinStockStyleLog($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StockStyleLog relation
 * @method SiteUserQuery innerJoinStockStyleLog($relationAlias = null) Adds a INNER JOIN clause to the query using the StockStyleLog relation
 *
 * @method SiteUser findOne(PropelPDO $con = null) Return the first SiteUser matching the query
 * @method SiteUser findOneOrCreate(PropelPDO $con = null) Return the first SiteUser matching the query, or a new SiteUser object populated from the query conditions when no match is found
 *
 * @method SiteUser findOneByLoginName(string $login_name) Return the first SiteUser filtered by the login_name column
 * @method SiteUser findOneByFirstName(string $first_name) Return the first SiteUser filtered by the first_name column
 * @method SiteUser findOneByLastName(string $last_name) Return the first SiteUser filtered by the last_name column
 * @method SiteUser findOneByEmail(string $email) Return the first SiteUser filtered by the email column
 * @method SiteUser findOneByPassword(string $password) Return the first SiteUser filtered by the password column
 * @method SiteUser findOneBySalt(string $salt) Return the first SiteUser filtered by the salt column
 * @method SiteUser findOneByEnabled(boolean $enabled) Return the first SiteUser filtered by the enabled column
 * @method SiteUser findOneByConfirmToken(string $confirm_token) Return the first SiteUser filtered by the confirm_token column
 * @method SiteUser findOneByPasswordExpiredAt(string $password_expired_at) Return the first SiteUser filtered by the password_expired_at column
 * @method SiteUser findOneByTokenExpiredAt(string $token_expired_at) Return the first SiteUser filtered by the token_expired_at column
 * @method SiteUser findOneByDefaultRoles(array $default_roles) Return the first SiteUser filtered by the default_roles column
 * @method SiteUser findOneByCustomRoles(array $custom_roles) Return the first SiteUser filtered by the custom_roles column
 * @method SiteUser findOneByLastLogin(string $last_login) Return the first SiteUser filtered by the last_login column
 * @method SiteUser findOneByCreatedAt(string $created_at) Return the first SiteUser filtered by the created_at column
 * @method SiteUser findOneByUpdatedAt(string $updated_at) Return the first SiteUser filtered by the updated_at column
 *
 * @method array findById(string $id) Return SiteUser objects filtered by the id column
 * @method array findByLoginName(string $login_name) Return SiteUser objects filtered by the login_name column
 * @method array findByFirstName(string $first_name) Return SiteUser objects filtered by the first_name column
 * @method array findByLastName(string $last_name) Return SiteUser objects filtered by the last_name column
 * @method array findByEmail(string $email) Return SiteUser objects filtered by the email column
 * @method array findByPassword(string $password) Return SiteUser objects filtered by the password column
 * @method array findBySalt(string $salt) Return SiteUser objects filtered by the salt column
 * @method array findByEnabled(boolean $enabled) Return SiteUser objects filtered by the enabled column
 * @method array findByConfirmToken(string $confirm_token) Return SiteUser objects filtered by the confirm_token column
 * @method array findByPasswordExpiredAt(string $password_expired_at) Return SiteUser objects filtered by the password_expired_at column
 * @method array findByTokenExpiredAt(string $token_expired_at) Return SiteUser objects filtered by the token_expired_at column
 * @method array findByDefaultRoles(array $default_roles) Return SiteUser objects filtered by the default_roles column
 * @method array findByCustomRoles(array $custom_roles) Return SiteUser objects filtered by the custom_roles column
 * @method array findByLastLogin(string $last_login) Return SiteUser objects filtered by the last_login column
 * @method array findByCreatedAt(string $created_at) Return SiteUser objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return SiteUser objects filtered by the updated_at column
 */
abstract class BaseSiteUserQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSiteUserQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = null, $modelName = null, $modelAlias = null)
    {
        if (null === $dbName) {
            $dbName = 'default';
        }
        if (null === $modelName) {
            $modelName = 'Backend\\BaseBundle\\Model\\SiteUser';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SiteUserQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SiteUserQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SiteUserQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SiteUserQuery) {
            return $criteria;
        }
        $query = new SiteUserQuery(null, null, $modelAlias);

        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   SiteUser|SiteUser[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SiteUserPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SiteUserPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 SiteUser A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 SiteUser A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `login_name`, `first_name`, `last_name`, `email`, `password`, `salt`, `enabled`, `confirm_token`, `password_expired_at`, `token_expired_at`, `default_roles`, `custom_roles`, `last_login`, `created_at`, `updated_at` FROM `site_user` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new SiteUser();
            $obj->hydrate($row);
            SiteUserPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return SiteUser|SiteUser[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|SiteUser[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SiteUserPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SiteUserPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SiteUserPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SiteUserPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the login_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLoginName('fooValue');   // WHERE login_name = 'fooValue'
     * $query->filterByLoginName('%fooValue%'); // WHERE login_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $loginName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByLoginName($loginName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($loginName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $loginName)) {
                $loginName = str_replace('*', '%', $loginName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::LOGIN_NAME, $loginName, $comparison);
    }

    /**
     * Filter the query on the first_name column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstName('fooValue');   // WHERE first_name = 'fooValue'
     * $query->filterByFirstName('%fooValue%'); // WHERE first_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByFirstName($firstName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstName)) {
                $firstName = str_replace('*', '%', $firstName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::FIRST_NAME, $firstName, $comparison);
    }

    /**
     * Filter the query on the last_name column
     *
     * Example usage:
     * <code>
     * $query->filterByLastName('fooValue');   // WHERE last_name = 'fooValue'
     * $query->filterByLastName('%fooValue%'); // WHERE last_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByLastName($lastName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastName)) {
                $lastName = str_replace('*', '%', $lastName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::LAST_NAME, $lastName, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the salt column
     *
     * Example usage:
     * <code>
     * $query->filterBySalt('fooValue');   // WHERE salt = 'fooValue'
     * $query->filterBySalt('%fooValue%'); // WHERE salt LIKE '%fooValue%'
     * </code>
     *
     * @param     string $salt The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterBySalt($salt = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($salt)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $salt)) {
                $salt = str_replace('*', '%', $salt);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::SALT, $salt, $comparison);
    }

    /**
     * Filter the query on the enabled column
     *
     * Example usage:
     * <code>
     * $query->filterByEnabled(true); // WHERE enabled = true
     * $query->filterByEnabled('yes'); // WHERE enabled = true
     * </code>
     *
     * @param     boolean|string $enabled The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByEnabled($enabled = null, $comparison = null)
    {
        if (is_string($enabled)) {
            $enabled = in_array(strtolower($enabled), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(SiteUserPeer::ENABLED, $enabled, $comparison);
    }

    /**
     * Filter the query on the confirm_token column
     *
     * Example usage:
     * <code>
     * $query->filterByConfirmToken('fooValue');   // WHERE confirm_token = 'fooValue'
     * $query->filterByConfirmToken('%fooValue%'); // WHERE confirm_token LIKE '%fooValue%'
     * </code>
     *
     * @param     string $confirmToken The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByConfirmToken($confirmToken = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($confirmToken)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $confirmToken)) {
                $confirmToken = str_replace('*', '%', $confirmToken);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::CONFIRM_TOKEN, $confirmToken, $comparison);
    }

    /**
     * Filter the query on the password_expired_at column
     *
     * Example usage:
     * <code>
     * $query->filterByPasswordExpiredAt('2011-03-14'); // WHERE password_expired_at = '2011-03-14'
     * $query->filterByPasswordExpiredAt('now'); // WHERE password_expired_at = '2011-03-14'
     * $query->filterByPasswordExpiredAt(array('max' => 'yesterday')); // WHERE password_expired_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $passwordExpiredAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByPasswordExpiredAt($passwordExpiredAt = null, $comparison = null)
    {
        if (is_array($passwordExpiredAt)) {
            $useMinMax = false;
            if (isset($passwordExpiredAt['min'])) {
                $this->addUsingAlias(SiteUserPeer::PASSWORD_EXPIRED_AT, $passwordExpiredAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($passwordExpiredAt['max'])) {
                $this->addUsingAlias(SiteUserPeer::PASSWORD_EXPIRED_AT, $passwordExpiredAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::PASSWORD_EXPIRED_AT, $passwordExpiredAt, $comparison);
    }

    /**
     * Filter the query on the token_expired_at column
     *
     * Example usage:
     * <code>
     * $query->filterByTokenExpiredAt('2011-03-14'); // WHERE token_expired_at = '2011-03-14'
     * $query->filterByTokenExpiredAt('now'); // WHERE token_expired_at = '2011-03-14'
     * $query->filterByTokenExpiredAt(array('max' => 'yesterday')); // WHERE token_expired_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $tokenExpiredAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByTokenExpiredAt($tokenExpiredAt = null, $comparison = null)
    {
        if (is_array($tokenExpiredAt)) {
            $useMinMax = false;
            if (isset($tokenExpiredAt['min'])) {
                $this->addUsingAlias(SiteUserPeer::TOKEN_EXPIRED_AT, $tokenExpiredAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tokenExpiredAt['max'])) {
                $this->addUsingAlias(SiteUserPeer::TOKEN_EXPIRED_AT, $tokenExpiredAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::TOKEN_EXPIRED_AT, $tokenExpiredAt, $comparison);
    }

    /**
     * Filter the query on the default_roles column
     *
     * @param     array $defaultRoles The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByDefaultRoles($defaultRoles = null, $comparison = null)
    {
        $key = $this->getAliasedColName(SiteUserPeer::DEFAULT_ROLES);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($defaultRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($defaultRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($defaultRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SiteUserPeer::DEFAULT_ROLES, $defaultRoles, $comparison);
    }

    /**
     * Filter the query on the default_roles column
     * @param     mixed $defaultRoles The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByDefaultRole($defaultRoles = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($defaultRoles)) {
                $defaultRoles = '%| ' . $defaultRoles . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $defaultRoles = '%| ' . $defaultRoles . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(SiteUserPeer::DEFAULT_ROLES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $defaultRoles, $comparison);
            } else {
                $this->addAnd($key, $defaultRoles, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SiteUserPeer::DEFAULT_ROLES, $defaultRoles, $comparison);
    }

    /**
     * Filter the query on the custom_roles column
     *
     * @param     array $customRoles The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByCustomRoles($customRoles = null, $comparison = null)
    {
        $key = $this->getAliasedColName(SiteUserPeer::CUSTOM_ROLES);
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            foreach ($customRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_SOME) {
            foreach ($customRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addOr($key, $value, Criteria::LIKE);
                } else {
                    $this->add($key, $value, Criteria::LIKE);
                }
            }

            return $this;
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            foreach ($customRoles as $value) {
                $value = '%| ' . $value . ' |%';
                if ($this->containsKey($key)) {
                    $this->addAnd($key, $value, Criteria::NOT_LIKE);
                } else {
                    $this->add($key, $value, Criteria::NOT_LIKE);
                }
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SiteUserPeer::CUSTOM_ROLES, $customRoles, $comparison);
    }

    /**
     * Filter the query on the custom_roles column
     * @param     mixed $customRoles The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByCustomRole($customRoles = null, $comparison = null)
    {
        if (null === $comparison || $comparison == Criteria::CONTAINS_ALL) {
            if (is_scalar($customRoles)) {
                $customRoles = '%| ' . $customRoles . ' |%';
                $comparison = Criteria::LIKE;
            }
        } elseif ($comparison == Criteria::CONTAINS_NONE) {
            $customRoles = '%| ' . $customRoles . ' |%';
            $comparison = Criteria::NOT_LIKE;
            $key = $this->getAliasedColName(SiteUserPeer::CUSTOM_ROLES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $customRoles, $comparison);
            } else {
                $this->addAnd($key, $customRoles, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SiteUserPeer::CUSTOM_ROLES, $customRoles, $comparison);
    }

    /**
     * Filter the query on the last_login column
     *
     * Example usage:
     * <code>
     * $query->filterByLastLogin('2011-03-14'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin('now'); // WHERE last_login = '2011-03-14'
     * $query->filterByLastLogin(array('max' => 'yesterday')); // WHERE last_login < '2011-03-13'
     * </code>
     *
     * @param     mixed $lastLogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByLastLogin($lastLogin = null, $comparison = null)
    {
        if (is_array($lastLogin)) {
            $useMinMax = false;
            if (isset($lastLogin['min'])) {
                $this->addUsingAlias(SiteUserPeer::LAST_LOGIN, $lastLogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastLogin['max'])) {
                $this->addUsingAlias(SiteUserPeer::LAST_LOGIN, $lastLogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::LAST_LOGIN, $lastLogin, $comparison);
    }

    /**
     * Filter the query on the created_at column
     *
     * Example usage:
     * <code>
     * $query->filterByCreatedAt('2011-03-14'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt('now'); // WHERE created_at = '2011-03-14'
     * $query->filterByCreatedAt(array('max' => 'yesterday')); // WHERE created_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $createdAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SiteUserPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SiteUserPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::CREATED_AT, $createdAt, $comparison);
    }

    /**
     * Filter the query on the updated_at column
     *
     * Example usage:
     * <code>
     * $query->filterByUpdatedAt('2011-03-14'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt('now'); // WHERE updated_at = '2011-03-14'
     * $query->filterByUpdatedAt(array('max' => 'yesterday')); // WHERE updated_at < '2011-03-13'
     * </code>
     *
     * @param     mixed $updatedAt The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SiteUserPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SiteUserPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related OperationLog object
     *
     * @param   OperationLog|PropelObjectCollection $operationLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteUserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByOperationLog($operationLog, $comparison = null)
    {
        if ($operationLog instanceof OperationLog) {
            return $this
                ->addUsingAlias(SiteUserPeer::ID, $operationLog->getSiteUserId(), $comparison);
        } elseif ($operationLog instanceof PropelObjectCollection) {
            return $this
                ->useOperationLogQuery()
                ->filterByPrimaryKeys($operationLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOperationLog() only accepts arguments of type OperationLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the OperationLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function joinOperationLog($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('OperationLog');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'OperationLog');
        }

        return $this;
    }

    /**
     * Use the OperationLog relation OperationLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Backend\BaseBundle\Model\OperationLogQuery A secondary query class using the current class as primary query
     */
    public function useOperationLogQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOperationLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'OperationLog', '\Backend\BaseBundle\Model\OperationLogQuery');
    }

    /**
     * Filter the query by a related SiteUserGroup object
     *
     * @param   SiteUserGroup|PropelObjectCollection $siteUserGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteUserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySiteUserGroup($siteUserGroup, $comparison = null)
    {
        if ($siteUserGroup instanceof SiteUserGroup) {
            return $this
                ->addUsingAlias(SiteUserPeer::ID, $siteUserGroup->getSiteUserId(), $comparison);
        } elseif ($siteUserGroup instanceof PropelObjectCollection) {
            return $this
                ->useSiteUserGroupQuery()
                ->filterByPrimaryKeys($siteUserGroup->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySiteUserGroup() only accepts arguments of type SiteUserGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SiteUserGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function joinSiteUserGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SiteUserGroup');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'SiteUserGroup');
        }

        return $this;
    }

    /**
     * Use the SiteUserGroup relation SiteUserGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Backend\BaseBundle\Model\SiteUserGroupQuery A secondary query class using the current class as primary query
     */
    public function useSiteUserGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSiteUserGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SiteUserGroup', '\Backend\BaseBundle\Model\SiteUserGroupQuery');
    }

    /**
     * Filter the query by a related StockLog object
     *
     * @param   StockLog|PropelObjectCollection $stockLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteUserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStockLog($stockLog, $comparison = null)
    {
        if ($stockLog instanceof StockLog) {
            return $this
                ->addUsingAlias(SiteUserPeer::ID, $stockLog->getSiteUserId(), $comparison);
        } elseif ($stockLog instanceof PropelObjectCollection) {
            return $this
                ->useStockLogQuery()
                ->filterByPrimaryKeys($stockLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStockLog() only accepts arguments of type StockLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StockLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function joinStockLog($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StockLog');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StockLog');
        }

        return $this;
    }

    /**
     * Use the StockLog relation StockLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Widget\StockBundle\Model\StockLogQuery A secondary query class using the current class as primary query
     */
    public function useStockLogQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStockLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StockLog', '\Widget\StockBundle\Model\StockLogQuery');
    }

    /**
     * Filter the query by a related StockStyleLog object
     *
     * @param   StockStyleLog|PropelObjectCollection $stockStyleLog  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteUserQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStockStyleLog($stockStyleLog, $comparison = null)
    {
        if ($stockStyleLog instanceof StockStyleLog) {
            return $this
                ->addUsingAlias(SiteUserPeer::ID, $stockStyleLog->getSiteUserId(), $comparison);
        } elseif ($stockStyleLog instanceof PropelObjectCollection) {
            return $this
                ->useStockStyleLogQuery()
                ->filterByPrimaryKeys($stockStyleLog->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStockStyleLog() only accepts arguments of type StockStyleLog or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StockStyleLog relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function joinStockStyleLog($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StockStyleLog');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StockStyleLog');
        }

        return $this;
    }

    /**
     * Use the StockStyleLog relation StockStyleLog object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Widget\StockBundle\Model\StockStyleLogQuery A secondary query class using the current class as primary query
     */
    public function useStockStyleLogQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStockStyleLog($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StockStyleLog', '\Widget\StockBundle\Model\StockStyleLogQuery');
    }

    /**
     * Filter the query by a related SiteGroup object
     * using the site_user_group table as cross reference
     *
     * @param   SiteGroup $siteGroup the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SiteUserQuery The current query, for fluid interface
     */
    public function filterBySiteGroup($siteGroup, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSiteUserGroupQuery()
            ->filterBySiteGroup($siteGroup, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   SiteUser $siteUser Object to remove from the list of results
     *
     * @return SiteUserQuery The current query, for fluid interface
     */
    public function prune($siteUser = null)
    {
        if ($siteUser) {
            $this->addUsingAlias(SiteUserPeer::ID, $siteUser->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     SiteUserQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SiteUserPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     SiteUserQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SiteUserPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     SiteUserQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SiteUserPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     SiteUserQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SiteUserPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     SiteUserQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SiteUserPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     SiteUserQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SiteUserPeer::CREATED_AT);
    }
}
