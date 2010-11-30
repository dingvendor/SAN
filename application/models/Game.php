<?php
require_once('markdown.php');

class models_Game {
	// private $_data;
	
	/**
         * Creates a new instance of the game class.
	 * If $gameid is set it attempts to populate
	 * the class with data.
	 *
	 * @param $gameid integer
	 */
	function __construct($gameid = null)
	{
		if(isset($gameid))
		{
			$db = Zend_Registry::get('db');
			$stmt = $db->query("SELECT g.id, g.name, g.image, g.url, g.gm, g. simtype, c.name AS shiptype, g.sorder, g.flavour FROM game AS g, registry_class AS c  WHERE g.id=?
					    AND c.id=g.shiptype", $gameid);
			//$this->_data = $stmt->fetchObject();
			$result = $stmt->fetchObject();
			// print_r($result);
			$this->id = $result->id;
			$this->name = $result->name;
			if(null != $result->image)
			{
				$this->image = $result->image;
			}
			else
			{
				$this->image = "pending.png";
			}
			$this->url = $result->url;
			$this->sorder = $result->sorder;
			$this->simtype = $result->simtype;
			$this->shiptype = $result->shiptype;
			$this->flavour = $result->flavour;
			$this->flavour_markdown = Markdown($result->flavour);
			//return $this;
		}
		//print_r($this->_data);
		return $this;
	}
		
	public function toSearchIndex()
	{
		$indexData['pageurl'] = "/game/show/id/".$this->id;
		// $indexData['title'] = $this->title;
		$indexData['name'] = $this->name;
		$indexData['url'] = $this->url;
		
		return $indexData;
	}

}
