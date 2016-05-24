<?php
/**
 * Implementation of a single class for all MySQL tables
 */
class GenericMySQLTable extends MySQLTable {
	public function __construct($strServerName, $strSchemaName, $strTableName) {
		$this->strSchemaName = $strSchemaName;
		$this->strTableName = $strTableName;
		$this->objDatabaseConnection = DatabaseConnectionManager::getConnection($strServerName);
	}
}