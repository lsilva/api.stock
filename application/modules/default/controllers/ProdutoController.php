<?php
require_once "AbstractController.php";

class ProdutoController extends AbstractController
{

	public function init()
    {
        Zend_Loader::loadClass('Produto');
        $this->_model = new Produto();
        parent::init();
    }
}