<?php
/**
 * Implementation of a single class for all MySQL schemas
 */
class GenericMySQLSchema extends MySQLSchema {
	public function __construct($strServerName, $strSchemaName) {
		$this->strSchemaName = $strSchemaName;
		$this->objDatabaseConnection = DatabaseConnectionManager::getConnection($strServerName);
	}
}