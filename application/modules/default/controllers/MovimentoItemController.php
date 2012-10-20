<?php
require_once "AbstractController.php";

class MovimentoItemController extends AbstractController
{
	public function init()
    {
        Zend_Loader::loadClass('MovimentoItem');
        $this->_model = new MovimentoItem();
        parent::init();
    }

    public function othersResource($resource,$params)
    {
        if($resource == "term")
        {
            var_dump($resource,$params);
        }
    }
}