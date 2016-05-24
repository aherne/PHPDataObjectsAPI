<?php
/**
 * Abstract model of an SQL schema. 
 */
abstract class SQLSchema {
	
	/**
	 * Schema name. To be overridden by actual table model children.
	 * 
	 * @var string $strSchemaName
	 */
	protected $strSchemaName;
	

	/**
	 * SQL server connection to to run queries on.
	 * 
	 * @see DataAccessAPI::DatabaseConnection
	 * @var DatabaseConnection $objDatabaseConnection
	 */
	protected $objDatabaseConnection;
	
	/**
	 * Gets tables in current schema.
	 * 
	 * @return string[]
	 */
	public function getTables() {
		$objSelectQuery = new SQLTableSelectStatement("INFORMATION_SCHEMA.TABLES");
		$objSelectQuery->setColumns(new SQLColumnsClause(array("TABLE_NAME")));
		$objSelectQuery->setWhere(new SQLWhereClause(array("TABLE_SCHEMA"=>$this->strSchemaName,"TABLE_TYPE"=>"BASE TABLE")));
		return $this->objDatabaseConnection->createStatement()->execute($objSelectQuery->toString())->toColumn();
	}
	
	/**
	 * Creates current schema
	 */
	public function create() {
		$objQuery = new SQLSchemaCreateStatement($this->strSchemaName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}	
	
	/**
	 * Drops current schema.
	 */
	public function drop() {
		$objQuery = new SQLSchemaDropStatement($this->strSchemaName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
}