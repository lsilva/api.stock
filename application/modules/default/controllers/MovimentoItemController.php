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


## Removendo espaços em branco (PASTAS)
find . -name "* *" -type d | rename 's/ /_/g'

## Removendo espaços em branco (ARQUIVOS)
find . -name "* *" -type f | rename 's/ /_/g'


## Transformando os caracteres em maíusculos
ls | while read filename; do
    typeset -u uppercase
    uppercase=${filename}
    mv ${filename} ${uppercase}
done