<?php

class forms_ValidateRegistration extends Zend_Form
{
	public function __construct($options = null, $data = null)
	{
		parent::__construct($options);
		
		if(null == $data)
		{
			$data->email = '';
		}

		/*$this->addElement(new ZendX_JQuery_Form_Element_AutoComplete(
			'username',
			'', 
			array('url'=> '/account/username', 
			      'type'=>'get',
			      'source' => '/account/username')));
		$this->getElement('username')->setJQueryParams(array(
							             'url' => '/account/username'));*/
		
		$this->addElement('text', 'username', array(
			'label' => 'Username: ',
			'required' => true,
			'id'=>'username'
			));
		$this->getElement('username')
			->addValidator(new Zend_Validate_Alnum());
	
		// $this->addElement('div','status');


		$this->addElement('text', 'email', array(
			'label' => 'Email Address: ',
			'required' => true,
			'value'	=> $data->email,
			'disabled' => 'true'
			));
		
		$this->addElement('submit', 'Register');

		if(!is_null($options))
		{
			$this->setAction($options['action'])
			     ->setMethod($options['method']);
		}
	}
}
