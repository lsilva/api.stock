<?php
require_once "AbstractController.php";

class MarcaController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('Marca');
        $this->_model = new Marca();
        parent::init();
    }
}