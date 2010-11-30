<?php

class forms_PasswordChange extends Zend_Form
{
	public function init()	
	{
		//parent::__construct($options);

		$this->addElement('hidden', 'operation', array(
			'value' =>'changepassword')
			);

		$this->addElement('password', 'currentpassword', array(
			'label' => 'Current Password: ',
			'required' => true
			));
		
		$this->addElement('password', 'passwd', array(
			'label' => 'Password: ',
			'required' => true
			));
		
		$password = $this->getElement('passwd');

		$this->addElement('password', 'password2', array(
			'label' => 'Confirm Password: ',
			'required' => true
			));

		$this->getElement('password2')
			->addValidator(new Zend_Validate_Identical(array('token' => $password)));
				
		$this->addElement('submit','ChangePassword', array('label'=>'Change Password'));
		
		$this->setMethod('POST');
		
	}

	public function isValid($data)
	{
		$passwd = $this->getElement('password2');
		$passwd->getValidator('Identical')->setToken($data['passwd'])->setMessage('Passwords do not match');

		return parent::isValid($data);
	}
}
