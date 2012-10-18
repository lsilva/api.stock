<?php
class Lancamento extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'lancamento';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID',
		  	'data_evento' => 'Data do evento',
		  	'data_cadastro' => 'Data do cadastro',
		  	'valor' => 'Valor',
		  	'tipo_lancamento' => 'Tipo do lançamento',		  	
		  	'descricao' => 'Descricao',
			);

	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['data_evento'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('required'=>'true', 'data'=>'data-ui')
	      );
	    $this->_fieldOptions['data_cadastro'] = array(
	      'setAttrib'=>array('disabled'=>'true')
	      );	    
	    $this->_fieldOptions['descricao'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'256','required'=>'true')
	      );
	    $this->_fieldOptions['valor'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'10', 'data'=>'money', 'required'=>'true')
	      );
		$this->_selectOptions = array(
		    'tipo_lancamento' => array('E' => 'Entrada', 'S' => 'Saída')
		  );	    

		$this->_lockedFields = array('id');
		$this->_orderField = 'descricao';
		$this->_searchField = 'descricao';
	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::TEXT,
	  		'data_evento' => Fgsl_Form_Constants::TEXT,
	    	'data_cadastro' => Fgsl_Form_Constants::TEXT,
	    	'valor' => Fgsl_Form_Constants::TEXT,
	    	'tipo_lancamento' => Fgsl_Form_Constants::SELECT,
	    	'descricao' => Fgsl_Form_Constants::TEXTAREA
		);
		}

	public function insert(array $data)
		{
		$data["data_cadastro"] = date("Y-m-d H:i:s");
		parent::insert($data);
		}
	}