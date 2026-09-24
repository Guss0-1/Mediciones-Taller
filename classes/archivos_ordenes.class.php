<?php 

/** 
 * archivos_ordenes 
 * 
 * 29/03/2019 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class archivos_ordenes { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_archivo = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_nombre = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_id_usuario = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_id_seguimiento = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto archivos_ordenes. Inicializa las propiedades del objeto.
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

	 public function set_archivo($p_archivo){ 
		 if(!DataValidator::validate($p_archivo, $this->_archivo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>archivo</strong>:<br/>' . DataValidator::get_error_text()); 
		 // Si existe un archivo ya cargado se elimina del disco en caso de que el valor nuevo sea diferente. 
 		 if(strlen($this->get_archivo()) > 0 && $this->get_archivo() != $p_archivo){ 
 			 if(file_exists(CONF_ABS_UPLOAD_PATH . '/archivos_ordenes/' . $this->get_archivo())){ 
 				 unlink(CONF_ABS_UPLOAD_PATH . '/archivos_ordenes/' . $this->get_archivo()); 
 			 } 
 		 } 
 		 $this->_archivo['value'] = $p_archivo; 
	 } 
	 public function get_archivo(){ return $this->_archivo['value']; } 

	 public function set_nombre($p_nombre){ 
		 if(!DataValidator::validate($p_nombre, $this->_nombre['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>nombre</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_nombre['value'] = $p_nombre; 
	 } 
	 public function get_nombre(){ return $this->_nombre['value']; } 

	 public function set_id_usuario($p_id_usuario){ 
		 if(!DataValidator::validate($p_id_usuario, $this->_id_usuario['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_usuario</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_usuario['value'] = $p_id_usuario; 
	 } 
	 public function get_id_usuario(){ return $this->_id_usuario['value']; } 

	 public function set_fecha_creacion($p_fecha_creacion){ 
		 if(!DataValidator::validate($p_fecha_creacion, $this->_fecha_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_creacion['value'] = $p_fecha_creacion; 
	 } 
	 public function get_fecha_creacion(){ return $this->_fecha_creacion['value']; } 

	 public function set_id_seguimiento($p_id_seguimiento){ 
		 if(!DataValidator::validate($p_id_seguimiento, $this->_id_seguimiento['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_seguimiento</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_seguimiento['value'] = $p_id_seguimiento; 
	 } 
	 public function get_id_seguimiento(){ return $this->_id_seguimiento['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM archivos_ordenes WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_archivo['value'] = $datos[0]['archivo']; 
			 $this->_nombre['value'] = $datos[0]['nombre']; 
			 $this->_id_usuario['value'] = $datos[0]['id_usuario']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
			 $this->_id_seguimiento['value'] = $datos[0]['id_seguimiento']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_archivo['value'] = ''; 
			 $this->_nombre['value'] = ''; 
			 $this->_id_usuario['value'] = null; 
			 $this->_fecha_creacion['value'] = null; 
			 $this->_id_seguimiento['value'] = null; 
		 } 
		 return ($this->_id['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id['value'] == null) { 
			 $query = new DBQuery('INSERT INTO archivos_ordenes(archivo, nombre, id_usuario, fecha_creacion, id_seguimiento)VALUES({archivo}, {nombre}, {id_usuario}, {fecha_creacion}, {id_seguimiento})'); 
			 $query->addParam('archivo', $this->_archivo['value'], $this->_archivo['datatype']); 
			 $query->addParam('nombre', $this->_nombre['value'], $this->_nombre['datatype']); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE archivos_ordenes SET archivo = {archivo}, nombre = {nombre}, id_usuario = {id_usuario}, fecha_creacion = {fecha_creacion}, id_seguimiento = {id_seguimiento} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('archivo', $this->_archivo['value'], $this->_archivo['datatype']); 
			 $query->addParam('nombre', $this->_nombre['value'], $this->_nombre['datatype']); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
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
		 $query = new DBQuery('DELETE FROM archivos_ordenes WHERE id = {id}'); 
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

		 $sql_from = ' archivos_ordenes LEFT JOIN seguimiento_ordenes ON archivos_ordenes.id_seguimiento = seguimiento_ordenes.id LEFT JOIN usuarios ON archivos_ordenes.id_usuario = usuarios.id_usuario  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  archivos_ordenes.* , seguimiento_ordenes.vehiculo_modelo as seguimiento_ordenes_vehiculo_modelo , seguimiento_ordenes.cliente as seguimiento_ordenes_cliente , seguimiento_ordenes.chasis as seguimiento_ordenes_chasis , seguimiento_ordenes.chapa as seguimiento_ordenes_chapa , seguimiento_ordenes.email_asesor as seguimiento_ordenes_email_asesor , seguimiento_ordenes.nro_asesor as seguimiento_ordenes_nro_asesor , seguimiento_ordenes.ot as seguimiento_ordenes_ot , seguimiento_ordenes.ci as seguimiento_ordenes_ci , usuarios.usuario as usuarios_usuario , usuarios.clave as usuarios_clave , usuarios.nombre as usuarios_nombre , usuarios.apellido as usuarios_apellido , usuarios.email as usuarios_email  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "archivos_ordenes.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(archivos_ordenes.archivo) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(archivos_ordenes.nombre) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "usuarios.usuario LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "seguimiento_ordenes.vehiculo_modelo LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>