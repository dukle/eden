<?php //-->
/*
 * This file is part of the Eden package.
 * (c) 2011-2012 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

/**
 * Sql Collection handler
 *
 * @package    Eden
 * @category   sql
 * @author     Christian Blanquera cblanquera@openovate.com
 */
class Eden_Sql_Collection extends Eden_Collection {
	/* Constants
	-------------------------------*/
	/* Public Properties
	-------------------------------*/
	/* Protected Properties
	-------------------------------*/
	protected $_model 		= Eden_Sql_Database::MODEL;
	protected $_database	= NULL;
	protected $_table		= NULL;
	
	/* Private Properties
	-------------------------------*/
	/* Magic
	-------------------------------*/
	public static function i() {
		return self::_getMultiple(__CLASS__);
	}
	
	/* Public Methods
	-------------------------------*/
	/**
	 * Sets the default database
	 *
	 * @param Eden_Sql
	 */
	public function setDatabase(Eden_Sql_Database $database) {
		$this->_database = $database;
		
		//for each row
		foreach($this->_list as $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			//let the row handle this
			$row->setDatabase($database);
		}
		
		return $this;
	}
	
	/**
	 * Sets the default database
	 *
	 * @param string
	 */
	public function setTable($table) {
		//Argument 1 must be a string
		Eden_Sql_Error::i()->argument(1, 'string');
		
		$this->_table = $table;
		
		//for each row
		foreach($this->_list as $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			//let the row handle this
			$row->setTable($table);
		}
		
		return $this;
	}
	
	/**
	 * Sets default model
	 *
	 * @param string
	 * @return this
	 */
	public function setModel($model) {
		$error = Eden_Sql_Error::i()->argument(1, 'string');
		
		if(!is_subclass_of($model, 'Eden_Model')) {
			$error->setMessage(Eden_Sql_Error::NOT_SUB_MODEL)
				->addVariable($model)
				->trigger();
		}
		
		$this->_model = $model;
		return $this;
	}
	
	/**
	 * Useful method for formating a time column.
	 * 
	 * @param string
	 * @param string
	 * @return this
	 */
	public function formatTime($column, $format = Eden_Sql_Model::DATETIME) {
		//for each row
		foreach($this->_list as $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			//let the row handle this
			$row->formatTime($column, $format);
		}
		
		return $this;
	}
	
	/**
	 * Adds a row to the collection
	 *
	 * @param array|Eden_Model
	 * @return this
	 */
	public function add($row = array()) {
		//Argument 1 must be an array or Eden_Model
		Eden_Sql_Error::i()->argument(1, 'array', $this->_model);
		
		//if it's an array
		if(is_array($row)) {
			//make it a model
			$model = $this->_model;
			$row = $this->$model($row);
		}
		
		if(!is_null($this->_database)) {
			$row->setDatabase($this->_database);
		}
		
		if(!is_null($this->_table)) {
			$row->setTable($this->_table);
		}
		
		//add it now
		$this->_list[] = $row;
		
		return $this;
	}
	
	/**
	 * Insert collection to database
	 *
	 * @param string
	 * @param Eden_Sql
	 * @return this
	 */
	public function insert($table = NULL, Eden_Sql_Database $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			$row->insert($table, $database);
		}
		
		return $this;
	}
	
	/**
	 * Updates collection to database
	 *
	 * @param string
	 * @param Eden_Sql
	 * @return this
	 */
	public function update($table = NULL, Eden_Sql_Database $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			$row->update($table, $database);
		}
		
		return $this;
	}
	
	/**
	 * Inserts or updates collection to database
	 *
	 * @param string
	 * @param Eden_Sql
	 * @return this
	 */
	public function save($table = NULL, Eden_Sql_Database $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			$row->save($table, $database);
		}
		
		return $this;
	}
	
	/**
	 * Removes collection from database
	 *
	 * @param string
	 * @param Eden_Sql
	 * @return this
	 */
	public function remove($table = NULL, Eden_Sql_Database $database = NULL) {
		//for each row
		foreach($this->_list as $i => $row) {
			if(!is_object($row) || !method_exists($row, __FUNCTION__)) {
				continue;
			}
			
			//let the row handle this
			$row->remove($table, $database);
		}
		
		return $this;
	}
	
	/* Protected Methods
	-------------------------------*/
	/* Private Methods
	-------------------------------*/
}