<?php
/**
 * This model controls the search features of the site
 *
 */
class models_Search {
	private $_forms;
	private $_results;
	 /***
         * @param name form name to get
         */
        public function getForm($name, $options = null)
        {
                $form = 'forms_'.$name;
                $this->forms[$name] = new $form($options);
                return $this->forms[$name];

        }

	/**
	 * Carries out a search
	 * returns 1 if results are found 0 if not.
	 *
	 * @return result int
	 *
	 */
	public function doSearch($data)
	{
		 $config = Zend_Registry::get('config');

                $index = Zend_Search_Lucene::open($config->searchindex);
		$this->_results = $index->find($data['query']);
	}

	/**
	 * Returns the results from lucene
	 *
	 * @return results
	 */
	public function getResults()
	{
		return $this->_results;
	}

	/**
	 * Rebuild the search index **Warning** this is destructive.
	 *
	 */
	public function buildIndex()
	{
		$config = Zend_Registry::get('config');

		$index = Zend_Search_Lucene::create($config->searchindex);

		// Temp for now
		$doc = new Zend_Search_Lucene_Document();
 
		// Store document URL to identify it in the search results
		$doc->addField(Zend_Search_Lucene_Field::Text('url', 'http://www.arkroyal.org'));
 
		// Index document contents
		$doc->addField(Zend_Search_Lucene_Field::UnStored('contents', 'This is the SGMS website'));
 
		// Add document to the index
		$index->addDocument($doc);

		$gameList = new model_GameList();
		$gameData = $gameList->buildIndex();
		foreach($gameData as $data)
		{
			var_dump($data);
			$doc = new Zend_Search_Lucene_Document();
 
			// Store document URL to identify it in the search results
			$doc->addField(Zend_Search_Lucene_Field::UnIndexed('url', $data['pageurl']));
 
			// Index document title
			$doc->addField(Zend_Search_Lucene_Field::Text('name', $data['name']));
 
			// Add document to the index
			$index->addDocument($doc);
		}
	}

	/**
	 * Updates an item in the search index
	 *
	 */
	public function updateIndex()
	{

	}
}
