<?php
class Produto extends Fgsl_Db_Table_Abstract
{
	protected $_name = 'produto';
	protected $_title = 'Produtos';
	public function __construct()
	{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_tbl_prefix = 'prd_';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID Produto',
			$this->_tbl_prefix.'nome' => 'Nome do produto',
			$this->_tbl_prefix.'marca_id' => 'Marca',
			$this->_tbl_prefix.'unidade_id' => 'Unidade',
			$this->_tbl_prefix.'valor_venda' => 'Valor da venda',
			$this->_tbl_prefix.'desconto_maximo' => '% de desconto máximo',
			$this->_tbl_prefix.'custo_atual' => 'Custo atual',
			$this->_tbl_prefix.'custo_medio' => 'Custo médio total',
			$this->_tbl_prefix.'quantidade_total' => 'Qtd total de produto adquirido',
			$this->_tbl_prefix.'estoque_quantidade' => 'Qtd atual no estoque',
			$this->_tbl_prefix.'estoque_alerta' => 'Qtd para alertar',
			$this->_tbl_prefix.'estoque_minimo' => 'Qtd mínima',
			$this->_tbl_prefix.'estoque_reserva' => 'Qtd reservada',
			$this->_tbl_prefix.'peso' => 'Peso bruto (KG)',
			$this->_tbl_prefix.'volume' => 'Volume (LxAxC)',
			$this->_tbl_prefix.'descricao' => 'Descrição',
			$this->_tbl_prefix.'imagem' => 'Imagem do produto'
			);

	    $this->_fieldOptions = array();
	    $this->_fieldOptions[$this->_tbl_prefix.'nome'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'512', 'required'=>'true')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'valor_venda'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'money', 'required'=>'true')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'desconto_maximo'] = array(
	      'setAttrib'=>array('maxLength'=>'5', 'data'=>'float')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'estoque_alerta'] = array(
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'integer')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'estoque_minimo'] = array(
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'integer')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'estoque_reserva'] = array(
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'integer')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'peso'] = array(
	      'setAttrib'=>array('maxLength'=>'7', 'data'=>'float')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'volume'] = array(
	      'setAttrib'=>array('maxLength'=>'32')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'descricao'] = array(
	      'setAttrib'=>array('maxLength'=>'1024', 'required'=>'true')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'imagem'] = array(
	      'setAttrib'=>array('data'=>'image')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'custo_atual'] =
		$this->_fieldOptions[$this->_tbl_prefix.'custo_medio'] =
		$this->_fieldOptions[$this->_tbl_prefix.'quantidade_total'] =
		$this->_fieldOptions[$this->_tbl_prefix.'estoque_quantidade'] =
	    array(
	      'setAttrib'=>array('readonly'=>'readonly')
	      );

		$this->_lockedFields = array($this->_tbl_prefix.'grp_id');
		$this->_orderField = $this->_tbl_prefix.'nome';
		$this->_searchField = $this->_tbl_prefix.'nome';

		$this->_selectOptions = array(
		    $this->_tbl_prefix.'marca_id' => array(),
			$this->_tbl_prefix.'unidade_id' => array()
		  );

	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::HIDDEN,
			$this->_tbl_prefix.'nome' => Fgsl_Form_Constants::TEXT,
 			$this->_tbl_prefix.'marca_id' => Fgsl_Form_Constants::SELECT,
			$this->_tbl_prefix.'unidade_id' => Fgsl_Form_Constants::SELECT,
			$this->_tbl_prefix.'valor_venda' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'desconto_maximo' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'custo_atual' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'pro_custoamedio' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'quantidade_total' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'estoque_quantidade' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'estoque_alerta' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'estoque_minimo' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'estoque_reserva' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'peso' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'volume' => Fgsl_Form_Constants::TEXT,
			$this->_tbl_prefix.'descricao' => Fgsl_Form_Constants::TEXTAREA,
			$this->_tbl_prefix.'pro_imag-em' => Fgsl_Form_Constants::TEXT
		);

		$this->_typeValue = array(
			'id' => self::INT_TYPE,
			$this->_tbl_prefix.'unidade_id' => self::INT_TYPE,
			$this->_tbl_prefix.'marca_id' => self::INT_TYPE,
			$this->_tbl_prefix.'valor_venda' => self::FLOAT_TYPE,
			$this->_tbl_prefix.'desconto_maximo' => self::FLOAT_TYPE,
			$this->_tbl_prefix.'custo_atual' => self::FLOAT_TYPE,
			$this->_tbl_prefix.'pro_custoamedio' => self::FLOAT_TYPE,
			$this->_tbl_prefix.'peso' => self::FLOAT_TYPE,
			$this->_tbl_prefix.'quantidade_total' => self::INT_TYPE,
			$this->_tbl_prefix.'estoque_quantidade' => self::INT_TYPE,
			$this->_tbl_prefix.'estoque_alerta' => self::INT_TYPE,
			$this->_tbl_prefix.'estoque_minimo' => self::INT_TYPE,
			$this->_tbl_prefix.'estoque_reserva' => self::INT_TYPE
			);
	}

	function getValuesToAutoSuggest($term)
	{
        $select = $this->getAdapter()->select();
        $select->from($this->getName(),array("{$this->_tbl_prefix}nome AS value","{$this->_tbl_prefix}nome AS label", "id", "{$this->_tbl_prefix}valor_venda"));
        $select->where("{$this->_tbl_prefix}nome LIKE '%{$term}%' OR {$this->_tbl_prefix}descricao LIKE '%{$term}%'");

        return $this->fetchAllAsArray($select);
	}
}