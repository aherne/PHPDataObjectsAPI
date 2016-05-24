<?php
/**
 * Implementation of a prototype for a MySQL table model. All individual MySQL table model classes must extend it and override:
 * - strServerName
 * - strSchemaName
 * - strTableName
 */
abstract class MySQLTableModel extends MySQLTable {
	protected $strServerName;

	public function __construct() {
		if(!$this->strTableName || !$this->strSchemaName || !$this->strServerName) throw new SQLDataObjectException("'strSchemaName', 'strTableName' and 'strServerName' must be filled by class that extends AbstractMySQLTable!");
		$this->objDatabaseConnection =  DatabaseConnectionManager::getConnection($this->strServerName);
	}
}

/**
 * TABLE MODEL IMPLEMENTATION EXAMPLE:
 * 
 * final class ActualMySQLTableModel extends MySQLTableModel {
 * 	protected $strSchemaName	="actualSchemaName";
 *  protected $strTableName		="actualTableName";
 *  protected $strServerName	="actualServerName";
 * }
 */