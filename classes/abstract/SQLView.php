<?php
/**
 * Abstract model of an SQL view.
 * NOTE: create and alter operations, even though logically one/view, rely on clause-based statements, thus do not follow a predefined execution plan
 * (which means they should be implemented in a single version (with same name) per child).
 */
abstract class SQLView {
	
	/**
	 * View name. To be overridden by actual table model children.
	 * 
	 * @var string $strViewName
	 */
	protected $strViewName;

	/**
	 * SQL server connection to to run queries on.
	 *
	 * @see DataAccessAPI::DatabaseConnection
	 * @var DatabaseConnection $objDatabaseConnection
	 */
	protected $objDatabaseConnection;
	

	/**
	 * Creates view.
	 *
	 * @param string $strSQLTableSelectStatement
	 */
	public function create($strSQLTableSelectStatement) {
		$objQuery = new SQLViewCreateStatement($this->strViewName);
		$objQuery->setSelect($strSQLTableSelectStatement);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}

	/**
	 * Alters current view.
	 *
	 * @param string $strSQLTableSelectStatement
	 */
	public function alter($strSQLTableSelectStatement) {
		$objQuery = new SQLViewAlterStatement($this->strViewName);
		$objQuery->setSelect($strSQLTableSelectStatement);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
	
	/**
	 * Drops current view
	 */
	public function drop() {
		$objQuery = new SQLViewDropStatement($this->strViewName);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
}