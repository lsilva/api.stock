<?php
class PersonaBusiness extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'persona_business';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'Código',
		  	'ramo_id' => 'ID do ramo da empresa',
		  	'fantasia' => 'Nome fantasia',
		  	'razao' => 'Razao Social',
		  	'cnpj' => 'CNPJ da empresa',
		  	'ie' => 'Inscrição Estadual',
		  	'descricao' => 'Breve descrição da empresa'		  			  			  			  			  
			);

	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['fantasia'] = array(
			'setAttrib'=>array('maxLength'=>'128')
	     	);
	    $this->_fieldOptions['razao'] = array(
			'setAttrib'=>array('maxLength'=>'128')
	     	);
	    $this->_fieldOptions['cnpj'] = array(
			'setAttrib'=>array('maxLength'=>'128')
	     	);
	    $this->_fieldOptions['ie'] = array(
			'setAttrib'=>array('maxLength'=>'128')
	     	);	    
	    $this->_fieldOptions['descricao'] = array(
			'setAttrib'=>array('maxLength'=>'45')
	     	);	    	    

		$this->_selectOptions = array(
		    'ramo_id' => array()
		  );

		$this->_lockedFields = array('id');
		$this->_orderField = 'fantasia';
		$this->_searchField = 'fantasia';
	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::HIDDEN,
	  		'tipo_persona' => Fgsl_Form_Constants::TEXT,
	  		'ramo_id' => Fgsl_Form_Constants::SELECT,	
	  		'fantasia' => Fgsl_Form_Constants::TEXT,
	  		'razao' => Fgsl_Form_Constants::TEXT,
	  		'cnpj' => Fgsl_Form_Constants::TEXT,	
	  		'ie' => Fgsl_Form_Constants::TEXT,	
	  		'descricao' => Fgsl_Form_Constants::TEXT
			);
		}

	public function insert(array $data)
		{
		Zend_Loader::loadClass('Persona');
		$objPersona = new Persona();	
		$id = $objPersona->insert(array("tipo_persona" => "PJ"));
		$data["id"] = $id;
/*		var_dump("INSERT",$data);exit;
		$dataAuth = Fgsl_Session_Namespace::get('data_auth');
		$data["cli_id"] = $dataAuth->cli_id;
		$data["id"] = $this->nextID("cli_id='".$dataAuth->cli_id."'");
		$data["pro_salario"] = $this->float2bd($data["pro_salario"]);
		$data["pro_dt_inicio"] = $this->date2db($data["pro_dt_inicio"]);
		$data["pro_dt_termino"] = $this->date2db($data["pro_dt_termino"]);
	*/	parent::insert($data);
		}		
	}