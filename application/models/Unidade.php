<?php
class Unidade extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'unidade';
	protected $_title = 'Unidades';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID Unidade',
		  	'nome' => 'Descrição',
		  	'abreviacao' => 'Abreviação'
			);

	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['nome'] = array(
			'addValidator'=>array('NotEmpty'),
			'setRequired'=>true,
			'setAttrib'=>array('maxLength'=>'256', 'required'=>'true')
	     	);
	    $this->_fieldOptions['abreviacao'] = array(
			'setAttrib'=>array('maxLength'=>'3', 'data'=>'upper')
			);

		$this->_lockedFields = array('id');
		$this->_orderField = 'nome';
		$this->_searchField = 'nome';
	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::TEXT,
	  		'nome' => Fgsl_Form_Constants::TEXT,
	    	'abreviacao' => Fgsl_Form_Constants::TEXT
		);
		}
	}