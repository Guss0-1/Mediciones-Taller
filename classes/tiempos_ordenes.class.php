<?php 

/** 
 * tiempos_ordenes 
 * 
 * 19/01/2018 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class tiempos_ordenes { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_seguimiento = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_id_usuario = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_tecnico = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_id_jefe = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_observaciones = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_id_estado = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_fecha_comprometida = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_fecha_fin = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto tiempos_ordenes. Inicializa las propiedades del objeto.
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

	 public function set_id_usuario($p_id_usuario){ 
		 if(!DataValidator::validate($p_id_usuario, $this->_id_usuario['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_usuario</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_usuario['value'] = $p_id_usuario; 
	 } 
	 public function get_id_usuario(){ return $this->_id_usuario['value']; } 

	 public function set_tecnico($p_tecnico){ 
		 if(!DataValidator::validate($p_tecnico, $this->_tecnico['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>tecnico</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_tecnico['value'] = $p_tecnico; 
	 } 
	 public function get_tecnico(){ return $this->_tecnico['value']; } 

	 public function set_id_jefe($p_id_jefe){ 
		 if(!DataValidator::validate($p_id_jefe, $this->_id_jefe['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_jefe</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_jefe['value'] = $p_id_jefe; 
	 } 
	 public function get_id_jefe(){ return $this->_id_jefe['value']; } 

	 public function set_observaciones($p_observaciones){ 
		 if(!DataValidator::validate($p_observaciones, $this->_observaciones['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>observaciones</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_observaciones['value'] = $p_observaciones; 
	 } 
	 public function get_observaciones(){ return $this->_observaciones['value']; } 

	 public function set_id_estado($p_id_estado){ 
		 if(!DataValidator::validate($p_id_estado, $this->_id_estado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_estado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_estado['value'] = $p_id_estado; 
	 } 
	 public function get_id_estado(){ return $this->_id_estado['value']; } 

	 public function set_fecha_comprometida($p_fecha_comprometida){ 
		 if(!DataValidator::validate($p_fecha_comprometida, $this->_fecha_comprometida['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_comprometida</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_comprometida['value'] = $p_fecha_comprometida; 
	 } 
	 public function get_fecha_comprometida(){ return $this->_fecha_comprometida['value']; } 

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

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM tiempos_ordenes WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_id_seguimiento['value'] = $datos[0]['id_seguimiento']; 
			 $this->_id_usuario['value'] = $datos[0]['id_usuario']; 
			 $this->_tecnico['value'] = $datos[0]['tecnico']; 
			 $this->_id_jefe['value'] = $datos[0]['id_jefe']; 
			 $this->_id_estado['value'] = $datos[0]['id_estado']; 
			 $this->_observaciones['value'] = $datos[0]['observaciones']; 
			 $this->_fecha_comprometida['value'] = $datos[0]['fecha_comprometida']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
			 $this->_fecha_fin['value'] = $datos[0]['fecha_fin']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_id_seguimiento['value'] = null; 
			 $this->_id_usuario['value'] = null; 
			 $this->_tecnico['value'] = ''; 
			 $this->_id_jefe['value'] = ''; 
			 $this->_id_estado['value'] = null; 
			 $this->_observaciones['value'] = ''; 
			 $this->_fecha_comprometida['value'] = null; 
			 $this->_fecha_creacion['value'] = null; 
			 $this->_fecha_fin['value'] = null; 
		 } 
		 return ($this->_id['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id['value'] == null) { 
			 $query = new DBQuery('INSERT INTO tiempos_ordenes(id_seguimiento, id_usuario, id_estado, fecha_comprometida, fecha_fin, tecnico, id_jefe, observaciones)VALUES({id_seguimiento}, {id_usuario}, {id_estado}, {fecha_comprometida}, {fecha_fin}, {tecnico}, {id_jefe}, {observaciones})'); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('id_estado', $this->_id_estado['value'], $this->_id_estado['datatype']); 
			 $query->addParam('tecnico', $this->_tecnico['value'], $this->_tecnico['datatype']); 
			 $query->addParam('id_jefe', $this->_id_jefe['value'], $this->_id_jefe['datatype']); 
			 $query->addParam('fecha_comprometida', $this->_fecha_comprometida['value'], $this->_fecha_comprometida['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']);
			 $query->addParam('fecha_fin', $this->_fecha_fin['value'], $this->_fecha_fin['datatype']);  
			 $query->addParam('observaciones', $this->_observaciones['value'], $this->_observaciones['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE tiempos_ordenes SET id_seguimiento = {id_seguimiento}, tecnico = {tecnico}, id_jefe = {id_jefe}, id_usuario = {id_usuario}, id_estado = {id_estado}, fecha_comprometida = {fecha_comprometida}, fecha_fin = {fecha_fin}, observaciones = {observaciones} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('id_seguimiento', $this->_id_seguimiento['value'], $this->_id_seguimiento['datatype']); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('id_estado', $this->_id_estado['value'], $this->_id_estado['datatype']); 
			 $query->addParam('tecnico', $this->_tecnico['value'], $this->_tecnico['datatype']); 
			 $query->addParam('id_jefe', $this->_id_jefe['value'], $this->_id_jefe['datatype']); 
			 $query->addParam('fecha_comprometida', $this->_fecha_comprometida['value'], $this->_fecha_comprometida['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('fecha_fin', $this->_fecha_fin['value'], $this->_fecha_fin['datatype']); 
			 $query->addParam('observaciones', $this->_observaciones['value'], $this->_observaciones['datatype']);
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
		 $query = new DBQuery('DELETE FROM tiempos_ordenes WHERE id = {id}'); 
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

		 $sql_from = ' tiempos_ordenes LEFT JOIN estados_ordenes ON tiempos_ordenes.id_estado = estados_ordenes.id LEFT JOIN seguimiento_ordenes ON tiempos_ordenes.id_seguimiento = seguimiento_ordenes.id LEFT JOIN usuarios ON tiempos_ordenes.id_usuario = usuarios.id_usuario  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  tiempos_ordenes.* , estados_ordenes.estado as estados_ordenes_estado , seguimiento_ordenes.vehiculo_modelo as seguimiento_ordenes_vehiculo_modelo , seguimiento_ordenes.chasis as seguimiento_ordenes_chasis , seguimiento_ordenes.chapa as seguimiento_ordenes_chapa , seguimiento_ordenes.nro_asesor as seguimiento_ordenes_nro_asesor , usuarios.usuario as usuarios_usuario , usuarios.clave as usuarios_clave , usuarios.nombre as usuarios_nombre , usuarios.apellido as usuarios_apellido , usuarios.email as usuarios_email  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "tiempos_ordenes.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "seguimiento_ordenes.vehiculo_modelo LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "usuarios.usuario LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(tiempos_ordenes.tecnico) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "estados_ordenes.estado LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 if(preg_match('/^\d+$/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "tiempos_ordenes.fecha_comprometida = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>