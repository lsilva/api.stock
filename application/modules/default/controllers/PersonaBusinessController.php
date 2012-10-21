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

    public function othersResource($resource,$params)
    {
        if($resource == "term")
        {
            $select = $this->_model->getAdapter()->select();
            $select->from($this->_model->getName(),array("fantasia AS value","fantasia AS label", "id", "cnpj"));
            $select->where("fantasia LIKE '%{$params["term"]}%' OR razao LIKE '%{$params["term"]}%'");
            $arrElement = $this->_model->fetchAllAsArray($select);
        }

        return $arrElement;
    }
}