<?php
class MovimentoHistorico extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'movimento_historico';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
        $this->_tbl_prefix = 'mvh_';
		$this->_fieldNames = $this->_getCols();
//		$this->_fieldNames[] = 'pro_lista';
		$this->_fieldLabels = array(
            'id' => 'ID do movimento',
            $this->_tbl_prefix.'data' => 'Data',
            $this->_tbl_prefix.'sequencia' => 'Número da nota',
            $this->_tbl_prefix.'descricao' => 'Observações',
            $this->_tbl_prefix.'valor_total' => 'Valor total',
            $this->_tbl_prefix.'cliente' => 'Cliente / Fornecedor',
//            'usu_codigo' => 'ID usuário',
//            'pgt_codigo' => 'Forma de pagamento',
//            'est_codigo' => 'Local do estoque',
//            'tmov_codigo' => 'Tipo de movimento',
//            'pro_lista'	=> 'Lista de Produtos'
			);
        //Seta atributos especias para os fields
        $this->_fieldOptions = array();
        $this->_fieldOptions[$this->_tbl_prefix.'descricao'] = array(
            'setAttrib'=>array('maxLength'=>'256')
            );
        $this->_fieldOptions[$this->_tbl_prefix.'valor_total'] = array(
            'addValidator'=>array('NotEmpty'),
            // 'setRequired'=>true,
            'setAttrib'=>array('maxLength'=>'10', 'data'=>'money'/*, 'required'=>'true'*/)
            );
        $this->_fieldOptions[$this->_tbl_prefix.'data'] = array(
            'addValidator'=>array('NotEmpty'),
            'setRequired'=>true,
            'setAttrib'=>array('maxLength'=>'10', 'data'=>'data-ui', 'required'=>'true')
            );
		//$this->_lockedFields = array('tmv_id');
		$this->_orderField = 'id';
		$this->_searchField = $this->_tbl_prefix.'descricao';
/*
    //Load Array de Tipos de Movimentos
		Zend_Loader::loadClass('MovimentoTipo');
		$objMovimentoTipo = new MovimentoTipo();
		$arrTipoMovTemp = $objMovimentoTipo->fetchAllAsArray($objMovimentoTipo->getCustomSelect(NULL,"",""));
		$arrTipoMov = array("" => "Selecione");
		foreach($arrTipoMovTemp as $tipo)
  		$arrTipoMov[$tipo["tmv_id"]] = $tipo["tmv_descricao"];
    //Load Array de Formas de Pagamentos
		Zend_Loader::loadClass('PagamentoForma');
		$objPagamentoForma = new PagamentoForma();
		$arrPgtoTemp = $objPagamentoForma->fetchAllAsArray($objPagamentoForma->getCustomSelect(NULL,"",""));
		$arrPgto = array("" => "Selecione");
		foreach($arrPgtoTemp as $pgto)
  		$arrPgto[$pgto["pgt_id"]] = $pgto["pgt_nome"];
    //Load Array de Locais de estoque
		Zend_Loader::loadClass('EstoqueLocal');
		$objEstoqueLocal = new EstoqueLocal();
		$arrEstoqueTemp = $objEstoqueLocal->fetchAllAsArray($objEstoqueLocal->getCustomSelect(NULL,"",""));
		$arrEstoque = array("" => "Selecione");
		foreach($arrEstoqueTemp as $estoque)
  		$arrEstoque[$estoque["stq_id"]] = $estoque["stq_nome"];

		$this->_selectOptions = array(
		  'pgt_codigo' => $arrPgto,
			'est_codigo' => $arrEstoque,
			'tmov_codigo' => $arrTipoMov
		  );
*/
        $this->_typeElement = array(
            'id' => Fgsl_Form_Constants::HIDDEN,
            $this->_tbl_prefix.'cliente' => Fgsl_Form_Constants::HIDDEN,
            $this->_tbl_prefix.'data' => Fgsl_Form_Constants::TEXT,
            $this->_tbl_prefix.'sequencia' => Fgsl_Form_Constants::TEXT,
            $this->_tbl_prefix.'descricao' => Fgsl_Form_Constants::TEXT,
            $this->_tbl_prefix.'valor_total' => Fgsl_Form_Constants::HIDDEN,
//            'usu_codigo' => Fgsl_Form_Constants::TEXT,
//            'cli_id' => Fgsl_Form_Constants::HIDDEN,
//            'pgt_codigo' => Fgsl_Form_Constants::SELECT,
//            'est_codigo' => Fgsl_Form_Constants::SELECT,
//            'tmov_codigo' => Fgsl_Form_Constants::SELECT,
//            'pro_lista' => Fgsl_Form_Constants::HIDDEN
            );
		}
/*
	public function insert(array $data)
		{
		$dataAuth = Fgsl_Session_Namespace::get('data_auth');
		$data["usu_codigo"] = $dataAuth->cli_id;

		$pro_lista = Zend_Json::decode($data["pro_lista"]);
		if(is_null($data["mov_descricao"])) $data["mov_descricao"] = '';
		unset($data["pro_lista"]);
		foreach($pro_lista as $produto)
  		$data["mov_valor_total"] += $produto["vl_total"];

	  $return = parent::insert($data);
	  $mov_id = $return["mov_codigo"];
		Zend_Loader::loadClass('MovimentoTipo');
		$objMovimentoTipo = new MovimentoTipo();
		$fieldKey = $objMovimentoTipo->getFieldKey();
		$tipoMov = $objMovimentoTipo->fetchRow("{$fieldKey} = {$data["tmov_codigo"]}");
    //Inserção dos itens
		Zend_Loader::loadClass('MovimentoItem');
		$objMovimentoItem = new MovimentoItem();

		Zend_Loader::loadClass('Produto');
		$objProduto = new Produto();
		$fieldKey = $objProduto->getFieldKey();

		$itens_inseridos = 1;
		foreach($pro_lista as $produto)
		  {
		  $data = array();
  		$data["mov_codigo"] = $mov_id;
      $data["item_codigo"] = $itens_inseridos++;
      $data["pro_codigo"] = $produto["id"];
      $data["item_quantidade"] = $produto["qtde"];
      $data["item_valor"] = $produto["vl_total"];
  		$objMovimentoItem->insert($data);
      if($tipoMov["tmv_customedio"] == "S" || $tipoMov["tmv_custoatual"] == "S")
        {
        $where = "{$fieldKey} = {$data["pro_codigo"]}";
        $select = $objProduto->getAdapter()->select();
        $select->from($objProduto->getName(),array("pro_customedio","pro_custoatual","pro_qtdtotal"));
        $select->where($where);
        $record = $objProduto->fetchAllAsArray($select);

        $signalInvert = ($tipoMov["tmv_estorno"] == "S" ? -1 : 1);
        $signal = ($tipoMov["tmv_tipo"] == "E" ? 1 : -1) * $signalInvert;
        if($tipoMov["tmv_customedio"] == "S")
          {
          $record[0]["pro_customedio"] += $data["item_valor"] * $signal;
          $record[0]["pro_qtdtotal"] += $data["item_quantidade"] * $signal;
          }

        if($tipoMov["tmv_custoatual"] == "S")
          $record[0]["pro_custoatual"] = $data["item_valor"] * $signal;

        $objProduto->update($record[0], $where);
        }
		  }
		}

	public function update(array $data, $where)
		{
		$data["tmv_estorno"] = (empty($data["tmv_estorno"])?"N":"S");
		$data["tmv_customedio"] = (empty($data["tmv_customedio"])?"N":"S");
		$data["tmv_custoatual"] = (empty($data["tmv_custoatual"])?"N":"S");
		if(is_null($data["mov_descricao"])) $data["mov_descricao"] = '';
    $pro_lista = $data["pro_lista"];
		unset($data["pro_lista"]);

		parent::update($data,$where);
		}
*/
	}