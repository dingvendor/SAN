<?php
require_once('markdown.php');

class JoinController extends Zend_Controller_Action
{
        /**
         *
         * @var models_Application
         */
	private $_application;
	
    public function init()
    {
        /* Initialize action controller here */
	$this->_application = new models_Application();
    }

    public function indexAction()
    {
        // Title
	$this->view->headTitle()->append('What do you want to be?');

	// action body
	// $core = new models_Core();

	// $this->view->statistics = $core->getStatistics();
    }

	public function playerAction()
	{
		$this->view->headTitle()->append('Player application');
		$form = $this->_application->getForm('PlayerApplication');

                if($this->_request->isPost())
                {
                        $params = $this->_request->getParams();

                        $application = new models_Application();
                        $result = $application->player($params['application'], $params['biography'], $params['game']);
                        
                    var_dump($this->_request->getParams());
                }

                $this->view->form = $form;
	}

	public function gamemasterAction()
	{
            $this->view->headTitle()->append('Game Master Application Form');
            $this->view->form = $this->_character->getForm('GameMasterApplication');
  
	}


}

