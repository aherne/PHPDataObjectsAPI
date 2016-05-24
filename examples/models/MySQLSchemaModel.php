<?php
/**
 * Implementation of a prototype for a MySQL schema model. All individual MySQL schema model classes must extend it and override:
 * - strSchemaName
 * - strServerName
 */
abstract class MySQLSchemaModel extends MySQLSchema {
	protected $strServerName;
	
	public function __construct() {
		if(!$this->strSchemaName || !$this->strServerName) throw new SQLDataObjectException("Both 'strSchemaName' and 'strServerName' must be filled by class that extends AbstractMySQLSchema!");
		$this->objDatabaseConnection =  DatabaseConnectionManager::getConnection(self::SERVER);
	}
} 

/**
 * SCHEMA MODEL IMPLEMENTATION EXAMPLE:
 * 
 * final class ActualMySQLSchemaModel extends MySQLSchemaModel {
 * 	protected $strSchemaName="myActualSchema";
 *  protected $strServerName="myActualServerName";
 * }
 */