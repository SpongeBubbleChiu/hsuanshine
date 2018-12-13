<?php

namespace Backend\BaseBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'site_group' table.
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
class SiteGroupTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Backend.BaseBundle.Model.map.SiteGroupTableMap';

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
        $this->setName('site_group');
        $this->setPhpName('SiteGroup');
        $this->setClassname('Backend\\BaseBundle\\Model\\SiteGroup');
        $this->setPackage('src.Backend.BaseBundle.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 128, null);
        $this->getColumn('name', false)->setPrimaryString(true);
        $this->addColumn('default_roles', 'DefaultRoles', 'ARRAY', false, null, null);
        $this->addColumn('custom_roles', 'CustomRoles', 'ARRAY', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SiteUserGroup', 'Backend\\BaseBundle\\Model\\SiteUserGroup', RelationMap::ONE_TO_MANY, array('id' => 'site_group_id', ), null, null, 'SiteUserGroups');
        $this->addRelation('SiteUser', 'Backend\\BaseBundle\\Model\\SiteUser', RelationMap::MANY_TO_MANY, array(), null, null, 'SiteUsers');
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' =>  array (
  'create_column' => 'created_at',
  'update_column' => 'updated_at',
  'disable_updated_at' => 'false',
),
            'addrandompk' =>  array (
),
        );
    } // getBehaviors()

} // SiteGroupTableMap
