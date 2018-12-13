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
use Backend\BaseBundle\Model\SiteUser;
use Backend\BaseBundle\Model\SiteUserGroup;
use Backend\BaseBundle\Model\SiteUserGroupPeer;
use Backend\BaseBundle\Model\SiteUserGroupQuery;

/**
 * @method SiteUserGroupQuery orderBySiteUserId($order = Criteria::ASC) Order by the site_user_id column
 * @method SiteUserGroupQuery orderBySiteGroupId($order = Criteria::ASC) Order by the site_group_id column
 *
 * @method SiteUserGroupQuery groupBySiteUserId() Group by the site_user_id column
 * @method SiteUserGroupQuery groupBySiteGroupId() Group by the site_group_id column
 *
 * @method SiteUserGroupQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SiteUserGroupQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SiteUserGroupQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SiteUserGroupQuery leftJoinSiteUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the SiteUser relation
 * @method SiteUserGroupQuery rightJoinSiteUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SiteUser relation
 * @method SiteUserGroupQuery innerJoinSiteUser($relationAlias = null) Adds a INNER JOIN clause to the query using the SiteUser relation
 *
 * @method SiteUserGroupQuery leftJoinSiteGroup($relationAlias = null) Adds a LEFT JOIN clause to the query using the SiteGroup relation
 * @method SiteUserGroupQuery rightJoinSiteGroup($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SiteGroup relation
 * @method SiteUserGroupQuery innerJoinSiteGroup($relationAlias = null) Adds a INNER JOIN clause to the query using the SiteGroup relation
 *
 * @method SiteUserGroup findOne(PropelPDO $con = null) Return the first SiteUserGroup matching the query
 * @method SiteUserGroup findOneOrCreate(PropelPDO $con = null) Return the first SiteUserGroup matching the query, or a new SiteUserGroup object populated from the query conditions when no match is found
 *
 * @method SiteUserGroup findOneBySiteUserId(string $site_user_id) Return the first SiteUserGroup filtered by the site_user_id column
 * @method SiteUserGroup findOneBySiteGroupId(string $site_group_id) Return the first SiteUserGroup filtered by the site_group_id column
 *
 * @method array findBySiteUserId(string $site_user_id) Return SiteUserGroup objects filtered by the site_user_id column
 * @method array findBySiteGroupId(string $site_group_id) Return SiteUserGroup objects filtered by the site_group_id column
 */
abstract class BaseSiteUserGroupQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSiteUserGroupQuery object.
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
            $modelName = 'Backend\\BaseBundle\\Model\\SiteUserGroup';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SiteUserGroupQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SiteUserGroupQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SiteUserGroupQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SiteUserGroupQuery) {
            return $criteria;
        }
        $query = new SiteUserGroupQuery(null, null, $modelAlias);

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
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array $key Primary key to use for the query
                         A Primary key composition: [$site_user_id, $site_group_id]
     * @param     PropelPDO $con an optional connection object
     *
     * @return   SiteUserGroup|SiteUserGroup[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SiteUserGroupPeer::getInstanceFromPool(serialize(array((string) $key[0], (string) $key[1]))))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SiteUserGroupPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 SiteUserGroup A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `site_user_id`, `site_group_id` FROM `site_user_group` WHERE `site_user_id` = :p0 AND `site_group_id` = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_STR);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_STR);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new SiteUserGroup();
            $obj->hydrate($row);
            SiteUserGroupPeer::addInstanceToPool($obj, serialize(array((string) $key[0], (string) $key[1])));
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
     * @return SiteUserGroup|SiteUserGroup[]|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|SiteUserGroup[]|mixed the list of results, formatted by the current formatter
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
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(SiteUserGroupPeer::SITE_USER_ID, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(SiteUserGroupPeer::SITE_GROUP_ID, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(SiteUserGroupPeer::SITE_USER_ID, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(SiteUserGroupPeer::SITE_GROUP_ID, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the site_user_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteUserId(1234); // WHERE site_user_id = 1234
     * $query->filterBySiteUserId(array(12, 34)); // WHERE site_user_id IN (12, 34)
     * $query->filterBySiteUserId(array('min' => 12)); // WHERE site_user_id >= 12
     * $query->filterBySiteUserId(array('max' => 12)); // WHERE site_user_id <= 12
     * </code>
     *
     * @see       filterBySiteUser()
     *
     * @param     mixed $siteUserId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function filterBySiteUserId($siteUserId = null, $comparison = null)
    {
        if (is_array($siteUserId)) {
            $useMinMax = false;
            if (isset($siteUserId['min'])) {
                $this->addUsingAlias(SiteUserGroupPeer::SITE_USER_ID, $siteUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($siteUserId['max'])) {
                $this->addUsingAlias(SiteUserGroupPeer::SITE_USER_ID, $siteUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserGroupPeer::SITE_USER_ID, $siteUserId, $comparison);
    }

    /**
     * Filter the query on the site_group_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySiteGroupId(1234); // WHERE site_group_id = 1234
     * $query->filterBySiteGroupId(array(12, 34)); // WHERE site_group_id IN (12, 34)
     * $query->filterBySiteGroupId(array('min' => 12)); // WHERE site_group_id >= 12
     * $query->filterBySiteGroupId(array('max' => 12)); // WHERE site_group_id <= 12
     * </code>
     *
     * @see       filterBySiteGroup()
     *
     * @param     mixed $siteGroupId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function filterBySiteGroupId($siteGroupId = null, $comparison = null)
    {
        if (is_array($siteGroupId)) {
            $useMinMax = false;
            if (isset($siteGroupId['min'])) {
                $this->addUsingAlias(SiteUserGroupPeer::SITE_GROUP_ID, $siteGroupId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($siteGroupId['max'])) {
                $this->addUsingAlias(SiteUserGroupPeer::SITE_GROUP_ID, $siteGroupId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SiteUserGroupPeer::SITE_GROUP_ID, $siteGroupId, $comparison);
    }

    /**
     * Filter the query by a related SiteUser object
     *
     * @param   SiteUser|PropelObjectCollection $siteUser The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteUserGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySiteUser($siteUser, $comparison = null)
    {
        if ($siteUser instanceof SiteUser) {
            return $this
                ->addUsingAlias(SiteUserGroupPeer::SITE_USER_ID, $siteUser->getId(), $comparison);
        } elseif ($siteUser instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SiteUserGroupPeer::SITE_USER_ID, $siteUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySiteUser() only accepts arguments of type SiteUser or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SiteUser relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function joinSiteUser($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SiteUser');

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
            $this->addJoinObject($join, 'SiteUser');
        }

        return $this;
    }

    /**
     * Use the SiteUser relation SiteUser object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Backend\BaseBundle\Model\SiteUserQuery A secondary query class using the current class as primary query
     */
    public function useSiteUserQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSiteUser($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SiteUser', '\Backend\BaseBundle\Model\SiteUserQuery');
    }

    /**
     * Filter the query by a related SiteGroup object
     *
     * @param   SiteGroup|PropelObjectCollection $siteGroup The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SiteUserGroupQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySiteGroup($siteGroup, $comparison = null)
    {
        if ($siteGroup instanceof SiteGroup) {
            return $this
                ->addUsingAlias(SiteUserGroupPeer::SITE_GROUP_ID, $siteGroup->getId(), $comparison);
        } elseif ($siteGroup instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SiteUserGroupPeer::SITE_GROUP_ID, $siteGroup->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterBySiteGroup() only accepts arguments of type SiteGroup or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the SiteGroup relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function joinSiteGroup($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('SiteGroup');

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
            $this->addJoinObject($join, 'SiteGroup');
        }

        return $this;
    }

    /**
     * Use the SiteGroup relation SiteGroup object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \Backend\BaseBundle\Model\SiteGroupQuery A secondary query class using the current class as primary query
     */
    public function useSiteGroupQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSiteGroup($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'SiteGroup', '\Backend\BaseBundle\Model\SiteGroupQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   SiteUserGroup $siteUserGroup Object to remove from the list of results
     *
     * @return SiteUserGroupQuery The current query, for fluid interface
     */
    public function prune($siteUserGroup = null)
    {
        if ($siteUserGroup) {
            $this->addCond('pruneCond0', $this->getAliasedColName(SiteUserGroupPeer::SITE_USER_ID), $siteUserGroup->getSiteUserId(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(SiteUserGroupPeer::SITE_GROUP_ID), $siteUserGroup->getSiteGroupId(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

}
