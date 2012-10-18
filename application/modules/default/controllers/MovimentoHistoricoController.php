<?php
require_once "AbstractController.php";

class MovimentoHistoricoController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('MovimentoHistorico');
        $this->_model = new MovimentoHistorico();
        parent::init();
    }
}