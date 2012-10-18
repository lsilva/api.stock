<?php
class MovimentoTipo extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'movimento_tipo';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID Tipo',
			'descricao' => 'Descrição',
			'tipo' => 'Tipo de movimento',
			'estorno' => 'Estorno',
			'custo_medio' => 'Afeta custo médio',
			'custo_atual' => 'Afeta custo atual'
			);

	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['descricao'] = array(
			'addValidator'=>array('NotEmpty'),
			'setRequired'=>true,
			'setAttrib'=>array('maxLength'=>'128', 'required'=>'true')
			);
		//$this->_lockedFields = array('tmv_id');
		$this->_orderField = 'descricao';
		$this->_searchField = 'descricao';

		$this->_selectOptions = array(
			'tipo' => array("E"=>"ENTRADA","S"=>"SAÍDA")
			);
		$this->_typeElement = array(
			'id' => Fgsl_Form_Constants::HIDDEN,
			'descricao' => Fgsl_Form_Constants::TEXT,
			'tipo' => Fgsl_Form_Constants::SELECT,
			'estorno' => Fgsl_Form_Constants::CHECKBOX,
			'custo_medio' => Fgsl_Form_Constants::CHECKBOX,
			'custo_atual' => Fgsl_Form_Constants::CHECKBOX
			);
		$this->_typeValue = array(
			'id' => self::INT_TYPE
			);
		}
	}