<?php 

/** 
 * preparacion_piezas 
 * 
 * 27/03/2019 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class preparacion_piezas { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_usuario = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_seguimiento = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_usuario_modificacion = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_estado = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_observacion = Array('value' => null, 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array('required' => true)); 
	 protected $_fecha_fin = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_id_tiempos_ordenes = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_tipo = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_observacion_ot = Array('value' => null, 'datatype' => DBType::String, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto preparacion_piezas. Inicializa las propiedades del objeto.
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

	 public function set_id_usuario($p_id_usuario){ 
		 if(!DataValidator::validate($p_id_usuario, $this->_id_usuario['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_usuario</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_usuario['value'] = $p_id_usuario; 
	 } 
	 public function get_id_usuario(){ return $this->_id_usuario['value']; } 

	 public function set_id_seguimiento($p_id_seguimiento){ 
		 if(!DataValidator::validate($p_id_seguimiento, $this->_id_seguimiento['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_seguimiento</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_seguimiento['value'] = $p_id_seguimiento; 
	 } 
	 public function get_id_seguimiento(){ return $this->_id_seguimiento['value']; } 

	 public function set_id_usuario_modificacion($p_id_usuario_modificacion){ 
		 if(!DataValidator::validate($p_id_usuario_modificacion, $this->_id_usuario_modificacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_usuario_modificacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_usuario_modificacion['value'] = $p_id_usuario_modificacion; 
	 } 
	 public function get_id_usuario_modificacion(){ return $this->_id_usuario_modificacion['value']; } 

	 public function set_estado($p_estado){ 
		 if(!DataValidator::validate($p_estado, $this->_estado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>estado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_estado['value'] = $p_estado; 
	 } 
	 public function get_estado(){ return $this->_estado['value']; } 

	 public function set_observacion($p_observacion){ 
		 if(!DataValidator::validate($p_observacion, $this->_observacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>observacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_observacion['value'] = $p_observacion; 
	 } 
	 public function get_observacion(){ return $this->_observacion['value']; } 

	 public function set_fecha_creacion($p_fecha_creacion){ 
		 if(!DataValidator::validate($p_fecha_creacion, $this->_fecha_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_creacion['value'] = $p_fecha_creacion; 
	 } 
	 public function get_fecha_creacion(){ return $this->_fecha_creacion['value']; } 

	 public function set_fecha_fin($p_fecha_fin){ 
		 if(!DataValidator::validate($p_fecha_fin, $this->_fecha_fin['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_fin</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_fin['value'] = $p_fecha_fin; 
	 } 
	 public function get_fecha_fin(){ return $this->_fecha_fin['value']; } 

	 public function set_id_tiempos_ordenes($p_id_tiempos_ordenes){ 
		 if(!DataValidator::validate($p_id_tiempos_ordenes, $this->_id_tiempos_ordenes['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_tiempos_ordenes</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_tiempos_ordenes['value'] = $p_id_tiempos_ordenes; 
	 } 
	 public function get_id_tiempos_ordenes(){ return $this->_id_tiempos_ordenes['value']; } 

	 public function set_tipo($p_tipo){ 
		 if(!DataValidator::validate($p_tipo, $this->_tipo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>tipo</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_tipo['value'] = $p_tipo; 
	 } 
	 public function get_tipo(){ return $this->_tipo['value']; } 

	 public function set_observacion_ot($p_observacion_ot){ 
		 if(!DataValidator::validate($p_observacion_ot, $this->_observacion_ot['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>observacion_ot</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_observacion_ot['value'] = $p_observacion_ot; 
	 } 
	 public function get_observacion_ot(){ return $this->_observacion_ot['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM preparacion_piezas WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_id_usuario['value'] = $datos[0]['id_usuario']; 
			 $this->_id_seguimiento['value'] = $datos[0]['id_seguimiento']; 
			 $this->_id_usuario_modificacion['value'] = $datos[0]['id_usuario_modificacion']; 
			 $this->_estado['value'] = $datos[0]['estado']; 
			 $this->_observacion['value'] = $datos[0]['observacion']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
			 $this->_fecha_fin['value'] = $datos[0]['fecha_fin']; 
			 $this->_id_tiempos_ordenes['value'] = $datos[0]['id_tiempos_ordenes']; 
			 $this->_tipo['value'] = $datos[0]['tipo']; 
			 $this->_observacion_ot['value'] = $datos[0]['observacion_ot']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_id_usuario['value'] = null; 
			 $this->_id_seguimiento['value'] = null; 
			 $this->_id_usuario_modificacion['value'] = null; 
			 $this->_estado['value'] = null; 
			 $this->_observacion['value'] = null; 
			 $this->_fecha_creacion['value'] = null; 
			 $this->_fecha_fin['value'] = null; 
			 $this->_id_tiempos_ordenes['value'] = null; 
			 $this->_tipo['value'] = null; 
			 $this->_observacion_ot['value'] = null; 
		 } 
		 return ($this->_id['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id['value'] == null) { 
			 $query = new DBQuery('INSERT INTO preparacion_piezas(id_usuario, id_seguimiento, id_usuario_modificacion, estado, observacion, fecha_creacion, fecha_fin, id_tiempos_ordenes, tipo, observacion_ot)VALUES({id_usuario}, {id_seguimiento}, {id_usuario_modificacion}, {estado}, {observacion}, {fecha_creacion}, {fecha_fin}, {id_tiempos_ordenes}, {tipo}, {observacion_ot})'); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
			 $query->addParam('id_usuario_modificacion', $this->_id_usuario_modificacion['value'], $this->_id_usuario_modificacion['datatype']); 
			 $query->addParam('estado', $this->_estado['value'], $this->_estado['datatype']); 
			 $query->addParam('observacion', $this->_observacion['value'], $this->_observacion['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('fecha_fin', $this->_fecha_fin['value'], $this->_fecha_fin['datatype']); 
			 $query->addParam('id_tiempos_ordenes', $this->_id_tiempos_ordenes['value'], $this->_id_tiempos_ordenes['datatype']); 
			 $query->addParam('tipo', $this->_tipo['value'], $this->_tipo['datatype']); 
			 $query->addParam('observacion_ot', $this->_observacion_ot['value'], $this->_observacion_ot['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE preparacion_piezas SET id_usuario = {id_usuario}, id_seguimiento = {id_seguimiento}, id_usuario_modificacion = {id_usuario_modificacion}, estado = {estado}, observacion = {observacion}, fecha_creacion = {fecha_creacion}, fecha_fin = {fecha_fin}, id_tiempos_ordenes = {id_tiempos_ordenes}, tipo = {tipo}, observacion_ot = {observacion_ot} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
			 $query->addParam('id_usuario_modificacion', $this->_id_usuario_modificacion['value'], $this->_id_usuario_modificacion['datatype']); 
			 $query->addParam('estado', $this->_estado['value'], $this->_estado['datatype']); 
			 $query->addParam('observacion', $this->_observacion['value'], $this->_observacion['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('fecha_fin', $this->_fecha_fin['value'], $this->_fecha_fin['datatype']); 
			 $query->addParam('id_tiempos_ordenes', $this->_id_tiempos_ordenes['value'], $this->_id_tiempos_ordenes['datatype']); 
			 $query->addParam('tipo', $this->_tipo['value'], $this->_tipo['datatype']); 
			 $query->addParam('observacion_ot', $this->_observacion_ot['value'], $this->_observacion_ot['datatype']); 
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
		 $query = new DBQuery('DELETE FROM preparacion_piezas WHERE id = {id}'); 
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

		 $sql_from = ' preparacion_piezas LEFT JOIN seguimiento_ordenes ON preparacion_piezas.id_seguimiento = seguimiento_ordenes.id LEFT JOIN tiempos_ordenes ON preparacion_piezas.id_tiempos_ordenes = tiempos_ordenes.id LEFT JOIN usuarios ON preparacion_piezas.id_usuario = usuarios.id_usuario LEFT JOIN usuarios ON preparacion_piezas.id_usuario_modificacion = usuarios.id_usuario  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  preparacion_piezas.* , seguimiento_ordenes.vehiculo_modelo as seguimiento_ordenes_vehiculo_modelo , seguimiento_ordenes.cliente as seguimiento_ordenes_cliente , seguimiento_ordenes.chasis as seguimiento_ordenes_chasis , seguimiento_ordenes.chapa as seguimiento_ordenes_chapa , seguimiento_ordenes.email_asesor as seguimiento_ordenes_email_asesor , seguimiento_ordenes.nro_asesor as seguimiento_ordenes_nro_asesor , seguimiento_ordenes.ot as seguimiento_ordenes_ot , seguimiento_ordenes.ci as seguimiento_ordenes_ci , tiempos_ordenes.tecnico as tiempos_ordenes_tecnico , usuarios.usuario as usuarios_usuario , usuarios.clave as usuarios_clave , usuarios.nombre as usuarios_nombre , usuarios.apellido as usuarios_apellido , usuarios.email as usuarios_email , usuarios.usuario as usuarios_usuario , usuarios.clave as usuarios_clave , usuarios.nombre as usuarios_nombre , usuarios.apellido as usuarios_apellido , usuarios.email as usuarios_email  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "preparacion_piezas.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "usuarios.usuario LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "seguimiento_ordenes.vehiculo_modelo LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "usuarios.usuario LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "preparacion_piezas.estado = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(preparacion_piezas.observacion) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "tiempos_ordenes.tecnico LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "preparacion_piezas.tipo = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(preparacion_piezas.observacion_ot) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>