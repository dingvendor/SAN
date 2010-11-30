<?php

class forms_MiniSearch extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		
		//$username = $this->addElement(new Zend_Form_Element_Text('username');
		$this->addElement('text', 'query', array(
			'label' => 'Search: ',
			'required' => true
			));
		$this->getElement('query')
			->addValidator(new Zend_Validate_Alnum());
		
		$this->addElement('submit','doSearch', array ('label' => 'Search'));
		
		// Set options if they exist
		$this->setAction('/search')
		     ->setMethod('post');
	}
}
