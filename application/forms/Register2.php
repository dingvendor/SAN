<?php

class forms_Register2 extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		//$username = $this->addElement(new Zend_Form_Element_Text('username');
		/*
		$this->addElement('text', 'username', array(
			'label' => 'Username: ',
			'required' => true
			));
		$this->getElement('username')
			->addValidator(new Zend_Validate_Alnum());
		*/
		$this->addElement('text', 'email', array(
			'label' => 'Email Address: ',
			'required' => true
			));
		
		$this->addElement('submit', 'Register');

		if(!is_null($options))
		{
		$this->setAction($options['action'])
		     ->setMethod($options['method']);
		}
	}
}
