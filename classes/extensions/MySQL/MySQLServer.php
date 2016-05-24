<?php
/**
 * Abstract model of a MySQL server. 
 */
abstract class MySQLServer extends SQLServer {	
	/**
	 * Gets list of processes running on server
	 * 
	 * @return array
	 */
	public function getProcesses() {
		$objQuery = new MySQLServerGetProcessesStatement();
		return $this->objDatabaseConnection->createStatement()->execute($objQuery->toString())->toList();
	}

	/**
	 * Kills a running process on server.
	 * 
	 * @param integer $intProcessId
	 */
	public function killProcess($intProcessId) {
		$objQuery = new MySQLServerKillProcessStatement();
		$objQuery->setProcessId($intProcessId);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}

	/**
	 * Sets system variable on server.
	 * 
	 * @param string $strSystemVariableName
	 * @param mixed $mixSystemVariableValue
	 * @param boolean $blnIsGlobalScope
	 */
	public function set($strSystemVariableName, $mixSystemVariableValue, $blnIsGlobalScope=false) {
		$objQuery = new MySQLServerSetStatement();
		$objQuery->setSelect($objSQLTableSelectStatement);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString());
	}
	
	/**
	 * Explains input SELECT statement.
	 * 
	 * @param string $strSQLTableSelectStatement
	 * @return array
	 */
	public function explain($strSQLTableSelectStatement) {
		$objQuery = new MySQLServerExplainStatement();
		$objQuery->setSelect($strSQLTableSelectStatement);
		$this->objDatabaseConnection->createStatement()->execute($objQuery->toString())->toList();
	}
}