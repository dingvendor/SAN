<?php 

class plugin_Auth extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $loginController = 'account';
        $loginAction     = 'login';

        $auth = Zend_Auth::getInstance();

        // If user is not logged in and is not requesting login page
        // - redirect to login page.
	/*
        if (!$auth->hasIdentity()
                && $request->getControllerName() != $loginController
                && $request->getActionName()     != $loginAction) {
		//die("no identity");
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
            $redirector->gotoSimpleAndExit($loginAction, $loginController);
        }*/

        // We run this if the user is trying to get to the admin page
	if($request->getModuleName() == 'admin')
	{
		/**
		 * @TODO Check for correct role
		 *
		 */
		if(!$auth->hasIdentity())
		{
			$redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
		        $redirector->gotoSimpleAndExit($loginAction, $loginController, 'default');
		}

		
	}

	/*
        if ($auth->hasIdentity()) {
		//die("identity");
            // Is logged in
            // Let's check the credential
            $registry = Zend_Registry::getInstance();
            $acl = $registry->get('acl');
            $identity = $auth->getIdentity();
            // role is a column in the user table (database)
	    $identity->role = 'admin';
            $isAllowed = $acl->isAllowed($identity->role,
                                         $request->getControllerName(),
                                         $request->getActionName());
            if (!$isAllowed) {
                $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('Redirector');
                $redirector->gotoUrlAndExit('/account/login');
            }
        }
	*/
    }
}
