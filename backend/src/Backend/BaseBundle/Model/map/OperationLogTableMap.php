<?php

namespace Backend\BaseBundle\Model\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'operation_log' table.
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
class OperationLogTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'src.Backend.BaseBundle.Model.map.OperationLogTableMap';

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
        $this->setName('operation_log');
        $this->setPhpName('OperationLog');
        $this->setClassname('Backend\\BaseBundle\\Model\\OperationLog');
        $this->setPackage('src.Backend.BaseBundle.Model');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addForeignKey('site_user_id', 'SiteUserId', 'BIGINT', 'site_user', 'id', true, null, null);
        $this->addColumn('modify_type', 'ModifyType', 'ENUM', true, null, null);
        $this->getColumn('modify_type', false)->setValueSet(array (
  0 => 'new',
  1 => 'update',
  2 => 'delete',
  3 => 'login',
));
        $this->addColumn('modify_table', 'ModifyTable', 'VARCHAR', false, 128, null);
        $this->addColumn('modify_column', 'ModifyColumn', 'OBJECT', false, null, null);
        $this->addColumn('created_at', 'CreatedAt', 'TIMESTAMP', false, null, null);
        $this->addColumn('updated_at', 'UpdatedAt', 'TIMESTAMP', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('SiteUser', 'Backend\\BaseBundle\\Model\\SiteUser', RelationMap::MANY_TO_ONE, array('site_user_id' => 'id', ), null, null);
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

} // OperationLogTableMap
