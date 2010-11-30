<?php

class forms_Login extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		//$username = $this->addElement(new Zend_Form_Element_Text('username');
		$this->addElement('text', 'username', array(
			'label' => 'Username: ',
			'required' => true
			));
		$this->getElement('username')
			->addValidator(new Zend_Validate_Alnum());

		$this->addElement('password', 'passwd', array(
			'label' => 'Password: ',
			'required' => true
			));
		/***
                 * @todo Add custom password validator
		 */
		
		$this->addElement('submit','Login');
		
		// Set options if they exist
		if(!is_null($options))
		{
		$this->setAction($options['action'])
		     ->setMethod($options['method']);
		}
	}
}
