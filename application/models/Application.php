<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Application
 *
 * @author Dan
 */
class models_Application
{
    /**
     * Internal forms array for singleton forms
     * @var array 
     */
     private $_forms;
	
     /**
      * Constructor
      */
	public function __construct()
	{
		$this->_forms = array();
	}
		
	/**
         * Returns an instance of a form object, creates one if
         * it doesn't already exist
         * 
         * @param string $name
         * @return Zend_Form
         */
	public function getForm($name)
	{
		$form = 'forms_'.$name;
		$this->forms[$name] = new $form();
		return $this->forms[$name];

	}
    /**
     * Processes the application for a player
     * @param text $application
     * @param text $biography
     * @param string $game
     * @return boolean
     */
    public function player($application, $biography, $game = '')
    {
        // $character = new models_Character();
        $appTable = new Application_Model_DbTable_Application();

        $m = new DV_HtmlMailer();
        
        return 1; // Succeeded
    }


    public function gamemaster($application, $biography)
    {
        throw new Zend_Exception('Not Yet Implemented');
    }
}
?>
