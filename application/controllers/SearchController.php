<?php

class SearchController extends Zend_Controller_Action {
	private $_db;
	private $_search;
	public function init()
    	{
        	/* Initialize action controller here */
                $bootstrap = $this->getInvokeArg('bootstrap');
                $this->_db = Zend_Registry::get('db');
                $this->_search = new models_Search();
    	}
	
	/**
         * Carries out the search
	 *
	 */
	public function indexAction()
	{
		$form = $this->_search->getForm('Search');

                $this->view->form = $form;

		if($this->_request->isPost())
		{
			$params = $this->_request->getParams();
		//print_r($params);
		/**
		 * @TODO Sanitise input
		 */
		if(!empty($params['query']))
		{
			$this->_search->doSearch($params);
			$this->view->results = $this->_search->getResults();
			
		}
			else
			{
				/**
				 * @TODO Fix this die()
				 */
				die("No param!");
			}
	
		}
	}
}
