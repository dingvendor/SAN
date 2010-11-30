<?php

/**
 * ProfileLink helper
 *
 * Call as $this->profileLink() in your layout script
 */
class Zend_View_Helper_ProfileLink extends Zend_View_Helper_Abstract
{
    public $view;

    public function setView(Zend_View_Interface $view)
    {
        $this->view = $view;
    }

    public function profileLink()
    {
        
	$auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            //$username = $auth->getIdentity()->username;
            return '<a href="/my/">Welcome, ' . $auth->getIdentity() .  '</a> - <a href="/account">Edit Account</a>';
        } 
	
        return '<a href="/account/login">Login</a>';
    }
}
