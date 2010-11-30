<?php

/**
 * Core SGMS functionality
 *
 */
class models_Core {
	function __contruct()
	{
		
	}
	
	/** 
	 * Returns statitics about the site.
         *
         * @return statitics array
         */
	public function getStatistics()
	{
		$db = Zend_Registry::get('db');
		// Get Gamnes
		$numGames = $db->query('SELECT count(id) AS numgames FROM game;')->fetchObject();
		$numAccounts = $db->query('SELECT count(id) AS numaccounts FROM account WHERE confirmed=1;')->fetchObject();
		//print_r($numGames);
	
		return array('games' => $numGames->numgames, 'accounts' => $numAccounts->numaccounts, 'characters' => 'N/A');
	}
}
