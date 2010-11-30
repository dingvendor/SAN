<?php

class AccountController extends Zend_Controller_Action
{

	private $_db = null;
	private $_account = null;

	public function preDispatch()
    	{

	}
	public function init()
	{
        	/* Initialize action controller here */
                $bootstrap = $this->getInvokeArg('bootstrap');
                //var_dump($bootstrap);
                //die("bootstrap");
                $this->_db = $bootstrap->getResource('db');
		$this->_account = new models_Account();
	}

	public function indexAction()
	{
		// action body
	}

    public function loginAction()
    {
	// Title
        $this->view->headTitle()->append('Login');

        //	$db = $this->_getParam('db');
                	//var_dump($this); 		 
                        //$loginForm = new forms_Login(array('method' => 'post', 'action' => '/account/login'));
                 	$loginForm = $this->_account->getForm('Login',array('method' => 'post', 'action' => '/account/login'));
		
                        if ($loginForm->isValid($this->_request->getParams())) {
                 		$result = $this->_account->login($loginForm->getValue('username'), $loginForm->getValue('passwd'));

				if($result)
				{
					$this->_helper->FlashMessenger('Successful Login');
        	                        $this->_helper->redirector('index','my');
	                                return;
				}
                        }
                 
                        $this->view->loginForm = $loginForm;
			//$this->view->registerForm = new forms_Register(array('method' => 'post', 'action' => '/account/register'));
			$this->view->registerForm = $this->_account->getForm('Register', array('method' => 'post', 'action' => '/account/register'));
    }


    public function registerAction()
    {
        // Set Page Title
                	$this->view->headTitle("Register New  Account");
                        // action body
                	if($this->_request->isPost())
                	{
				$data = $this->_request->getParams();
				// Sanitise Data
				/**
   				 * @TODO Santise data input
				 */
				$cleanData = $data;
				// print_r($cleanData);
				// Pass to model
				
				if($this->_account->existsByEmail($cleanData['email']))
				{
					$this->_redirect('error','error');
	
				}
				$this->_account->register($cleanData);
				// Check if user exists in list

				// If not, show second registration form if OP == 2
				//$this->view->registerFrom = $this->_account->getForm('Register2',  array('method' => 'post', 'action' => '/account/register'));
                		
                	}
                	
///                		$this->view->registerForm = new forms_Register();
	 $this->view->registerForm = $this->_account->getForm('Register', array('method' => 'post', 'action' => '/account/register'));
		
    }

	public function validateAction()
	{
		if($this->_request->isPost())
		{
			// var_dump($this->_request->getParams());
			$this->_account->completeRegistration($this->_request->getParams());
			$this->_helper->viewRenderer('complete');
		}
		else
		{
		// Title
	        $this->view->headTitle()->append('Validate Account');
		$id  = $this->_request->getParam('id');
		$valstr = $this->_request->getParam('val');
		$this->view->result = $this->_account->validateRegistration($id, $valstr);
		//$this->view->form = new forms_ValidateRegistration(null, $var);	
		}
	}

    public function logoutAction()
    {
        // action body
	Zend_Auth::getInstance()->clearIdentity();
	//die("identity cleared");
	$auth = Zend_Auth::getInstance();
	if($auth->hasIdentity())
	{
		$auth->clearIdentity();
	}
	$this->_helper->FlashMessenger('You are now logged out');
	$this->_redirect('/');
    }

	public function usernameAction()
	{
		$db=Zend_Registry::get('db');
		$name = $this->_request->getParam('username',''); //Default to null
		$sql = $db->quoteInto('SELECT username FROM account WHERE username=?',$name);
		$result = $db->fetchAll($sql);
		
		// var_dump($result);

		if(null != $result)
		{	
			$result = array('<span style="color: red;">The username <b>'.$result[0]['username'].'</b> is already in 
use.</span>');
		}
		else
		{
			$result = array('OK');
		}

		$this->_helper->autoComplete($result);
	}
}
