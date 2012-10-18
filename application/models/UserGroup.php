<?php
class UserGroup extends Fgsl_Db_Table_Abstract
{
	protected $_name = 'papeis';
	protected $_dependentTables = array('PapelFuncionario');
	public function __construct()
	{
		parent::__construct();
		$this->_fieldKey = 'id';
		$this->_fieldNames = $this->_getCols();
		$this->_fieldLabels = array(
		'id' => 'Id',
		'nome' => 'Nome'
		);
	    $this->_fieldOptions = array();
	    $this->_fieldOptions['nome'] = array(
	      'addValidator'=>array('NotEmpty'),
	      'setRequired'=>true,
	      'setAttrib'=>array('maxLength'=>'512', 'required'=>'true')
	      );
	      		
		$this->_lockedFields = array('id');
		$this->_orderField = 'nome';
		$this->_searchField = 'nome';
		$this->_selectOptions = array();
		$this->_typeElement = array(
		'nome' => Fgsl_Form_Constants::TEXT
		);
		$this->_typeValue = array(
		'id' => self::INT_TYPE
		);
	}
	/**
	 * Seleciona um linha na tabela utilizando
	 * o nome do papel para efetuar a busca
	 *
	 * @param Sring $paper
	 * @return Array
	 */
	public function getDataByNamePapel($paper)
		{
		$result = $this->fetchRow('nome=\''.$paper.'\'');
		if(!$result)
			return false;

		return $result->toArray();
		}
}