<?php
class MovimentoItem extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'movimento_item';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
            'id' => 'Código',
            'mov_id' => 'Código do movimento',
            'pro_id' => 'Código do produto',
            'quantidade' => 'Quantidade',
            'valor' => 'Valor do item'
		    );
		$this->_orderField = 'id';
		$this->_searchField = 'id';
        $this->_typeElement = array(
            'id' => Fgsl_Form_Constants::HIDDEN,
            'mov_id' => Fgsl_Form_Constants::TEXT,
            'pro_id' => Fgsl_Form_Constants::TEXT,
            'quantidade' => Fgsl_Form_Constants::TEXT,
            'valor' => Fgsl_Form_Constants::TEXT
            );
		}
	}