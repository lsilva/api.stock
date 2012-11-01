<?php
class MovimentoItem extends Fgsl_Db_Table_Abstract
	{
	protected $_name = 'movimento_item';
	public function __construct()
		{
		parent::__construct();
		$this->_fieldKey = 'id';
        $this->_tbl_prefix = 'mvi_';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
            'id' => 'Código',
            'mvh_id' => 'Código do movimento',
            'prd_id' => 'Código do produto',
            $this->_tbl_prefix.'quantidade' => 'Quantidade',
            $this->_tbl_prefix.'valor' => 'Valor do item'
		    );
		$this->_orderField = 'id';
		$this->_searchField = 'id';
        $this->_typeElement = array(
            'id' => Fgsl_Form_Constants::HIDDEN,
            'mvh_id' => Fgsl_Form_Constants::TEXT,
            'prd_id' => Fgsl_Form_Constants::TEXT,
            $this->_tbl_prefix.'quantidade' => Fgsl_Form_Constants::TEXT,
            $this->_tbl_prefix.'valor' => Fgsl_Form_Constants::TEXT
            );
		}
    public function getCustomSelect($where,$order,$limit)
        {
        $field = $this->_getCols();
        $select = $this->getAdapter()->select();
        $select->from(self::$this->_name,$field);
        $select->joinInner(
            'produto',
            'produto.id = ' . self::$this->_name . '.prd_id',
            array('produto.prd_nome'));

        if($where!==null)
            $select->where($where);

        $select->order($order);
        $select->limit($limit);

        return $select;

        }
	}