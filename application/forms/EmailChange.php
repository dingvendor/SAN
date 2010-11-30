<?php

class forms_EmailChange extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		 $this->addElement('hidden', 'operation', array(
                        'value' =>'changeemail')
                        );

		$this->addElement('text', 'newemail', array(
			'label' => 'New Email Address: ',
			'required' => true
			));
		$this->getElement('newemail')
			->addValidator(new Zend_Validate_EmailAddress());
		
		$this->addElement('submit','EmailChange', array('label' => 'Change Email Address', 'disabled' => 'disabled'));
		
		$this->setMethod('POST');
		
	}
}
