<?php

class GamesController extends Zend_Controller_Action
{
	
        public function preDispatch()
        {

	}

	public function init()
	{
		$this->view->headTitle()->append('Games');
	}
	
	public function indexAction()
	{
		$gamelist = new models_GameList();

		$this->view->groups = $gamelist->fetchGroups();
	}

	public function typeAction()
	{
		$is = $this->_request->getParam('is', null);

		if(null != $is)
		{
			$gamelist = new models_GameList();

			$this->view->games = $gamelist->fetchAllByType($is);
		}

	}

	public function classAction()
	{
	
	}

	public function listAction()
	{
		$id = $this->_request->getParam('group', null);

		$game_list = new models_GameList();
		
		if(null != $id)
		{
			$this->view->games = $game_list->fetchAllByGroup($id);
		}
		else
		{
			$this->view->games = $game_list->fetchAll();
		}
	}

	public function showAction()
	{
		$id = $this->_getParam('id');
		
		$this->view->game = new models_Game($id);
		
		$this->view->headTitle()->append($this->view->game->name);
	}
}
