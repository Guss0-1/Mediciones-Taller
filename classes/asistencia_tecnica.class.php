<?php 

/** 
 * asistencia_tecnica 
 * 
 * 13/07/2019 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class asistencia_tecnica { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_at = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_ot = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_vehiculo_modelo = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_cliente = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_chasis = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_chapa = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array('required' => true)); 
	 protected $_fecha_edicion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array('required' => true)); 
	 protected $_fecha_terminado = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array('required' => true)); 
	 protected $_id_usuario_creacion = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_id_usuario_edicion = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_solicitud = Array('value' => null, 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_observacion = Array('value' => null, 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_id_estado = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_id_tecnico = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto asistencia_tecnica. Inicializa las propiedades del objeto.
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

	 public function set_at($p_at){ 
		 if(!DataValidator::validate($p_at, $this->_at['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>at</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_at['value'] = $p_at; 
	 } 
	 public function get_at(){ return $this->_at['value']; } 

	 public function set_ot($p_ot){ 
		 if(!DataValidator::validate($p_ot, $this->_ot['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>ot</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_ot['value'] = $p_ot; 
	 } 
	 public function get_ot(){ return $this->_ot['value']; } 

	 public function set_vehiculo_modelo($p_vehiculo_modelo){ 
		 if(!DataValidator::validate($p_vehiculo_modelo, $this->_vehiculo_modelo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>vehiculo_modelo</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_vehiculo_modelo['value'] = $p_vehiculo_modelo; 
	 } 
	 public function get_vehiculo_modelo(){ return $this->_vehiculo_modelo['value']; } 

	 public function set_cliente($p_cliente){ 
		 if(!DataValidator::validate($p_cliente, $this->_cliente['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>cliente</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_cliente['value'] = $p_cliente; 
	 } 
	 public function get_cliente(){ return $this->_cliente['value']; } 

	 public function set_chasis($p_chasis){ 
		 if(!DataValidator::validate($p_chasis, $this->_chasis['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>chasis</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_chasis['value'] = $p_chasis; 
	 } 
	 public function get_chasis(){ return $this->_chasis['value']; } 

	 public function set_chapa($p_chapa){ 
		 if(!DataValidator::validate($p_chapa, $this->_chapa['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>chapa</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_chapa['value'] = $p_chapa; 
	 } 
	 public function get_chapa(){ return $this->_chapa['value']; } 

	 public function set_fecha_creacion($p_fecha_creacion){ 
		 if(!DataValidator::validate($p_fecha_creacion, $this->_fecha_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_creacion['value'] = $p_fecha_creacion; 
	 } 
	 public function get_fecha_creacion(){ return $this->_fecha_creacion['value']; } 

	 public function set_fecha_edicion($p_fecha_edicion){ 
		 if(!DataValidator::validate($p_fecha_edicion, $this->_fecha_edicion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_edicion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_edicion['value'] = $p_fecha_edicion; 
	 } 
	 public function get_fecha_edicion(){ return $this->_fecha_edicion['value']; } 

	 public function set_fecha_terminado($p_fecha_terminado){ 
		 if(!DataValidator::validate($p_fecha_terminado, $this->_fecha_terminado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_terminado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_terminado['value'] = $p_fecha_terminado; 
	 } 
	 public function get_fecha_terminado(){ return $this->_fecha_terminado['value']; } 

	 public function set_id_usuario_creacion($p_id_usuario_creacion){ 
		 if(!DataValidator::validate($p_id_usuario_creacion, $this->_id_usuario_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_usuario_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_usuario_creacion['value'] = $p_id_usuario_creacion; 
	 } 
	 public function get_id_usuario_creacion(){ return $this->_id_usuario_creacion['value']; } 

	 public function set_id_usuario_edicion($p_id_usuario_edicion){ 
		 if(!DataValidator::validate($p_id_usuario_edicion, $this->_id_usuario_edicion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_usuario_edicion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_usuario_edicion['value'] = $p_id_usuario_edicion; 
	 } 
	 public function get_id_usuario_edicion(){ return $this->_id_usuario_edicion['value']; } 

	 public function set_solicitud($p_solicitud){ 
		 if(!DataValidator::validate($p_solicitud, $this->_solicitud['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>solicitud</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_solicitud['value'] = $p_solicitud; 
	 } 
	 public function get_solicitud(){ return $this->_solicitud['value']; } 

	 public function set_observacion($p_observacion){ 
		 if(!DataValidator::validate($p_observacion, $this->_observacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>observacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_observacion['value'] = $p_observacion; 
	 } 
	 public function get_observacion(){ return $this->_observacion['value']; } 

	 public function set_id_estado($p_id_estado){ 
		 if(!DataValidator::validate($p_id_estado, $this->_id_estado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_estado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_estado['value'] = $p_id_estado; 
	 } 
	 public function get_id_estado(){ return $this->_id_estado['value']; } 

	 public function set_id_tecnico($p_id_tecnico){ 
		 if(!DataValidator::validate($p_id_tecnico, $this->_id_tecnico['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_tecnico</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_tecnico['value'] = $p_id_tecnico; 
	 } 
	 public function get_id_tecnico(){ return $this->_id_tecnico['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM asistencia_tecnica WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_at['value'] = $datos[0]['at']; 
			 $this->_ot['value'] = $datos[0]['ot']; 
			 $this->_vehiculo_modelo['value'] = $datos[0]['vehiculo_modelo']; 
			 $this->_cliente['value'] = $datos[0]['cliente']; 
			 $this->_chasis['value'] = $datos[0]['chasis']; 
			 $this->_chapa['value'] = $datos[0]['chapa']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
			 $this->_fecha_edicion['value'] = $datos[0]['fecha_edicion']; 
			 $this->_fecha_terminado['value'] = $datos[0]['fecha_terminado']; 
			 $this->_id_usuario_creacion['value'] = $datos[0]['id_usuario_creacion']; 
			 $this->_id_usuario_edicion['value'] = $datos[0]['id_usuario_edicion']; 
			 $this->_solicitud['value'] = $datos[0]['solicitud']; 
			 $this->_observacion['value'] = $datos[0]['observacion']; 
			 $this->_id_estado['value'] = $datos[0]['id_estado']; 
			 $this->_id_tecnico['value'] = $datos[0]['id_tecnico']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_at['value'] = ''; 
			 $this->_ot['value'] = ''; 
			 $this->_vehiculo_modelo['value'] = ''; 
			 $this->_cliente['value'] = ''; 
			 $this->_chasis['value'] = ''; 
			 $this->_chapa['value'] = ''; 
			 $this->_fecha_creacion['value'] = null; 
			 $this->_fecha_edicion['value'] = null; 
			 $this->_fecha_terminado['value'] = null; 
			 $this->_id_usuario_creacion['value'] = null; 
			 $this->_id_usuario_edicion['value'] = null; 
			 $this->_solicitud['value'] = null; 
			 $this->_observacion['value'] = null; 
			 $this->_id_estado['value'] = null; 
			 $this->_id_tecnico['value'] = null; 
		 } 
		 return ($this->_id['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id['value'] == null) { 
			 $query = new DBQuery('INSERT INTO asistencia_tecnica(at, ot, vehiculo_modelo, cliente, chasis, chapa, fecha_creacion, fecha_edicion, fecha_terminado, id_usuario_creacion, id_usuario_edicion, solicitud, observacion, id_estado, id_tecnico)VALUES({at}, {ot}, {vehiculo_modelo}, {cliente}, {chasis}, {chapa}, {fecha_creacion}, {fecha_edicion}, {fecha_terminado}, {id_usuario_creacion}, {id_usuario_edicion}, {solicitud}, {observacion}, {id_estado}, {id_tecnico})'); 
			 $query->addParam('at', $this->_at['value'], $this->_at['datatype']); 
			 $query->addParam('ot', $this->_ot['value'], $this->_ot['datatype']); 
			 $query->addParam('vehiculo_modelo', $this->_vehiculo_modelo['value'], $this->_vehiculo_modelo['datatype']); 
			 $query->addParam('cliente', $this->_cliente['value'], $this->_cliente['datatype']); 
			 $query->addParam('chasis', $this->_chasis['value'], $this->_chasis['datatype']); 
			 $query->addParam('chapa', $this->_chapa['value'], $this->_chapa['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('fecha_edicion', $this->_fecha_edicion['value'], $this->_fecha_edicion['datatype']); 
			 $query->addParam('fecha_terminado', $this->_fecha_terminado['value'], $this->_fecha_terminado['datatype']); 
			 $query->addParam('id_usuario_creacion', $this->_id_usuario_creacion['value'], $this->_id_usuario_creacion['datatype']); 
			 $query->addParam('id_usuario_edicion', $this->_id_usuario_edicion['value'], $this->_id_usuario_edicion['datatype']); 
			 $query->addParam('solicitud', $this->_solicitud['value'], $this->_solicitud['datatype']); 
			 $query->addParam('observacion', $this->_observacion['value'], $this->_observacion['datatype']); 
			 $query->addParam('id_estado', $this->_id_estado['value'], $this->_id_estado['datatype']); 
			 $query->addParam('id_tecnico', $this->_id_tecnico['value'], $this->_id_tecnico['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE asistencia_tecnica SET at = {at}, ot = {ot}, vehiculo_modelo = {vehiculo_modelo}, cliente = {cliente}, chasis = {chasis}, chapa = {chapa}, fecha_creacion = {fecha_creacion}, fecha_edicion = {fecha_edicion}, fecha_terminado = {fecha_terminado}, id_usuario_creacion = {id_usuario_creacion}, id_usuario_edicion = {id_usuario_edicion}, solicitud = {solicitud}, observacion = {observacion}, id_estado = {id_estado}, id_tecnico = {id_tecnico} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('at', $this->_at['value'], $this->_at['datatype']); 
			 $query->addParam('ot', $this->_ot['value'], $this->_ot['datatype']); 
			 $query->addParam('vehiculo_modelo', $this->_vehiculo_modelo['value'], $this->_vehiculo_modelo['datatype']); 
			 $query->addParam('cliente', $this->_cliente['value'], $this->_cliente['datatype']); 
			 $query->addParam('chasis', $this->_chasis['value'], $this->_chasis['datatype']); 
			 $query->addParam('chapa', $this->_chapa['value'], $this->_chapa['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('fecha_edicion', $this->_fecha_edicion['value'], $this->_fecha_edicion['datatype']); 
			 $query->addParam('fecha_terminado', $this->_fecha_terminado['value'], $this->_fecha_terminado['datatype']); 
			 $query->addParam('id_usuario_creacion', $this->_id_usuario_creacion['value'], $this->_id_usuario_creacion['datatype']); 
			 $query->addParam('id_usuario_edicion', $this->_id_usuario_edicion['value'], $this->_id_usuario_edicion['datatype']); 
			 $query->addParam('solicitud', $this->_solicitud['value'], $this->_solicitud['datatype']); 
			 $query->addParam('observacion', $this->_observacion['value'], $this->_observacion['datatype']); 
			 $query->addParam('id_estado', $this->_id_estado['value'], $this->_id_estado['datatype']); 
			 $query->addParam('id_tecnico', $this->_id_tecnico['value'], $this->_id_tecnico['datatype']); 
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
		 $query = new DBQuery('DELETE FROM asistencia_tecnica WHERE id = {id}'); 
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

		 $sql_from = ' asistencia_tecnica LEFT JOIN tecnicos ON asistencia_tecnica.id_tecnico = tecnicos.id LEFT JOIN usuarios ON asistencia_tecnica.id_usuario_creacion = usuarios.id_usuario LEFT JOIN usuarios ON asistencia_tecnica.id_usuario_edicion = usuarios.id_usuario  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  asistencia_tecnica.* , tecnicos.tecnico as tecnicos_tecnico , usuarios.usuario as usuarios_usuario , usuarios.clave as usuarios_clave , usuarios.nombre as usuarios_nombre , usuarios.apellido as usuarios_apellido , usuarios.email as usuarios_email , usuarios.usuario as usuarios_usuario , usuarios.clave as usuarios_clave , usuarios.nombre as usuarios_nombre , usuarios.apellido as usuarios_apellido , usuarios.email as usuarios_email  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "asistencia_tecnica.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.at) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.ot) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.vehiculo_modelo) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.cliente) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.chasis) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.chapa) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "usuarios.usuario LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "usuarios.usuario LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.solicitud) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(asistencia_tecnica.observacion) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "asistencia_tecnica.id_estado = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "tecnicos.tecnico LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>