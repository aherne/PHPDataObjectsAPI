<?php
/**
 * Implementation of a prototype for a MySQL server model. All individual MySQL server model classes must extend it and override:
 * - strServerName
 */
abstract class MySQLServerModel extends MySQLServer {
	protected $strServerName;

	public function __construct() {
		if(!$this->strServerName) throw new SQLDataObjectException("'strServerName' must be filled by class that extends AbstractMySQLServer!");
		$this->objDatabaseConnection =  DatabaseConnectionManager::getConnection($this->strServerName);
	}
}

/**
 * SERVER MODEL IMPLEMENTATION EXAMPLE:
 * 
 * final class ActualMySQLServerModel extends MySQLServerModel {
 *  protected $strServerName="myActualServerName";
 * }
 */