<?php
/**
 * Abstract model of a MySQL schema. 
 */
abstract class MySQLSchema extends SQLSchema {
	/**
	 * Selects/uses current database.
	 */
	public function select() {
		$objQuery = new MySQLSchemaSelectStatement($this->strSchemaName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
}