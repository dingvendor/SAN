<?php

class models_GameList {
	private $_games;

	/**
	 * Generates a list of all the games in the database
	 *
	 */
	public function fetchAll()
	{
		$db = Zend_Registry::get('db');
		$stmt = $db->query("SELECT id FROM game ORDER BY sorder ASC;"); // Order by group then sorder
		$result = $stmt->fetchAll();
		
		foreach($result as $r)
		{
			$this->_games[] = new model_Game($r['id']);
		}

		return $this->_games;
	}

	public function fetchGroups()
	{
		$db = Zend_Registry::get('db');

		$select = $db->select()
				->from('game_group', '*')
				->order('sorder ASC');

		$stmt = $select->query();
		
		return $stmt->fetchAll();
	}

	/**
	 * Gets all games within a specific groupid
	 * @param $groupid integer
	 *
	 */
	public function fetchAllByGroup($groupid)
	{
		$db = Zend_Registry::get('db');
                // $stmt = $db->query("SELECT id FROM game WHERE group = ? ORDER BY sorder ASC;", $groupid); // Order by group then sorder
		
		$select = $db->select()
                                ->from('game', 'id')
                                ->where('`group` = ?', $groupid)
				->order('sorder ASC');

	// 	die($select->__toString());
		$stmt = $select->query();
	
                $result = $stmt->fetchAll();

                foreach($result as $r)
                {
                        $this->_games[] = new model_Game($r['id']);
                }

                return $this->_games;
		
	}
	
	public function fetchAllByType($type)
	{
		$game = array();
		$db = Zend_Registry::get('db');
                //$stmt = $db->query("SELECT id FROM game WHERE simtype=? ORDER BY sorder ASC;", $type);
		//die($stmt->__toString());

		$select = $db->select()
				->from('game', 'id')
				->where('simtype = ?', $type);
		//die($select->__toString());
                $stmt = $select->query();

		$result = $stmt->fetchAll();

		foreach($result as $r)
		{
			$game[] = new model_Game($r['id']);
		}

		return $game;
	}

	
	/**
	 * Generate info for Zend Search Lucene
	 *
	 */
	public function buildIndex()
	{
		// Select all games
		$results = $this->fetchAll();

		foreach($results as $result)
		{
			$data[] = $result->toSearchIndex();
		}
		// Select all group

		return $data;
	}
}
