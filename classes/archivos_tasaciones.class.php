<?php 

/** 
 * archivos_tasaciones 
 * 
 * 16/01/2018 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class archivos_tasaciones { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_tasacion = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_tipo = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_archivo = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_monto_total = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto archivos_tasaciones. Inicializa las propiedades del objeto.
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

	 public function set_id_tasacion($p_id_tasacion){ 
		 if(!DataValidator::validate($p_id_tasacion, $this->_id_tasacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_tasacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_tasacion['value'] = $p_id_tasacion; 
	 } 
	 public function get_id_tasacion(){ return $this->_id_tasacion['value']; } 

	 public function set_tipo($p_tipo){ 
		 if(!DataValidator::validate($p_tipo, $this->_tipo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>tipo</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_tipo['value'] = $p_tipo; 
	 } 
	 public function get_tipo(){ return $this->_tipo['value']; } 

	 public function set_archivo($p_archivo){ 
		 if(!DataValidator::validate($p_archivo, $this->_archivo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>archivo</strong>:<br/>' . DataValidator::get_error_text()); 
		 // Si existe un archivo ya cargado se elimina del disco en caso de que el valor nuevo sea diferente. 
 		 if(strlen($this->get_archivo()) > 0 && $this->get_archivo() != $p_archivo){ 
 			 if(file_exists(CONF_ABS_UPLOAD_PATH . '/archivos_tasaciones/' . $this->get_archivo())){ 
 				 unlink(CONF_ABS_UPLOAD_PATH . '/archivos_tasaciones/' . $this->get_archivo()); 
 			 } 
 		 } 
 		 $this->_archivo['value'] = $p_archivo; 
	 } 
	 public function get_archivo(){ return $this->_archivo['value']; } 

	 public function set_monto_total($p_monto_total){ 
		 if(!DataValidator::validate($p_monto_total, $this->_monto_total['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>monto_total</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_monto_total['value'] = $p_monto_total; 
	 } 
	 public function get_monto_total(){ return $this->_monto_total['value']; } 

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
		 $query = new DBQuery('SELECT * FROM archivos_tasaciones WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_id_tasacion['value'] = $datos[0]['id_tasacion']; 
			 $this->_tipo['value'] = $datos[0]['tipo']; 
			 $this->_archivo['value'] = $datos[0]['archivo']; 
			 $this->_monto_total['value'] = $datos[0]['monto_total']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_id_tasacion['value'] = null; 
			 $this->_tipo['value'] = null; 
			 $this->_archivo['value'] = ''; 
			 $this->_monto_total['value'] = null; 
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
			 $query = new DBQuery('INSERT INTO archivos_tasaciones(id_tasacion, tipo, archivo, monto_total, fecha_creacion)VALUES({id_tasacion}, {tipo}, {archivo}, {monto_total}, {fecha_creacion})'); 
			 $query->addParam('id_tasacion', $this->_id_tasacion['value'], $this->_id_tasacion['datatype']); 
			 $query->addParam('tipo', $this->_tipo['value'], $this->_tipo['datatype']); 
			 $query->addParam('archivo', $this->_archivo['value'], $this->_archivo['datatype']); 
			 $query->addParam('monto_total', $this->_monto_total['value'], $this->_monto_total['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE archivos_tasaciones SET id_tasacion = {id_tasacion}, tipo = {tipo}, archivo = {archivo}, monto_total = {monto_total}, fecha_creacion = {fecha_creacion} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('id_tasacion', $this->_id_tasacion['value'], $this->_id_tasacion['datatype']); 
			 $query->addParam('tipo', $this->_tipo['value'], $this->_tipo['datatype']); 
			 $query->addParam('archivo', $this->_archivo['value'], $this->_archivo['datatype']); 
			 $query->addParam('monto_total', $this->_monto_total['value'], $this->_monto_total['datatype']); 
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
		 $query = new DBQuery('DELETE FROM archivos_tasaciones WHERE id = {id}'); 
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

		 $sql_from = ' archivos_tasaciones LEFT JOIN tasaciones ON archivos_tasaciones.id_tasacion = tasaciones.id  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  archivos_tasaciones.* , tasaciones.nombre_apellido_cliente as tasaciones_nombre_apellido_cliente , tasaciones.ciudad as tasaciones_ciudad , tasaciones.direccion as tasaciones_direccion , tasaciones.telefono as tasaciones_telefono , tasaciones.chasis as tasaciones_chasis , tasaciones.chapa as tasaciones_tipo , tasaciones.color as tasaciones_color , tasaciones.combustible as tasaciones_combustible  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "archivos_tasaciones.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "tasaciones.nombre_apellido_cliente LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(CAST(archivos_tasaciones.tipo AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(archivos_tasaciones.archivo) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "archivos_tasaciones.monto_total = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>