<?php

namespace Backend\BaseBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'site_user_group' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.src.Backend.BaseBundle.Model.map
 */
class SiteUserGroupTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Backend.BaseBundle.Model.map.SiteUserGroupTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('site_user_group');
        $this->setPhpName('SiteUserGroup');
        $this->setClassname('Backend\\BaseBundle\\Model\\SiteUserGroup');
        $this->setPackage('src.Backend.BaseBundle.Model');
        $this->setUseIdGenerator(false);
        $this->setIsCrossRef(true);
        // columns
        $this->addForeignPrimaryKey('site_user_id', 'SiteUserId', 'BIGINT' , 'site_user', 'id', true, null, null);
        $this->addForeignPrimaryKey('site_group_id', 'SiteGroupId', 'BIGINT' , 'site_group', 'id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SiteUser', 'Backend\\BaseBundle\\Model\\SiteUser', RelationMap::MANY_TO_ONE, array('site_user_id' => 'id', ), null, null);
        $this->addRelation('SiteGroup', 'Backend\\BaseBundle\\Model\\SiteGroup', RelationMap::MANY_TO_ONE, array('site_group_id' => 'id', ), null, null);
    } // buildRelations()

} // SiteUserGroupTableMap
