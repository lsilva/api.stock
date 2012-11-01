<?php
class Marca extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'marca';
	protected $_title = 'Marcas';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_tbl_prefix = 'mrc_';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
			'id' => 'ID Marca',
		  	$this->_tbl_prefix.'titulo' => 'Descrição',
		  	$this->_tbl_prefix.'site' => 'Site'
			);
	    //Seta atributos especias para os fields
	    $this->_fieldOptions = array();
	    $this->_fieldOptions[$this->_tbl_prefix.'titulo'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'256', 'required'=>'true')
	      );
	    $this->_fieldOptions[$this->_tbl_prefix.'site'] = array(
	      'setAttrib'=>array('maxLength'=>'512', 'data'=>'host')
	      );

		$this->_lockedFields = array('id');
		$this->_orderField = $this->_tbl_prefix.'titulo';
		$this->_searchField = $this->_tbl_prefix.'titulo';
	    $this->_typeElement = array(
			'id' => Fgsl_Form_Constants::TEXT,
	  		$this->_tbl_prefix.'titulo' => Fgsl_Form_Constants::TEXT,
	    	$this->_tbl_prefix.'site' => Fgsl_Form_Constants::TEXT
		);
		}
	}