<?php
/**
 * Abstract model of an SQL table. 
 * 
 * To be implemented in children following operations that have multiple options for blueprints/execution-method/results-retrieval:
 * - select 
 *		statements: SQLTableSelectStatement/SQLTableSelectGroupStatement
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: toValue/toColumn/toRow/toMap/toList
 * - insert
 *		statements: SQLTableInsertStatement/SQLTableInsertSelectStatement 
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows/getInsertId
 * - update
 *		statements: SQLTableUpdateStatement
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows
 * - delete
 *		statements: SQLTableDeleteStatement
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows
 */
abstract class SQLTable {
	/**
	 * Table name. To be overridden by children.
	 * 
	 * @var	string												$strTableName
	 */
	protected $strTableName;
	
	/**
	 * Database name. To be overridden by children.
	 * 
	 * @var string 												$strSchemaName
	 */
	protected $strSchemaName;

	/**
	 * SQL server connection to to run queries on. To be instanced by children.
	 *
	 * @see DataAccessAPI::DatabaseConnection
	 * @var DatabaseConnection $objDatabaseConnection
	 */
	protected $objDatabaseConnection;
	
	/**
	 * Empties current table of rows and resets autoincremented key, if applicable.
	 */
	public function truncate() {
		$objQuery = new SQLTableTruncateStatement($this->strSchemaName, $this->strTableName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
	
	/**
	 * Drops current table.
	*/
	public function drop() {
		$objQuery = new SQLTableDropStatement($this->strSchemaName.".".$this->strTableName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
	
	/**
	 * Shows all columns information.
	 *
	 * @return	array
	 */
	public function getColumns() {
		$objSelectQuery = new SQLTableSelectStatement("INFORMATION_SCHEMA.COLUMNS");
		$objSelectQuery->setColumns(new SQLColumnsClause(array(
				"COLUMN_NAME",
				"COLUMN_DEFAULT",
				"DATA_TYPE",
				"CHARACTER_MAXIMUM_LENGTH",
				"NUMERIC_PRECISION",
				"NUMERIC_SCALE",
				"IF(IS_NULLABLE='YES',1,0) AS IS_NULLABLE"
		)));
		$objSelectQuery->setWhere(new SQLWhereClause(array("TABLE_SCHEMA"=>$this->strSchemaName,"TABLE_NAME"=>$this->strTableName)));
		$objSelectQuery->setOrderBy(new SQLOrderByClause(array("ORDINAL_POSITION"=>"ASC")));
		return $this->objDatabaseConnection->createStatement()->execute($objSelectQuery->toString())->toList();
	}
}