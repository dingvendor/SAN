<?php

class models_Acl extends Zend_Acl{
	private $_acl;
	
	function __construct()
	{
		
		//$this->_acl = new Zend_Acl();

		// $roles  = array('admin', 'gamemaster','user', 'guest');

		// Controller script names. You have to add all of them if credential check
		// is global to your application.
		$controllers = array('account', 'index', 'news', 'adminpanel');

		$this->addRole(new Zend_Acl_Role('guest'));
		$this->addRole(new Zend_Acl_Role('user', 'guest'));
		$this->addRole(new Zend_Acl_Role('gamemaster', 'user'));
		$this->addRole(new Zend_Acl_Role('admin', 'gamemaster'));

		foreach ($controllers as $controller) {
			$this->add(new Zend_Acl_Resource($controller));
		}	

		// Here comes credential definiton for admin user.
		$this->allow('admin'); // Has access to everything.

		// Here comes credential definition for normal user.
		$this->allow('user'); // Has access to everything...
		$this->deny('user', 'adminpanel'); // ... except the admin controller.
		
		// Guest
		$this->allow('guest'); // Has access to everything...
                $this->deny('guest', 'adminpanel'); // ... except the admin controller.

// Finally I store whole ACL definition to registry for use
// in AuthPlugin plugin.
// $registry = Zend_Registry::getInstance();
// $registry->set('acl', $acl);
//Another case is if you want to allow normal user only "list" action on all your controllers. It's pretty simple, you'd add line like this:

//$acl->allow('normal', null, 'list'); // Has access to all controller list actions.

	}

	
}
