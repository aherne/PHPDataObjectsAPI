<?php
/**
 * Abstract model of an SQL server. 
 */
abstract class SQLServer {	
	/**
	 * SQL server connection to to run queries on.
	 * 
	 * @see DataAccessAPI::DatabaseConnection
	 * @var DatabaseConnection $objDatabaseConnection
	 */
	protected $objDatabaseConnection;
	
	/**
	 * Gets schemas on server.
	 * 
	 * @return string[]
	 */
	public function getSchemas() {
		$objSelectQuery = new SQLTableSelectStatement("INFORMATION_SCHEMA.SCHEMATA");
		$objSelectQuery->setColumns(new SQLColumnsClause(array("SCHEMA_NAME")));
		$objSelectQuery->setOrderBy(new SQLOrderByClause(array("SCHEMA_NAME"=>"ASC")));		
		return $this->objDatabaseConnection->createStatement()->execute($objSelectQuery->toString())->toColumn();
	}
	
	/**
	 * Delegates to DatabaseTransaction to run transactional operations. 
	 */
	public function getTransaction() {
		return $this->objDatabaseConnection->transaction();
	}
}