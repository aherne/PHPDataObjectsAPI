<?php
/**
 * Implementation of a prototype for a SQL view model. All individual SQL view model classes must extend it and override:
 * - strSchemaName
 * - strServerName
 */
abstract class MySQLViewModel extends SQLView {
	protected $strServerName;
	
	public function __construct() {
		if(!$this->strViewName || !$this->strServerName) throw new SQLDataObjectException("Both 'strViewName' and 'strServerName' must be filled by class that extends AbstractMySQLSchema!");
		$this->objDatabaseConnection = DatabaseConnectionManager::getConnection($this->strServerName);
	}
}


/**
 * VIEW MODEL IMPLEMENTATION EXAMPLE:
 *
 * final class ActualMySQLViewModel extends MySQLViewModel {
 * 	protected $strSchemaName="myActualSchema";
 *  protected $strServerName="myActualServerName";
 * }
 */