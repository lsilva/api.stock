<?php
require_once "AbstractController.php";

class UnidadeController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('Unidade');
        $this->_model = new Unidade();
        parent::init();
    }
}