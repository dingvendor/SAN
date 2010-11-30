<?php

class Admin_CoreController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
	$auth = Zend_Auth::getInstance();
 	if (!$auth->hasIdentity() || ($auth->getIdentity()->role != 'admin')) {
                $this->_helper->redirector('index', 'index', 'default');
        }

    }

}

