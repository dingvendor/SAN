
<?php

class forms_PlayerApplication extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		//$username = $this->addElement(new Zend_Form_Element_Text('username');
		$this->addElement('textarea', 'application', array(
			'label' => 'Your Application: ',
			'required' => true
			));

                $this->addElement('textarea', 'biography', array(
                       'label' => 'Your Character Biography: ',
                       'required' => true
                       ));

                $this->addElement('text', 'game', array(
                    'label' => 'Which game are you applying for? '
                ));
                
		$this->addElement('submit','Submit', array('label'=>'Submit Application'));
                //$this->addElement('submit', 'Preview');
		
		// Set options if they exist
		/*
		if(!is_null($options))
		{
		$this->setAction($options['action'])
		     ->setMethod($options['method']);
		}*/
	}
}
