<?php
/**
 * Implementation of a single class for all MySQL servers
 */
class GenericMySQLServer extends MySQLServer {
	public function __construct($strServerName) {
		$this->objDatabaseConnection = DatabaseConnectionManager::getConnection($strServerName);
	}
}