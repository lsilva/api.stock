<?php
class UserGroupController extends Zend_Rest_Controller
{
	public function init()
    {
        $request = new Zend_Controller_Request_Http();
        $accept = $request->getHeader('accept');//Tipo do retorno
        $accept_language = $request->getHeader('accept-language');//Idioma ( pt-br / en-us || en )
        $range = $request->getHeader('range');//Paginação 0-N
        //Tipo do cabeçalho testado
        ## text/xml,application/xml,application/xhtml+xml,text/html;q=0.9,text/plain;q=0.8,image/png,*/*;q=0.5
        $arrAccept = explode(";",$accept);
        $arrAccept =explode(",",$arrAccept[0]);
        $response = "";
        foreach($arrAccept as $_accept)
        {
            switch ($_accept)
            {
                case 'application/xml':
                case 'text/xml':
                    $response = "xml";
                    break;
                case 'application/json':
                    $response = "json";
                    break;
                case 'text/csv':
                    $response = "csv";
                    break;
                case 'text/plain':
                    $response = "plain";
                    break;
                default:
                    $response = "json";
            }
            if(!empty($response))
                break;
        }
        if(empty($response))
           $response = "json";

        $this->translate = new Zend_Translate('array', LANGUAGE_PATH, null, array('scan' => Zend_Translate::LOCALE_FILENAME));
        $writer = new Zend_Log_Writer_Stream( LOG_PATH . '/not_translate.log');
        $log    = new Zend_Log($writer);
        // add the log to the translate
        $this->translate->setOptions(
                array(
                    'log'             => $log,
                    'logUntranslated' => true
                )
            );

        switch($accept_language)
        {
            case 'en':
            case 'en-us':
                $this->translate->setLocale('en_US');
            case 'pt-br':
            default:
                $this->translate->setLocale('pt_BR');
        }

        // define as possibilidades de formatos de saída para cada método e escolhe formato definido acima
        $this->_helper->contextSwitch()->addActionContexts(array(
            'index'  => array('xml', 'json'),
            'get'    => array('xml', 'json'),
            'post'   => array('xml', 'json'),
            'put'    => array('xml', 'json'),
            'delete' => array('xml', 'json')
            ))->initContext($response);

        Zend_Loader::loadClass('UserGroup');
        $this->_model = new UserGroup();
        $this->_helper->layout->disableLayout();
        $this->_response_type = $response;
        $this->_itemsPerPage = 20;
    }

   public function indexAction()
   {
        $result = $this->_model->fetchAll();
        $rows =  $result->toArray();
        $this->dispachResponse($this->_response_type, $rows);
   }

    public function getAction()
    {
        $id = $this->getRequest()->getParam('id');
        $resource = "";
        if(!empty($id) && is_numeric($id))
            $resource = "get";
        else
        {
            $params = $this->getRequest()->getParams();
            //Não deve considerar estes elementos
            unset($params["controller"]);
            unset($params["action"]);
            unset($params["module"]);
            if(count($params) == 1 && isset($params["id"]))
                $resource = $this->getRequest()->getParam('id');
            else
                $resource = key($params);
        }
        $arrElement = array();
        switch($resource)
        {
            case "form":
                $record = array();
                if(!empty($params[$resource]))
                {
                    $fieldKey = $this->_model->getFieldKey();
                    $record = $this->_model->fetchRow("{$fieldKey} = ".$params[$resource]);
                }
                //Obtem os campos do modelo corrente
                $arrFields = $this->_model->getFieldNames();
                foreach($arrFields as $field)
                    $fields[$field] = (isset($record->$field) ? $record->$field : "");
                //Seta os valores do formulário
                $options = array(
                Fgsl_Form_Edit::DATA => $fields,
                Fgsl_Form_Edit::ACTION => "",
                Fgsl_Form_Edit::MODEL => $this->_model
                );
                $form = new Fgsl_Form_Edit($options);
                //Obtem os elementos do formulário
                $elements = $form->getElements();
                //Remove todos os decoradores do formulário
                foreach($elements as $field => $element)
                    $arrElement[] = htmlentities($elements[$field]->setDecorators(array('ViewHelper')));
                break;
        }

        $this->dispachResponse($this->_response_type, $arrElement);
    }

    public function postAction()
    {
        $this->view->code = 501;
        $this->view->message = 'Method not implemented';

        $this->guardData(Fgsl_Session_Namespace::get('post'));
        $this->getResponse()->setHttpResponseCode($this->view->code);
        $this->_helper->viewRenderer('status', null, true);
    }

    public function putAction()
    {
        $putdata = fopen("php://input", "r");
        while ($data = fread($putdata, 1024))
        {
            $arrTemp = explode("&",$data);
            foreach($arrTemp as $strTemp)
            {
                //Separa pelo sinal de igual
                $arrTemp_ = explode("=",$strTemp);
                //Obtem o nome do campo que sempre será o primeiro elemento
                $key = $arrTemp_[0];
                unset($arrTemp_[0]);
                //Concatena novamente os elementos, pois pode existir o sinal de igual no conteúdo do campo
                $data = implode("=",$arrTemp_);
                $arrData[$key] = $data;
            }
        }
  /*      $this->view->code = 501;
        $this->view->message = serialize($arrData);
        $this->getResponse()->setHttpResponseCode($this->view->code);
        $this->_helper->viewRenderer('status', null, true);
*/
        $this->guardData($arrData);
    }

    public function deleteAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        //$key = $this->_getParam($this->_model->getFieldKey());
        if($this->remove($id))
        {
            $this->view->code = 201;
            $this->view->message = 'Success';
        }
        else
            $this->view->code = 500;

        $this->getResponse()->setHttpResponseCode($this->view->code);
        $this->_helper->viewRenderer('status', null, true);
    }
    /**
    * Identifica se é uma atualização ou uma inserção de dados e
    * grava-os no banco de acordo com a operação identificada.
    * @param Array / Object $fields
    * @return void
    */
    public function guardData($fields)
    {
        //Obtem os campos do modelo corrente
        $fieldNames = $this->_model->getFieldNames();
        foreach($fieldNames as $field)
            $data[$field] = urldecode(( is_array($fields) ? $fields[$field] : $fields->$field ));

        $options = array();
        $options[Fgsl_Form_Edit::ACTION] = '';
        $options[Fgsl_Form_Edit::DATA] = $data;
        $options[Fgsl_Form_Edit::MODEL] = $this->_model;
        $form = new Fgsl_Form_Edit($options);

        if(!$form->isValid($data))
        {
            $this->view->code = 422;
            foreach($fieldNames as $field)
            {
                $return = $form->$field->getMessages();
                if(!empty($return))
                {
                    $message = $form->$field->getMessages();
                    $id = key($message);
                    $this->view->message =$this->translate->translate($message[$id]);
                    break;
                }
            }
        }
        else
        {
            $data = array();
            $unlockedData = array();
            foreach ($fieldNames as $fieldName)
            {
                if(!isset($form->$fieldName)) continue;
                $fieldValue = $form->$fieldName->getValue();
                $unlockedData[$fieldName] = $this->_model->getCastValue($fieldName,$fieldValue);
                if ($this->_model->isLocked($fieldName)) continue;
                $data[$fieldName] = $this->_model->getCastValue($fieldName,$fieldValue);
            }

            if($this->save(strtolower($_SERVER['REQUEST_METHOD']),$data,$unlockedData))
            {
                $this->view->code = 201;
                $this->view->message = 'Success';
            }
            else
                $this->view->code = 500;
        }
    }
    /**
    * Retorna o resultado da requisição de acordo com os parametros passados
    * @param String $type
    * @param Array $result
    * @return Void
    */
    public function dispachResponse($type, $result)
    {
        $return = "";
        switch ($type) {
            case 'json':
                $arrHeader = $this->_getHeaders($type);
                foreach($arrHeader as $header)
                    header($header);

                $return = Zend_Json::encode($result);
                break;
        }
        die($return);
    }
    /**
    * Retorna um array contendo o cabeçalho específico para o tipo passado.
    * @param String $type
    * @return Array
    */
    public function _getHeaders($type)
    {
        switch ($type)
        {
            case 'json':
                $arrHeader["expires"] = "Mon, 26 Jul 1997 05:00:00 GMT"; // Date in the past
                $arrHeader["last-modified"] = gmdate("D, d M Y H:i:s") . " GMT"; // always modified
                $arrHeader["cache-control"] = "no-cache, must-revalidate"; // HTTP/1.1
                $arrHeader["pragma"] = "no-cache"; // HTTP/1.0
                $arrHeader["content-type"] = "application/json";
                break;
        }
        $arrReturn = array();
        foreach($arrHeader as $key => $value)
            $arrReturn[] = "{$key}: {$value}\n";

        return $arrReturn;
    }
    /**
     * Method to save records (insert or update)
     * @see application/controllers/ICrudController#save()
     */
    public function save($action, array $data, array $unlockedData)
    {
        try
        {
            if ($action == "post")
                $this->_model->insert($data);
            elseif($action == "put")
            {
                $fieldKey = $this->_model->getFieldKey();
                $this->_model->update($data,"$fieldKey = {$unlockedData[$fieldKey]}");
            }
        }
        catch(Exception $e )
        {
            $this->view->message = utf8_encode($e->getMessage());
            return false;
        }
        return true;
    }

    public function remove($key)
    {
        try {
            $this->_model->delete("{$this->_model->getFieldKey()} = $key");
        } catch (Exception $e) {
            $this->view->message = utf8_encode($e->getMessage());
            return false;
        }
        return true;
    }
}