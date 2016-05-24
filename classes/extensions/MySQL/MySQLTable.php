<?php
/**
 * Abstract model of a MySQL table
 * 
 * To be implemented in children following operations that have multiple options for blueprints/execution-method/results-retrieval:
 * - select 
 *		blueprints: SQLTableSelectStatement/SQLTableSelectGroupStatement 
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: toValue/toColumn/toRow/toMap/toList
 * - insert
 *		blueprints: MySQLTableInsertStatement/MySQLTableInsertSelectStatement 
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows/getInsertId
 * - replace
 *		blueprints: MySQLTableReplaceStatement/MySQLTableReplaceSelectStatement 
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows
 * - update
 *		blueprints: MySQLTableUpdateStatement 
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows
 * - delete
 *		blueprints: MySQLTableDeleteStatement 
 *		execution method: DatabaseStatement/DatabasePreparedStatement
 *		results retrieval: getAffectedRows
 */
abstract class MySQLTable extends SQLTable {	
	/**
	 * Renames current table (and moves it to another database, if second parameter is supplied).
	 *
	 * @param 	string											$strNewTableName
	 * @param 	string											$strNewDatabaseName
	 */
	public function rename($strNewTableName, $strNewDatabaseName="") {
		$objQuery = new MySQLTableQuery($this->strSchemaName, $this->strTableName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->rename($strNewTableName, $strNewDatabaseName));
		$this->strTableName = $strNewTableName;
		if($strNewDatabaseName) $this->strSchemaName = $strNewDatabaseName;
	}
	
	/**
	 * Shows columns information for current table.
	 *
	 * Results contain rows with following keys:
	 * 		COLUMN_NAME					Column name
	 * 		COLUMN_DEFAULT				Column default value
	 * 		DATA_TYPE					Column data type
	 * 		CHARACTER_MAXIMUM_LENGTH	Maximum number of characters are accepted by column. (applies to string data types)
	 * 		NUMERIC_PRECISION			Maximum number of digits accepted by column. (applies to numeric data types)
	 * 		NUMERIC_SCALE				Maximum number of digits after decimal point. (applies to decimal types)
	 * 		IS_NULLABLE					Whether or not column accepts NULL entries.
	 * 		IS_PRIMARY					Whether or not column is PRIMARY KEY.
	 * 		IS_AUTO_INCREMENT			Whether or not numeric column has auto-incremented values
	 * 		IS_UNSIGNED					Whether or not numeric column accepts only positive values
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
				"IF(IS_NULLABLE='YES',1,0) AS IS_NULLABLE",
				"IF(COLUMN_KEY='PRI',1,0) AS IS_PRIMARY",
				"IF(EXTRA LIKE '%auto_increment%',1,0) AS IS_AUTO_INCREMENT",
				"IF(COLUMN_TYPE LIKE '%unsigned%',1,0) AS IS_UNSIGNED",
		)));
		$objSelectQuery->setWhere(new SQLWhereClause(array("TABLE_SCHEMA"=>$this->strSchemaName,"TABLE_NAME"=>$this->strTableName)));
		$objSelectQuery->setOrderBy(new SQLOrderByClause(array("ORDINAL_POSITION"=>"ASC")));
		return $this->objDatabaseConnection->createStatement()->execute($objSelectQuery->toString())->toList();
	}
}