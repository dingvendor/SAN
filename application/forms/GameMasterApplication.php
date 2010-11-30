<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GameMasterApplication
 *
 * @author Dan
 */
class forms_GameMasterApplication extends Zend_Form
{
    public function __construct($options = null)
	{
		parent::__construct($options);

		//$username = $this->addElement(new Zend_Form_Element_Text('username');
		$this->addElement('textarea', 'application', array(
			'label' => 'Your Application: ',
			'required' => true
			));
		$this->addElement('submit','Login');

		// Set options if they exist
		/*
		if(!is_null($options))
		{
		$this->setAction($options['action'])
		     ->setMethod($options['method']);
		}*/
	}
}
?>
