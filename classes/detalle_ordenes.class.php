<?php 

/** 
 * detalle_ordenes 
 * 
 * 08/03/2018 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class detalle_ordenes { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_seguimiento = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_nro_ot = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_timestamp = Array('value' => null, 'datatype' => DBTYpe::String, 'validators' => array()); 
	 protected $_nro_linea = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_descripcion = Array('value' => null, 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_reingreso = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('digits' => true)); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto detalle_ordenes. Inicializa las propiedades del objeto.
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

	 public function set_id_seguimiento($p_id_seguimiento){ 
		 if(!DataValidator::validate($p_id_seguimiento, $this->_id_seguimiento['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_seguimiento</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_seguimiento['value'] = $p_id_seguimiento; 
	 } 
	 public function get_id_seguimiento(){ return $this->_id_seguimiento['value']; } 

	 public function set_nro_ot($p_nro_ot){ 
		 if(!DataValidator::validate($p_nro_ot, $this->_nro_ot['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>nro_ot</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_nro_ot['value'] = $p_nro_ot; 
	 } 
	 public function get_nro_ot(){ return $this->_nro_ot['value']; } 

	 public function set_timestamp($p_timestamp){ 
		 if(!DataValidator::validate($p_timestamp, $this->_timestamp['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>timestamp</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_timestamp['value'] = $p_timestamp; 
	 } 
	 public function get_timestamp(){ return $this->_timestamp['value']; } 

	 public function set_nro_linea($p_nro_linea){ 
		 if(!DataValidator::validate($p_nro_linea, $this->_nro_linea['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>nro_linea</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_nro_linea['value'] = $p_nro_linea; 
	 } 
	 public function get_nro_linea(){ return $this->_nro_linea['value']; } 

	 public function set_descripcion($p_descripcion){ 
		 if(!DataValidator::validate($p_descripcion, $this->_descripcion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>descripcion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_descripcion['value'] = $p_descripcion; 
	 } 
	 public function get_descripcion(){ return $this->_descripcion['value']; } 

	 public function set_reingreso($p_reingreso){ 
		 if(!DataValidator::validate($p_reingreso, $this->_reingreso['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>reingreso</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_reingreso['value'] = $p_reingreso; 
	 } 
	 public function get_reingreso(){ return $this->_reingreso['value']; } 

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
		 $query = new DBQuery('SELECT * FROM detalle_ordenes WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_id_seguimiento['value'] = $datos[0]['id_seguimiento']; 
			 $this->_nro_ot['value'] = $datos[0]['nro_ot']; 
			 $this->_timestamp['value'] = $datos[0]['timestamp']; 
			 $this->_nro_linea['value'] = $datos[0]['nro_linea']; 
			 $this->_descripcion['value'] = $datos[0]['descripcion']; 
			 $this->_reingreso['value'] = $datos[0]['reingreso']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_id_seguimiento['value'] = null; 
			 $this->_nro_ot['value'] = ''; 
			 $this->_timestamp['value'] = null; 
			 $this->_nro_linea['value'] = null; 
			 $this->_descripcion['value'] = null; 
			 $this->_reingreso['value'] = null; 
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
			 $query = new DBQuery('INSERT INTO detalle_ordenes(id_seguimiento, nro_ot, timestamp, nro_linea, descripcion, reingreso)VALUES({id_seguimiento}, {nro_ot}, {timestamp}, {nro_linea}, {descripcion}, {reingreso})'); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
			 $query->addParam('nro_ot', $this->_nro_ot['value'], $this->_nro_ot['datatype']); 
			 $query->addParam('timestamp', $this->_timestamp['value'], $this->_timestamp['datatype']); 
			 $query->addParam('nro_linea', $this->_nro_linea['value'], $this->_nro_linea['datatype']); 
			 $query->addParam('descripcion', $this->_descripcion['value'], $this->_descripcion['datatype']); 
			 $query->addParam('reingreso', $this->_reingreso['value'], $this->_reingreso['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE detalle_ordenes SET id_seguimiento = {id_seguimiento}, nro_ot = {nro_ot}, timestamp = {timestamp}, nro_linea = {nro_linea}, descripcion = {descripcion}, reingreso = {reingreso} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
			 $query->addParam('nro_ot', $this->_nro_ot['value'], $this->_nro_ot['datatype']); 
			 $query->addParam('timestamp', $this->_timestamp['value'], $this->_timestamp['datatype']); 
			 $query->addParam('nro_linea', $this->_nro_linea['value'], $this->_nro_linea['datatype']); 
			 $query->addParam('descripcion', $this->_descripcion['value'], $this->_descripcion['datatype']); 
			 $query->addParam('reingreso', $this->_reingreso['value'], $this->_reingreso['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
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
		 $query = new DBQuery('DELETE FROM detalle_ordenes WHERE id = {id}'); 
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

		 $sql_from = ' detalle_ordenes LEFT JOIN seguimiento_ordenes ON detalle_ordenes.id_seguimiento = seguimiento_ordenes.id  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  detalle_ordenes.* , seguimiento_ordenes.vehiculo_modelo as seguimiento_ordenes_vehiculo_modelo , seguimiento_ordenes.cliente as seguimiento_ordenes_cliente , seguimiento_ordenes.chasis as seguimiento_ordenes_chasis , seguimiento_ordenes.chapa as seguimiento_ordenes_chapa , seguimiento_ordenes.email_asesor as seguimiento_ordenes_email_asesor , seguimiento_ordenes.nro_asesor as seguimiento_ordenes_nro_asesor , seguimiento_ordenes.ot as seguimiento_ordenes_ot  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "detalle_ordenes.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "seguimiento_ordenes.vehiculo_modelo LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(detalle_ordenes.nro_ot) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "detalle_ordenes.nro_linea = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(detalle_ordenes.descripcion) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>