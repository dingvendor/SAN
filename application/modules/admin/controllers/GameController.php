<?php

class Admin_GameController extends Admin_CoreController
{

    public function init()
    {
        /* Initialize action controller here */
 	if (!Zend_Auth::getInstance()->hasIdentity()) {
                $this->_helper->redirector('index', 'index', 'default');
        }
        //else {
            // If they aren't, they can't logout, so that action should
            // redirect to the login form
            //if ('logout' == $this->getRequest()->getActionName()) {
            //    $this->_helper->redirector('index');
            //}
        //}

    }

    public function indexAction()
    {
        // action body
    }

	public function addAction()
	{
		
	}

	public function deleteAction()
	{

	}

	public function editAction()
	{

	}
}
