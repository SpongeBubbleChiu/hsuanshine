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
use Backend\BaseBundle\Model\OperationLogPeer;
use Backend\BaseBundle\Model\OperationLogQuery;
use Backend\BaseBundle\Model\SiteUser;

/**
 * @method OperationLogQuery orderById($order = Criteria::ASC) Order by the id column
 * @method OperationLogQuery orderBySiteUserId($order = Criteria::ASC) Order by the site_user_id column
 * @method OperationLogQuery orderByModifyType($order = Criteria::ASC) Order by the modify_type column
 * @method OperationLogQuery orderByModifyTable($order = Criteria::ASC) Order by the modify_table column
 * @method OperationLogQuery orderByModifyColumn($order = Criteria::ASC) Order by the modify_column column
 * @method OperationLogQuery orderByCreatedAt($order = Criteria::ASC) Order by the created_at column
 * @method OperationLogQuery orderByUpdatedAt($order = Criteria::ASC) Order by the updated_at column
 *
 * @method OperationLogQuery groupById() Group by the id column
 * @method OperationLogQuery groupBySiteUserId() Group by the site_user_id column
 * @method OperationLogQuery groupByModifyType() Group by the modify_type column
 * @method OperationLogQuery groupByModifyTable() Group by the modify_table column
 * @method OperationLogQuery groupByModifyColumn() Group by the modify_column column
 * @method OperationLogQuery groupByCreatedAt() Group by the created_at column
 * @method OperationLogQuery groupByUpdatedAt() Group by the updated_at column
 *
 * @method OperationLogQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method OperationLogQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method OperationLogQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method OperationLogQuery leftJoinSiteUser($relationAlias = null) Adds a LEFT JOIN clause to the query using the SiteUser relation
 * @method OperationLogQuery rightJoinSiteUser($relationAlias = null) Adds a RIGHT JOIN clause to the query using the SiteUser relation
 * @method OperationLogQuery innerJoinSiteUser($relationAlias = null) Adds a INNER JOIN clause to the query using the SiteUser relation
 *
 * @method OperationLog findOne(PropelPDO $con = null) Return the first OperationLog matching the query
 * @method OperationLog findOneOrCreate(PropelPDO $con = null) Return the first OperationLog matching the query, or a new OperationLog object populated from the query conditions when no match is found
 *
 * @method OperationLog findOneBySiteUserId(string $site_user_id) Return the first OperationLog filtered by the site_user_id column
 * @method OperationLog findOneByModifyType(int $modify_type) Return the first OperationLog filtered by the modify_type column
 * @method OperationLog findOneByModifyTable(string $modify_table) Return the first OperationLog filtered by the modify_table column
 * @method OperationLog findOneByModifyColumn( $modify_column) Return the first OperationLog filtered by the modify_column column
 * @method OperationLog findOneByCreatedAt(string $created_at) Return the first OperationLog filtered by the created_at column
 * @method OperationLog findOneByUpdatedAt(string $updated_at) Return the first OperationLog filtered by the updated_at column
 *
 * @method array findById(string $id) Return OperationLog objects filtered by the id column
 * @method array findBySiteUserId(string $site_user_id) Return OperationLog objects filtered by the site_user_id column
 * @method array findByModifyType(int $modify_type) Return OperationLog objects filtered by the modify_type column
 * @method array findByModifyTable(string $modify_table) Return OperationLog objects filtered by the modify_table column
 * @method array findByModifyColumn( $modify_column) Return OperationLog objects filtered by the modify_column column
 * @method array findByCreatedAt(string $created_at) Return OperationLog objects filtered by the created_at column
 * @method array findByUpdatedAt(string $updated_at) Return OperationLog objects filtered by the updated_at column
 */
abstract class BaseOperationLogQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseOperationLogQuery object.
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
            $modelName = 'Backend\\BaseBundle\\Model\\OperationLog';
        }
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new OperationLogQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   OperationLogQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return OperationLogQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof OperationLogQuery) {
            return $criteria;
        }
        $query = new OperationLogQuery(null, null, $modelAlias);

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
     * @return   OperationLog|OperationLog[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OperationLogPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(OperationLogPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 OperationLog A model object, or null if the key is not found
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
     * @return                 OperationLog A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT `id`, `site_user_id`, `modify_type`, `modify_table`, `modify_column`, `created_at`, `updated_at` FROM `operation_log` WHERE `id` = :p0';
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
            $obj = new OperationLog();
            $obj->hydrate($row);
            OperationLogPeer::addInstanceToPool($obj, (string) $key);
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
     * @return OperationLog|OperationLog[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|OperationLog[]|mixed the list of results, formatted by the current formatter
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
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OperationLogPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OperationLogPeer::ID, $keys, Criteria::IN);
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
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(OperationLogPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(OperationLogPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OperationLogPeer::ID, $id, $comparison);
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
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterBySiteUserId($siteUserId = null, $comparison = null)
    {
        if (is_array($siteUserId)) {
            $useMinMax = false;
            if (isset($siteUserId['min'])) {
                $this->addUsingAlias(OperationLogPeer::SITE_USER_ID, $siteUserId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($siteUserId['max'])) {
                $this->addUsingAlias(OperationLogPeer::SITE_USER_ID, $siteUserId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OperationLogPeer::SITE_USER_ID, $siteUserId, $comparison);
    }

    /**
     * Filter the query on the modify_type column
     *
     * @param     mixed $modifyType The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OperationLogQuery The current query, for fluid interface
     * @throws PropelException - if the value is not accepted by the enum.
     */
    public function filterByModifyType($modifyType = null, $comparison = null)
    {
        if (is_scalar($modifyType)) {
            $modifyType = OperationLogPeer::getSqlValueForEnum(OperationLogPeer::MODIFY_TYPE, $modifyType);
        } elseif (is_array($modifyType)) {
            $convertedValues = array();
            foreach ($modifyType as $value) {
                $convertedValues[] = OperationLogPeer::getSqlValueForEnum(OperationLogPeer::MODIFY_TYPE, $value);
            }
            $modifyType = $convertedValues;
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OperationLogPeer::MODIFY_TYPE, $modifyType, $comparison);
    }

    /**
     * Filter the query on the modify_table column
     *
     * Example usage:
     * <code>
     * $query->filterByModifyTable('fooValue');   // WHERE modify_table = 'fooValue'
     * $query->filterByModifyTable('%fooValue%'); // WHERE modify_table LIKE '%fooValue%'
     * </code>
     *
     * @param     string $modifyTable The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterByModifyTable($modifyTable = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($modifyTable)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $modifyTable)) {
                $modifyTable = str_replace('*', '%', $modifyTable);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OperationLogPeer::MODIFY_TABLE, $modifyTable, $comparison);
    }

    /**
     * Filter the query on the modify_column column
     *
     * @param     mixed $modifyColumn The value to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterByModifyColumn($modifyColumn = null, $comparison = null)
    {
        if (is_object($modifyColumn)) {
            $modifyColumn = serialize($modifyColumn);
        }

        return $this->addUsingAlias(OperationLogPeer::MODIFY_COLUMN, $modifyColumn, $comparison);
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
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterByCreatedAt($createdAt = null, $comparison = null)
    {
        if (is_array($createdAt)) {
            $useMinMax = false;
            if (isset($createdAt['min'])) {
                $this->addUsingAlias(OperationLogPeer::CREATED_AT, $createdAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($createdAt['max'])) {
                $this->addUsingAlias(OperationLogPeer::CREATED_AT, $createdAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OperationLogPeer::CREATED_AT, $createdAt, $comparison);
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
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function filterByUpdatedAt($updatedAt = null, $comparison = null)
    {
        if (is_array($updatedAt)) {
            $useMinMax = false;
            if (isset($updatedAt['min'])) {
                $this->addUsingAlias(OperationLogPeer::UPDATED_AT, $updatedAt['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($updatedAt['max'])) {
                $this->addUsingAlias(OperationLogPeer::UPDATED_AT, $updatedAt['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OperationLogPeer::UPDATED_AT, $updatedAt, $comparison);
    }

    /**
     * Filter the query by a related SiteUser object
     *
     * @param   SiteUser|PropelObjectCollection $siteUser The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 OperationLogQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySiteUser($siteUser, $comparison = null)
    {
        if ($siteUser instanceof SiteUser) {
            return $this
                ->addUsingAlias(OperationLogPeer::SITE_USER_ID, $siteUser->getId(), $comparison);
        } elseif ($siteUser instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OperationLogPeer::SITE_USER_ID, $siteUser->toKeyValue('PrimaryKey', 'Id'), $comparison);
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
     * @return OperationLogQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   OperationLog $operationLog Object to remove from the list of results
     *
     * @return OperationLogQuery The current query, for fluid interface
     */
    public function prune($operationLog = null)
    {
        if ($operationLog) {
            $this->addUsingAlias(OperationLogPeer::ID, $operationLog->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    // timestampable behavior

    /**
     * Filter by the latest updated
     *
     * @param      int $nbDays Maximum age of the latest update in days
     *
     * @return     OperationLogQuery The current query, for fluid interface
     */
    public function recentlyUpdated($nbDays = 7)
    {
        return $this->addUsingAlias(OperationLogPeer::UPDATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by update date desc
     *
     * @return     OperationLogQuery The current query, for fluid interface
     */
    public function lastUpdatedFirst()
    {
        return $this->addDescendingOrderByColumn(OperationLogPeer::UPDATED_AT);
    }

    /**
     * Order by update date asc
     *
     * @return     OperationLogQuery The current query, for fluid interface
     */
    public function firstUpdatedFirst()
    {
        return $this->addAscendingOrderByColumn(OperationLogPeer::UPDATED_AT);
    }

    /**
     * Filter by the latest created
     *
     * @param      int $nbDays Maximum age of in days
     *
     * @return     OperationLogQuery The current query, for fluid interface
     */
    public function recentlyCreated($nbDays = 7)
    {
        return $this->addUsingAlias(OperationLogPeer::CREATED_AT, time() - $nbDays * 24 * 60 * 60, Criteria::GREATER_EQUAL);
    }

    /**
     * Order by create date desc
     *
     * @return     OperationLogQuery The current query, for fluid interface
     */
    public function lastCreatedFirst()
    {
        return $this->addDescendingOrderByColumn(OperationLogPeer::CREATED_AT);
    }

    /**
     * Order by create date asc
     *
     * @return     OperationLogQuery The current query, for fluid interface
     */
    public function firstCreatedFirst()
    {
        return $this->addAscendingOrderByColumn(OperationLogPeer::CREATED_AT);
    }
}
