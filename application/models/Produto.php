<?php
class Produto extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'produto';
	protected $_title = 'Produtos';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID Produto',
			'nome' => 'Nome do produto',
			'marca_id' => 'Marca',
			'unidade_id' => 'Unidade',
			'valor_venda' => 'Valor da venda',
			'desconto_maximo' => '% de desconto máximo',
			'custo_atual' => 'Custo atual',
			'custo_medio' => 'Custo médio total',
			'quantidade_total' => 'Qtd total de produto adquirido',
			'estoque_quantidade' => 'Qtd atual no estoque',
			'estoque_alerta' => 'Qtd para alertar',
			'estoque_minimo' => 'Qtd mínima',
			'estoque_reserva' => 'Qtd reservada',
			'peso' => 'Peso bruto (KG)',
			'volume' => 'Volume (LxAxC)',
			'descricao' => 'Descrição',
			'imagem' => 'Imagem do produto'
			);
	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['nome'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'512', 'required'=>'true')
	      );
	    $this->_fieldOptions['valor_venda'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'money', 'required'=>'true')
	      );
	    $this->_fieldOptions['desconto_maximo'] = array(
	      'setAttrib'=>array('maxLength'=>'5', 'data'=>'float')
	      );
	    $this->_fieldOptions['estoque_alerta'] = array(
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'integer')
	      );
	    $this->_fieldOptions['estoque_minimo'] = array(
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'integer')
	      );
	    $this->_fieldOptions['estoque_reserva'] = array(
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'integer')
	      );
	    $this->_fieldOptions['peso'] = array(
	      'setAttrib'=>array('maxLength'=>'7', 'data'=>'float')
	      );
	    $this->_fieldOptions['volume'] = array(
	      'setAttrib'=>array('maxLength'=>'32')
	      );
	    $this->_fieldOptions['descricao'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'1024', 'required'=>'true')
	      );
	    $this->_fieldOptions['imagem'] = array(
	      'setAttrib'=>array('data'=>'image')
	      );
	    $this->_fieldOptions['custo_atual'] =
		$this->_fieldOptions['custo_medio'] =
		$this->_fieldOptions['quantidade_total'] =
		$this->_fieldOptions['estoque_quantidade'] =
	    array(
	      'setAttrib'=>array('readonly'=>'readonly')
	      );
	    /*$this->_fieldOptions['marca_id'] = array(
	      'setAttrib'=>array('multiple'=>'multiple')
	      );*/

		$this->_lockedFields = array('grp_id');
		$this->_orderField = 'nome';
		$this->_searchField = 'nome';
    //Load Array de marcas
		/*Zend_Loader::loadClass('Marca');
		$objMarca = new Marca();
		$arrMarcaTemp = $objMarca->fetchAllAsArray($objMarca->getCustomSelect(NULL,"",""));
		$arrMarca = array("" => "Selecione");
		foreach($arrMarcaTemp as $marca)
  		$arrMarca[$marca["marca_id"]] = $marca["mrc_nome"];
  	//Load Array de Unidades
		Zend_Loader::loadClass('Unidade');
		$objUnidade = new Unidade();
		$arrUnidadeTemp = $objUnidade->fetchAllAsArray($objUnidade->getCustomSelect(NULL,"",""));
		$arrUnidade = array("" => "Selecione");
		foreach($arrUnidadeTemp as $unidade)
  		$arrUnidade[$unidade["unidade_id"]] = $unidade["und_nome"];
*/
		$this->_selectOptions = array(
		    'marca_id' => array(),
			'unidade_id' => array()
		  );
/*		  'pro_tipo_pgto' => array('HR'=>'HORA', 'DI'=>'DIA', 'MS'=>utf8_encode('M�S'), 'AN'=>'ANO'),
	    'pro_atual' => $bool,
		  'pro_nivel_cargo' => array('ACE'=>'ACESSORIA', 'CHE'=>'CHEFIA', 'SUP'=>'SUPERVISOR',
		     'DIR'=>'DIRETORIA','GER'=>utf8_encode('GER�NCIA'),'OPE'=>'OPERACIONAL',
		     'TEC'=>utf8_encode('T�CNICO'),'ESP'=>'ESPECIALISTA'),
      'pro_ramo_empresa' => array('AGRO'=>utf8_encode('AGROPECU�RIA'), 'COME'=>'COMERCIO',
		    'INDU'=>utf8_encode('IND�STRIA'), 'SERV'=>utf8_encode('SERVI�O'), 'EDUC'=>utf8_encode('EDUCA��O'),
		    'SAUD'=>utf8_encode('SA�DE'), 'PUBL'=>utf8_encode('P�BLICO'),)
		  );
*/
	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::HIDDEN,
			'nome' => Fgsl_Form_Constants::TEXT,
 			'marca_id' => Fgsl_Form_Constants::SELECT,
			'unidade_id' => Fgsl_Form_Constants::SELECT,
			'valor_venda' => Fgsl_Form_Constants::TEXT,
			'desconto_maximo' => Fgsl_Form_Constants::TEXT,
			'custo_atual' => Fgsl_Form_Constants::TEXT,
			'pro_custoamedio' => Fgsl_Form_Constants::TEXT,
			'quantidade_total' => Fgsl_Form_Constants::TEXT,
			'estoque_quantidade' => Fgsl_Form_Constants::TEXT,
			'estoque_alerta' => Fgsl_Form_Constants::TEXT,
			'estoque_minimo' => Fgsl_Form_Constants::TEXT,
			'estoque_reserva' => Fgsl_Form_Constants::TEXT,
			'peso' => Fgsl_Form_Constants::TEXT,
			'volume' => Fgsl_Form_Constants::TEXT,
			'descricao' => Fgsl_Form_Constants::TEXTAREA,
			'pro_imag-em' => Fgsl_Form_Constants::TEXT
		);
		$this->_typeValue = array(
			'id' => self::INT_TYPE,
			'unidade_id' => self::INT_TYPE,
			'marca_id' => self::INT_TYPE,
			'valor_venda' => self::FLOAT_TYPE,
			'desconto_maximo' => self::FLOAT_TYPE,
			'custo_atual' => self::FLOAT_TYPE,
			'pro_custoamedio' => self::FLOAT_TYPE,
			'peso' => self::FLOAT_TYPE,
			'quantidade_total' => self::INT_TYPE,
			'estoque_quantidade' => self::INT_TYPE,
			'estoque_alerta' => self::INT_TYPE,
			'estoque_minimo' => self::INT_TYPE,
			'estoque_reserva' => self::INT_TYPE
			);
		}

	public function insert(array $data)
		{
/*		var_dump("INSERT",$data);exit;
		$dataAuth = Fgsl_Session_Namespace::get('data_auth');
		$data["cli_id"] = $dataAuth->cli_id;
		$data["id"] = $this->nextID("cli_id='".$dataAuth->cli_id."'");
		$data["pro_salario"] = $this->float2bd($data["pro_salario"]);
		$data["pro_dt_inicio"] = $this->date2db($data["pro_dt_inicio"]);
		$data["pro_dt_termino"] = $this->date2db($data["pro_dt_termino"]);
	*/	parent::insert($data);
		}
/*
	public function getCustomSelect($where,$order,$limit)
		{
	  $arrBlock = array();
		foreach($this->_getCols() as $col)
			{
			if($col == 'pro_dt_inicio')$col = "DATE_FORMAT(`cad_pro`.`pro_dt_inicio`, '%d/%m/%Y') AS pro_dt_inicio";
			if($col == 'pro_dt_termino')$col = "DATE_FORMAT(`cad_pro`.`pro_dt_termino`, '%d/%m/%Y') AS pro_dt_termino";

			$field[] = $col;
			}
		$select = $this->getAdapter()->select();
		$select->from(self::$this->_name,$field);
		if($where!==null)
			$select->where($where);
		$select->order($order);
		$select->limit($limit);
		//var_dump($select->__toString());exit;
		return $select;
		}

	public function date2db($s)
		{
		$dt = explode("/",$s);
		return $dt[2]."-".$dt[1]."-".$dt[0];
		}

	public function float2bd($s)
		{
		$s = str_replace(".","",$s);
		$s = str_replace(",",".",$s);
		return $s;
		}

	public function update(array $data, $where)
		{
		$data["pro_salario"] = $this->float2bd($data["pro_salario"]);
    $data["pro_dt_inicio"] = $this->date2db($data["pro_dt_inicio"]);
    $data["pro_dt_termino"] = $this->date2db($data["pro_dt_termino"]);
		$dataAuth = Fgsl_Session_Namespace::get('data_auth');
		$where = "cli_id={$dataAuth->cli_id} AND " . $where;
		parent::update($data,$where);
		}

	public function delete($where)
		{
		$dataAuth = Fgsl_Session_Namespace::get('data_auth');
		$where = "cli_id={$dataAuth->cli_id} AND " . $where;
		parent::delete($where);
		}
*/
	}