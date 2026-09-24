<?php 

/** 
 * estados_ordenes 
 * 
 * 23/01/2018 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class estados_ordenes { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_estado = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_uso = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true));
	 protected $_orden = Array('value' => '', 'datatype' => DBType::String, 'validators' => array());
	 protected $_color = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto estados_ordenes. Inicializa las propiedades del objeto.
	  */ 
	 public function __construct() { 
		 $this->_dbmanager = new DBManager(); 
	 } 

	 /************************************ 
	  * PROPIEDADES PUBLICAS DE LA CLASE * 
	  ************************************/ 

	 public function set_id($p_id){ 
		 $this->_id['value'] = $p_id; 
	 } 
	 public function get_id(){ return $this->_id['value']; } 

	 public function set_estado($p_estado){ 
		 if(!DataValidator::validate($p_estado, $this->_estado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>estado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_estado['value'] = $p_estado; 
	 } 
	 public function get_estado(){ return $this->_estado['value']; } 

	 public function set_uso($p_uso){ 
		 if(!DataValidator::validate($p_uso, $this->_uso['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>uso</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_uso['value'] = $p_uso; 
	 } 
	 public function get_uso(){ return $this->_uso['value']; } 

	 public function set_orden($p_orden){ 
		 if(!DataValidator::validate($p_orden, $this->_orden['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>orden</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_orden['value'] = $p_orden; 
	 } 
	 public function get_orden(){ return $this->_orden['value']; } 

	 public function set_color($p_color){ 
		 if(!DataValidator::validate($p_color, $this->_color['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>color</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_color['value'] = $p_color; 
	 } 
	 public function get_color(){ return $this->_color['value']; } 

	 public function set_fecha_creacion($p_fecha_creacion){ 
		 if(!DataValidator::validate($p_fecha_creacion, $this->_fecha_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_creacion['value'] = $p_fecha_creacion; 
	 } 
	 public function get_fecha_creacion(){ return $this->_fecha_creacion['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM estados_ordenes WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_estado['value'] = $datos[0]['estado']; 
			 $this->_uso['value'] = $datos[0]['uso']; 
			 $this->_orden['value'] = $datos[0]['orden']; 
			 $this->_color['value'] = $datos[0]['color']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_estado['value'] = '';
			 $this->_uso['value'] = '';  
			 $this->_orden['value'] = ''; 
			 $this->_color['value'] = ''; 
			 $this->_fecha_creacion['value'] = null; 
		 } 
		 return ($this->_id['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id['value'] == null) { 
			 $query = new DBQuery('INSERT INTO estados_ordenes(estado,uso, color, orden)VALUES({estado},{uso}, {color}, {orden})'); 
			 $query->addParam('estado', $this->_estado['value'], $this->_estado['datatype']); 
			 $query->addParam('uso', $this->_uso['value'], $this->_uso['datatype']); 
			 $query->addParam('color', $this->_color['value'], $this->_color['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('orden', $this->_orden['value'], $this->_orden['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE estados_ordenes SET estado = {estado},uso = {uso}, color = {color}, orden = {orden} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('estado', $this->_estado['value'], $this->_estado['datatype']); 
			 $query->addParam('uso', $this->_uso['value'], $this->_uso['datatype']); 
			 $query->addParam('color', $this->_color['value'], $this->_color['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('orden', $this->_orden['value'], $this->_orden['datatype']); 
		 } 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($this->get_id() == null) { $this->set_id($this->_dbmanager->lastID()); } 
		 return ($filas_afectadas == -1)?false:true; 
	 } 

	 /** 
	  * Elimina un registro de la base de datos.
	  * @return Boolean Verdadero cuando el registro se elimino correctamente. 
	  */ 
	 public function elimina() { 
		 $query = new DBQuery('DELETE FROM estados_ordenes WHERE id = {id}'); 
		 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
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

		 $sql_from = ' estados_ordenes  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  estados_ordenes.*  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "estados_ordenes.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(estados_ordenes.estado) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(estados_ordenes.color) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>