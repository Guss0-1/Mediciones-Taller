<?php 

/** 
 * roles 
 * 
 * 22/03/2017 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class roles { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id_rol = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_rol = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_editable = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto roles. Inicializa las propiedades del objeto.
	  */ 
	 public function __construct() { 
		 $this->_dbmanager = new DBManager(); 
	 } 

	 /************************************ 
	  * PROPIEDADES PUBLICAS DE LA CLASE * 
	  ************************************/ 

	 public function set_id_rol($p_id_rol){ 
		 $this->_id_rol['value'] = $p_id_rol; 
	 } 
	 public function get_id_rol(){ return $this->_id_rol['value']; } 

	 public function set_rol($p_rol){ 
		 if(!DataValidator::validate($p_rol, $this->_rol['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>rol</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_rol['value'] = $p_rol; 
	 } 
	 public function get_rol(){ return $this->_rol['value']; } 

	 public function set_editable($p_editable){ 
		 if(!DataValidator::validate($p_editable, $this->_editable['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>editable</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_editable['value'] = $p_editable; 
	 } 
	 public function get_editable(){ return $this->_editable['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id_rol ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id_rol) { 
		 $query = new DBQuery('SELECT * FROM roles WHERE id_rol = {id_rol}'); 
		 $query->addParam('id_rol', $p_id_rol, $this->_id_rol['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id_rol['value'] = $datos[0]['id_rol']; 
			 $this->_rol['value'] = $datos[0]['rol']; 
			 $this->_editable['value'] = $datos[0]['editable']; 
		 }else{ 
			 $this->_id_rol['value'] = null; 
			 $this->_rol['value'] = ''; 
			 $this->_editable['value'] = null; 
		 } 
		 return ($this->_id_rol['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id_rol['value'] == null) { 
			 $query = new DBQuery('INSERT INTO roles(rol, editable)VALUES({rol}, {editable})'); 
			 $query->addParam('rol', $this->_rol['value'], $this->_rol['datatype']); 
			 $query->addParam('editable', $this->_editable['value'], $this->_editable['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE roles SET rol = {rol}, editable = {editable} WHERE id_rol = {id_rol}'); 
			 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
			 $query->addParam('rol', $this->_rol['value'], $this->_rol['datatype']); 
			 $query->addParam('editable', $this->_editable['value'], $this->_editable['datatype']); 
		 } 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($this->get_id_rol() == null) { $this->set_id_rol($this->_dbmanager->lastID()); } 
		 return ($filas_afectadas == -1)?false:true; 
	 } 

	 /** 
	  * Elimina un registro de la base de datos.
	  * @return Boolean Verdadero cuando el registro se elimino correctamente. 
	  */ 
	 public function elimina() { 
		 $query = new DBQuery('DELETE FROM roles WHERE id_rol = {id_rol}'); 
		 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($filas_afectadas == -1) { 
			 return false; 
		 } 
		 return true; 
	 } 

	 /** 
	  * Recupera lista de registros de la tabla.
	  * @param Array Lista de opciones utilizadas para recuperar los datos. 
	  * 	Las opciones validas son: filtro, buscar, reg_x_pag, num_pagina, paginar, orden. 
	  * @return Array Datos de la tabla. 
	  */ 
	 public static function lista($p_opciones) { 

		 $dbmanager = new DBManager(); 
		 $filtro = (isset($p_opciones['filtro'])) ? $p_opciones['filtro'] : ''; 
		 if(isset($p_opciones['buscar'])) { $filtro = self::recupera_filtro_global($p_opciones['buscar'], $filtro); } 
		 $reg_x_pag = (isset($p_opciones['reg_x_pag'])) ? $p_opciones['reg_x_pag'] : CONF_REG_X_PAG; 
		 $num_pagina = (isset($p_opciones['num_pagina'])) ? $p_opciones['num_pagina'] : 1; 
		 $paginar = (isset($p_opciones['paginar'])) ? $p_opciones['paginar'] : true; 
		 $orden = (isset($p_opciones['orden'])) ? ' ORDER BY ' . $p_opciones['orden'] : ''; 

		 $sql_from = ' roles  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  roles.*  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
		 if($paginar === true){ 
			 $sql.= ' LIMIT ' . $num_inicio . ', ' . $reg_x_pag; 
		 } 
		 $datos = $dbmanager->executeQuery(new DBQuery($sql)); 

		 $retorno = array('datos' => $datos, 'cant_paginas' => $cant_paginas); 
		 return $retorno; 
	 } 

	 protected static function recupera_filtro_global($p_valor, $p_filtro = '') { 
		 $filtro = ''; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "roles.id_rol = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(roles.rol) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(CAST(roles.editable AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>