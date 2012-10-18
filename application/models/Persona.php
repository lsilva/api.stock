<?php
class Persona extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'persona';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'Código',
		  	'tipo_persona' => 'Tipo Persona'
			);

	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['tipo_persona'] = array(
			'addValidator'=>array('NotEmpty'),
			'setRequired'=>true,
			'setAttrib'=>array('maxLength'=>'2', 'required'=>'true')
	     	);

		$this->_lockedFields = array('id');
		$this->_orderField = 'id';
		$this->_searchField = 'id';
	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::HIDDEN,
	  		'tipo_persona' => Fgsl_Form_Constants::TEXT
			);
		}		
	}