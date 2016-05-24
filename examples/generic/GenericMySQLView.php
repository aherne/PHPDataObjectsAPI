<?php
/**
 * Implementation of a single class for all MySQL views
 */
class GenericMySQLView extends SqlView {
	public function __construct($strServerName, $strViewName) {
		$this->strViewName = $strViewName;
		$this->objDatabaseConnection = DatabaseConnectionManager::getConnection($strServerName);
	}
}