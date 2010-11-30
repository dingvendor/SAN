<?php

class forms_UsernameChange extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
	
		 $this->addElement('hidden', 'operation', array(
                        'value' =>'changeusername')
                        );
		
		$this->addElement('text', 'newusername', array(
			'label' => 'New Username: ',
			'required' => true
			));
		$this->getElement('newusername')
			->addValidator(new Zend_Validate_Alnum());
		$this->addElement('submit','SubmitUsernameChangeRequest', array('label' => 'Submit change request', 'disabled' => 'disabled'));
		
		$this->setMethod('POST');
		//     ->setMethod('/account/usernamechange');
	}
}
