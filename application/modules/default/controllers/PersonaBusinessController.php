<?php
require_once "AbstractController.php";

class PersonaBusinessController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('PersonaBusiness');
        $this->_model = new PersonaBusiness();  
        parent::init();
    }    
}