<?php
require_once "AbstractController.php";

class MovimentoTipoController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('MovimentoTipo');
        $this->_model = new MovimentoTipo();
        parent::init();
    }
}