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

    public function othersResource($resource,$params)
    {
        $arrElement = array();
        if(in_array("itens",$params))
        {
            Zend_Loader::loadClass('MovimentoItem');
            $objMovItem = new MovimentoItem();
            $arrElement = $objMovItem->fetchAllAsArray($objMovItem->getCustomSelect("mvh_id={$resource}","",""));
        }

        return $arrElement;
    }
}