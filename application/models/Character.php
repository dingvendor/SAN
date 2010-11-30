<?php

class models_Character
{
	private $_forms;

	/***
         * @param name form name to get
         */
        public function getForm($name, $options = null)
        {
                $form = 'forms_'.$name;
                $this->_forms[$name] = new $form($options);
                return $this->_forms[$name];

        }
}
