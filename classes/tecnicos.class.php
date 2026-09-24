<?php 

/** 
 * tecnicos 
 * 
 * 07/02/2019 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class tecnicos { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_nro_tecnico = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_tecnico = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_estado = Array('value' => null, 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_id_jefe = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto tecnicos. Inicializa las propiedades del objeto.
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

	 public function set_nro_tecnico($p_nro_tecnico){ 
		 if(!DataValidator::validate($p_nro_tecnico, $this->_nro_tecnico['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>nro_tecnico</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_nro_tecnico['value'] = $p_nro_tecnico; 
	 } 
	 public function get_nro_tecnico(){ return $this->_nro_tecnico['value']; } 

	 public function set_tecnico($p_tecnico){ 
		 if(!DataValidator::validate($p_tecnico, $this->_tecnico['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>tecnico</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_tecnico['value'] = $p_tecnico; 
	 } 
	 public function get_tecnico(){ return $this->_tecnico['value']; } 

	 public function set_estado($p_estado){ 
		 if(!DataValidator::validate($p_estado, $this->_estado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>estado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_estado['value'] = $p_estado; 
	 } 
	 public function get_estado(){ return $this->_estado['value']; } 

	 public function set_fecha_creacion($p_fecha_creacion){ 
		 if(!DataValidator::validate($p_fecha_creacion, $this->_fecha_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_creacion['value'] = $p_fecha_creacion; 
	 } 
	 public function get_fecha_creacion(){ return $this->_fecha_creacion['value']; } 

	 public function set_id_jefe($p_id_jefe){ 
		 if(!DataValidator::validate($p_id_jefe, $this->_id_jefe['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_jefe</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_jefe['value'] = $p_id_jefe; 
	 } 
	 public function get_id_jefe(){ return $this->_id_jefe['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM tecnicos WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_nro_tecnico['value'] = $datos[0]['nro_tecnico']; 
			 $this->_tecnico['value'] = $datos[0]['tecnico']; 
			 $this->_estado['value'] = $datos[0]['estado']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
			 $this->_id_jefe['value'] = $datos[0]['id_jefe']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_nro_tecnico['value'] = null; 
			 $this->_tecnico['value'] = ''; 
			 $this->_estado['value'] = null; 
			 $this->_fecha_creacion['value'] = null; 
			 $this->_id_jefe['value'] = null; 
		 } 
		 return ($this->_id['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id['value'] == null) { 
			 $query = new DBQuery('INSERT INTO tecnicos(nro_tecnico, tecnico, estado, id_jefe)VALUES({nro_tecnico}, {tecnico}, {estado}, {id_jefe})'); 
			 $query->addParam('nro_tecnico', $this->_nro_tecnico['value'], $this->_nro_tecnico['datatype']); 
			 $query->addParam('tecnico', $this->_tecnico['value'], $this->_tecnico['datatype']); 
			 $query->addParam('estado', $this->_estado['value'], $this->_estado['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('id_jefe', $this->_id_jefe['value'], $this->_id_jefe['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE tecnicos SET nro_tecnico = {nro_tecnico}, tecnico = {tecnico}, estado = {estado}, id_jefe = {id_jefe} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('nro_tecnico', $this->_nro_tecnico['value'], $this->_nro_tecnico['datatype']); 
			 $query->addParam('tecnico', $this->_tecnico['value'], $this->_tecnico['datatype']); 
			 $query->addParam('estado', $this->_estado['value'], $this->_estado['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('id_jefe', $this->_id_jefe['value'], $this->_id_jefe['datatype']); 
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
		 $query = new DBQuery('DELETE FROM tecnicos WHERE id = {id}'); 
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

		 $sql_from = ' tecnicos LEFT JOIN jefes_grupos ON tecnicos.id_jefe = jefes_grupos.id  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  tecnicos.* , jefes_grupos.nombre_apellido as jefes_grupos_nombre_apellido  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "tecnicos.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "tecnicos.nro_tecnico = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(tecnicos.tecnico) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "jefes_grupos.nombre_apellido LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>