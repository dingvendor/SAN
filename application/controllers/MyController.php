<?php

class MyController extends Zend_Controller_Action
{
	private $_account;

	public function preDispatch()
	{ 
		$auth = Zend_Auth::getInstance();
		if(!$auth->hasIdentity())
		{
			$this->_helper->redirector('login', 'account', 'default');	
		}
		$this->_account = new models_Account();

		//$this->view->messages = $this->_flashMessenger->getMessages();
	}

	public function init()
	{
        	/* Initialize action controller here */
		$this->_flashMessenger = $this->_helper->getHelper('FlashMessenger');
		$this->initView();

		$this->view->messages = $this->_flashMessenger->getMessages();
	}

	public function indexAction()
	{
		$auth = Zend_Auth::getInstance();
		$identity = $auth->getIdentity();
        	// action body
		//$this->view->username = $identity;
		//var_dump($identity);
		$this->view->messages = $this->_flashMessenger->getMessages();
	}

	public function modifyAction()
	{
		// $this->view->jQuery()->enable();
                $this->view->usernameform = $this->_account->getForm('UsernameChange')->setAction('/my/modify');
                $this->view->emailform = $this->_account->getForm('EmailChange')->setAction('/my/modify');
                $this->view->passwordform = $this->_account->getForm('PasswordChange')->setAction('/my/modify');
		
		if($this->_request->IsPost())
		{
			// var_dump($this->_request->getParams());
			$data = $this->_request->getParams();
			if($data['operation'] == 'changepassword')
			{
				// var_dump($this->view->passwordform->isValid($_POST));
				if($this->view->passwordform->isValid($_POST))
				{
					$values = $this->view->passwordform->getValues();
					var_dump($values);
					// Check if current password is okay
					$account = new models_Account();

					// var_dump($account->checkPassword($
					$auth = Zend_Auth::getInstance();
					$identity = $auth->getIdentity();
					
					if($account->checkPassword($identity->id, $values['currentpassword']))
					{
						$result = $account->setPassword($identity->id, $values['passwd']);
						var_dump($result);
						$flashmessenger = $this->_helper->getHelper('FlashMessenger');
						$flashmessenger->addMessage('Password Updated');
						
					}
					else
					{
						$flashmessenger = $this->_helper->getHelper('FlashMessenger');
                                                $flashmessenger->addMessage('Current Password Incorrect');
					}
					// die("<br><br>Form Valid!");

				}
				// 	die("Change Password");
			}
			elseif($data['operation'] == 'changeemail')
			{
				die("Change Email Address");
			}
			elseif($data['operation'] == 'changeusername')
			{
				die("change Username");
			}
		}

		$this->view->usernameform = $this->_account->getForm('UsernameChange')->setAction('/my/modify');
		$this->view->emailform = $this->_account->getForm('EmailChange')->setAction('/my/modify');
		$this->view->passwordform = $this->_account->getForm('PasswordChange')->setAction('/my/modify');
		
	}
}
