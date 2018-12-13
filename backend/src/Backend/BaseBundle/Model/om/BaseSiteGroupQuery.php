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
use Backend\BaseBundle\Model\SiteGroup;
use Backend\BaseBundle\Model\SiteGroupPeer;
use Backend\BaseBundle\Model\SiteGroupQuery;
use Backend\BaseBundle\Model\SiteUser;
use Backend\BaseBundle\Model\SiteUserGroup;

/**
 * @method SiteGroupQuery orderById($order = Criteria::ASC) Order by the id column
 * @method SiteGroupQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method SiteGroupQuery orderByDefaultRoles($order = Criteria::ASC) Order by the default_roles column
 * @method SiteGroupQuery orderByCustomRoles($order = Criteria::ASC) Order by the custom_roles column
 * @method SiteGroupQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method SiteGroupQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method SiteGroupQuery groupById() Group by the id column
 * @method SiteGroupQuery groupByName() Group by the name column
 * @method SiteGroupQuery groupByDefaultRoles() Group by the default_roles column
 * @method SiteGroupQuery groupByCustomRoles() Group by the custom_roles column
 * @method SiteGroupQuery groupByCreatedAt() Group by the created_at column
 * @method SiteGroupQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method SiteGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SiteGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SiteGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SiteGroupQuery leftJoinSiteUserGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the SiteUserGroup relation
 * @method SiteGroupQuery rightJoinSiteUserGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SiteUserGroup relation
 * @method SiteGroupQuery innerJoinSiteUserGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the SiteUserGroup relation
 *
 * @method SiteGroup findOne(PropelPDO $con = null) Return the first SiteGroup matching the query
 * @method SiteGroup findOneOrCreate(PropelPDO $con = null) Return the first SiteGroup matching the query, or a new SiteGroup object populated from the query conditions when no match is found
 *
 * @method SiteGroup findOneByName(string $name) Return the first SiteGroup filtered by the name column
 * @method SiteGroup findOneByDefaultRoles(array $default_roles) Return the first SiteGroup filtered by the default_roles column
 * @method SiteGroup findOneByCustomRoles(array $custom_roles) Return the first SiteGroup filtered by the custom_roles column
 * @method SiteGroup findOneByCreatedAt(string $created_at) Return the first SiteGroup filtered by the created_at column
 * @method SiteGroup findOneByUpdatedAt(string $updated_at) Return the first SiteGroup filtered by the updated_at column
 *
 * @method array findById(string $id) Return SiteGroup objects filtered by the id column
 * @method array findByName(string $name) Return SiteGroup objects filtered by the name column
 * @method array findByDefaultRoles(array $default_roles) Return SiteGroup objects filtered by the default_roles column
 * @method array findByCustomRoles(array $custom_roles) Return SiteGroup objects filtered by the custom_roles column
 * @method array findByCreatedAt(string $created_at) Return SiteGroup objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return SiteGroup objects filtered by the updated_at column
 */
abstract class BaseSiteGroupQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSiteGroupQuery object.
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
            $modelName = 'Backend\\BaseBundle\\Model\\SiteGroup';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SiteGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SiteGroupQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SiteGroupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SiteGroupQuery) {
            return $criteria;
        }
        $query = new SiteGroupQuery(null, null, $modelAlias);

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
     * @return   SiteGroup|SiteGroup[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SiteGroupPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SiteGroupPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 SiteGroup A model object, or null if the key is not found
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
     * @return                 SiteGroup A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `name`, `default_roles`, `custom_roles`, `created_at`, `updated_at` FROM `site_group` WHERE `id` = :p0';
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
            $obj = new SiteGroup();
            $obj->hydrate($row);
            SiteGroupPeer::addInstanceToPool($obj, (string) $key);
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
     * @return SiteGroup|SiteGroup[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|SiteGroup[]|mixed the list of results, formatted by the current formatter
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
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SiteGroupPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SiteGroupPeer::ID, $keys, Criteria::IN);
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
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(SiteGroupPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(SiteGroupPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteGroupPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SiteGroupPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the default_roles column
     *
     * @param     array $defaultRoles The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByDefaultRoles($defaultRoles = null, $comparison = null)
    {
        $key = $this->getAliasedColName(SiteGroupPeer::DEFAULT_ROLES);
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

        return $this->addUsingAlias(SiteGroupPeer::DEFAULT_ROLES, $defaultRoles, $comparison);
    }

    /**
     * Filter the query on the default_roles column
     * @param     mixed $defaultRoles The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return SiteGroupQuery The current query, for fluid interface
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
            $key = $this->getAliasedColName(SiteGroupPeer::DEFAULT_ROLES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $defaultRoles, $comparison);
            } else {
                $this->addAnd($key, $defaultRoles, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SiteGroupPeer::DEFAULT_ROLES, $defaultRoles, $comparison);
    }

    /**
     * Filter the query on the custom_roles column
     *
     * @param     array $customRoles The values to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByCustomRoles($customRoles = null, $comparison = null)
    {
        $key = $this->getAliasedColName(SiteGroupPeer::CUSTOM_ROLES);
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

        return $this->addUsingAlias(SiteGroupPeer::CUSTOM_ROLES, $customRoles, $comparison);
    }

    /**
     * Filter the query on the custom_roles column
     * @param     mixed $customRoles The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::CONTAINS_ALL
     *
     * @return SiteGroupQuery The current query, for fluid interface
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
            $key = $this->getAliasedColName(SiteGroupPeer::CUSTOM_ROLES);
            if ($this->containsKey($key)) {
                $this->addAnd($key, $customRoles, $comparison);
            } else {
                $this->addAnd($key, $customRoles, $comparison);
            }
            $this->addOr($key, null, Criteria::ISNULL);

            return $this;
        }

        return $this->addUsingAlias(SiteGroupPeer::CUSTOM_ROLES, $customRoles, $comparison);
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
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(SiteGroupPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(SiteGroupPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteGroupPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(SiteGroupPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(SiteGroupPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteGroupPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related SiteUserGroup object
     *
     * @param   SiteUserGroup|PropelObjectCollection $siteUserGroup  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySiteUserGroup($siteUserGroup, $comparison = null)
    {
        if ($siteUserGroup instanceof SiteUserGroup) {
            return $this
                ->addUsingAlias(SiteGroupPeer::ID, $siteUserGroup->getSiteGroupId(), $comparison);
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
     * @return SiteGroupQuery The current query, for fluid interface
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
     * Filter the query by a related SiteUser object
     * using the site_user_group table as cross reference
     *
     * @param   SiteUser $siteUser the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return   SiteGroupQuery The current query, for fluid interface
     */
    public function filterBySiteUser($siteUser, $comparison = Criteria::EQUAL)
    {
        return $this
            ->useSiteUserGroupQuery()
            ->filterBySiteUser($siteUser, $comparison)
            ->endUse();
    }

    /**
     * Exclude object from result
     *
     * @param   SiteGroup $siteGroup Object to remove from the list of results
     *
     * @return SiteGroupQuery The current query, for fluid interface
     */
    public function prune($siteGroup = null)
    {
        if ($siteGroup) {
            $this->addUsingAlias(SiteGroupPeer::ID, $siteGroup->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     SiteGroupQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(SiteGroupPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     SiteGroupQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(SiteGroupPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     SiteGroupQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(SiteGroupPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     SiteGroupQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(SiteGroupPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     SiteGroupQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(SiteGroupPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     SiteGroupQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(SiteGroupPeer::CREATED_AT);
    }
}
