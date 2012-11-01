<?php
class Unidade extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'unidade';
	protected $_title = 'Unidades';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_tbl_prefix = 'und_';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID Unidade',
		  	$this->_tbl_prefix.'nome' => 'Descrição',
		  	$this->_tbl_prefix.'abreviacao' => 'Abreviação'
			);

	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions[$this->_tbl_prefix.'nome'] = array(
			'addValidator'=>array('NotEmpty'),
			'setRequired'=>true,
			'setAttrib'=>array('maxLength'=>'256', 'required'=>'true')
	     	);
	    $this->_fieldOptions[$this->_tbl_prefix.'abreviacao'] = array(
			'setAttrib'=>array('maxLength'=>'3', 'data'=>'upper')
			);

		$this->_lockedFields = array('id');
		$this->_orderField = $this->_tbl_prefix.'nome';
		$this->_searchField = $this->_tbl_prefix.'nome';
	    $this->_typeElement = array(
			$this->_tbl_prefix.'id' => Fgsl_Form_Constants::TEXT,
	  		$this->_tbl_prefix.'nome' => Fgsl_Form_Constants::TEXT,
	    	$this->_tbl_prefix.'abreviacao' => Fgsl_Form_Constants::TEXT
		);
		}
	}