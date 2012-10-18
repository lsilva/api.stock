<?php
require_once "AbstractController.php";

class LancamentoController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('Lancamento');
        $this->_model = new Lancamento();   
        parent::init();
    }    
}