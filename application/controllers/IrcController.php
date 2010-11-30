<?php

class IrcController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // Title
	$this->view->headTitle()->append('IRC Client');
    }


}

