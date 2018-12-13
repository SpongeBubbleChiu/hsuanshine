<?php

namespace Backend\BaseBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'site_user' table.
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
class SiteUserTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Backend.BaseBundle.Model.map.SiteUserTableMap';

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
        $this->setName('site_user');
        $this->setPhpName('SiteUser');
        $this->setClassname('Backend\\BaseBundle\\Model\\SiteUser');
        $this->setPackage('src.Backend.BaseBundle.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addColumn('login_name', 'LoginName', 'VARCHAR', true, 128, null);
        $this->getColumn('login_name', false)->setPrimaryString(true);
        $this->addColumn('first_name', 'FirstName', 'VARCHAR', false, 128, null);
        $this->addColumn('last_name', 'LastName', 'VARCHAR', false, 128, null);
        $this->addColumn('email', 'Email', 'VARCHAR', true, 128, null);
        $this->addColumn('password', 'Password', 'VARCHAR', false, 128, null);
        $this->addColumn('salt', 'Salt', 'VARCHAR', false, 128, null);
        $this->addColumn('enabled', 'Enabled', 'BOOLEAN', true, 1, true);
        $this->addColumn('confirm_token', 'ConfirmToken', 'VARCHAR', false, 64, null);
        $this->addColumn('password_expired_at', 'PasswordExpiredAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('token_expired_at', 'TokenExpiredAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('default_roles', 'DefaultRoles', 'ARRAY', false, null, null);
        $this->addColumn('custom_roles', 'CustomRoles', 'ARRAY', false, null, null);
        $this->addColumn('last_login', 'LastLogin', 'TIMESTAMP', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('OperationLog', 'Backend\\BaseBundle\\Model\\OperationLog', RelationMap::ONE_TO_MANY, array('id' => 'site_user_id', ), null, null, 'OperationLogs');
        $this->addRelation('SiteUserGroup', 'Backend\\BaseBundle\\Model\\SiteUserGroup', RelationMap::ONE_TO_MANY, array('id' => 'site_user_id', ), null, null, 'SiteUserGroups');
        $this->addRelation('StockLog', 'Widget\\StockBundle\\Model\\StockLog', RelationMap::ONE_TO_MANY, array('id' => 'site_user_id', ), null, null, 'StockLogs');
        $this->addRelation('StockStyleLog', 'Widget\\StockBundle\\Model\\StockStyleLog', RelationMap::ONE_TO_MANY, array('id' => 'site_user_id', ), null, null, 'StockStyleLogs');
        $this->addRelation('SiteGroup', 'Backend\\BaseBundle\\Model\\SiteGroup', RelationMap::MANY_TO_MANY, array(), null, null, 'SiteGroups');
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

} // SiteUserTableMap
