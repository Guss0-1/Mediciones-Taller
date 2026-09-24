<?php 

/** 
 * ordenes_reabiertas 
 * 
 * 19/01/2018 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class ordenes_reabiertas { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_fecha_ingreso = Array('value' => null, 'datatype' => DBTYpe::Date, 'validators' => array('date' => true)); 
	 protected $_fecha_actualizacion = Array('value' => null, 'datatype' => DBTYpe::Date, 'validators' => array('date' => true)); 
	 protected $_vehiculo_modelo = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_cliente = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_chasis = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_chapa = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_fecha_comprometida = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_fecha_fin_estado_terminado = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 
	 protected $_nro_asesor = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_email_asesor = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_id_estado_actual = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('digits' => true)); 
	 protected $_ot = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 
	 protected $_fecha_creacion = Array('value' => null, 'datatype' => DBTYpe::DateTime, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto ordenes_reabiertas. Inicializa las propiedades del objeto.
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

	 public function set_fecha_ingreso($p_fecha_ingreso){ 
		 if(!DataValidator::validate($p_fecha_ingreso, $this->_fecha_ingreso['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_ingreso</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_ingreso['value'] = $p_fecha_ingreso; 
	 } 
	 public function get_fecha_ingreso(){ return $this->_fecha_ingreso['value']; } 

	 public function set_fecha_actualizacion($p_fecha_actualizacion){ 
		 if(!DataValidator::validate($p_fecha_actualizacion, $this->_fecha_actualizacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_actualizacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_actualizacion['value'] = $p_fecha_actualizacion; 
	 } 
	 public function get_fecha_actualizacion(){ return $this->_fecha_actualizacion['value']; } 

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

	 public function set_ot($p_ot){ 
		 if(!DataValidator::validate($p_ot, $this->_ot['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>ot</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_ot['value'] = $p_ot; 
	 } 
	 public function get_ot(){ return $this->_ot['value']; } 

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

	 public function set_id_estado_actual($p_id_estado_actual){ 
		 if(!DataValidator::validate($p_id_estado_actual, $this->_id_estado_actual['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_estado_actual</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_estado_actual['value'] = $p_id_estado_actual; 
	 } 
	 public function get_id_estado_actual(){ return $this->_id_estado_actual['value']; } 

	 public function set_nro_asesor($p_nro_asesor){ 
		 if(!DataValidator::validate($p_nro_asesor, $this->_nro_asesor['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>nro_asesor</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_nro_asesor['value'] = $p_nro_asesor; 
	 } 
	 public function get_nro_asesor(){ return $this->_nro_asesor['value']; } 

	 public function set_email_asesor($p_email_asesor){ 
		 if(!DataValidator::validate($p_email_asesor, $this->_email_asesor['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>email_asesor</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_email_asesor['value'] = $p_email_asesor; 
	 } 
	 public function get_email_asesor(){ return $this->_email_asesor['value']; } 

	 public function set_fecha_creacion($p_fecha_creacion){ 
		 if(!DataValidator::validate($p_fecha_creacion, $this->_fecha_creacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_creacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_creacion['value'] = $p_fecha_creacion; 
	 } 
	 public function get_fecha_creacion(){ return $this->_fecha_creacion['value']; } 

	 public function set_fecha_fin_estado_terminado($p_fecha_fin_estado_terminado){ 
		 if(!DataValidator::validate($p_fecha_fin_estado_terminado, $this->_fecha_fin_estado_terminado['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>fecha_fin_estado_terminado</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_fecha_fin_estado_terminado['value'] = $p_fecha_fin_estado_terminado; 
	 } 
	 public function get_fecha_fin_estado_terminado(){ return $this->_fecha_fin_estado_terminado['value']; }

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id) { 
		 $query = new DBQuery('SELECT * FROM ordenes_reabiertas WHERE id = {id}'); 
		 $query->addParam('id', $p_id, $this->_id['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id['value'] = $datos[0]['id']; 
			 $this->_fecha_ingreso['value'] = $datos[0]['fecha_ingreso']; 
			 $this->_fecha_actualizacion['value'] = $datos[0]['fecha_actualizacion']; 
			 $this->_vehiculo_modelo['value'] = $datos[0]['vehiculo_modelo']; 
			 $this->_cliente['value'] = $datos[0]['cliente']; 
			 $this->_chasis['value'] = $datos[0]['chasis']; 
			 $this->_chapa['value'] = $datos[0]['chapa']; 
			 $this->_ot['value'] = $datos[0]['ot']; 
			 $this->_fecha_fin_estado_terminado['value'] = $datos[0]['fecha_fin_estado_terminado']; 
			 $this->_id_estado_actual['value'] = $datos[0]['id_estado_actual']; 
			 $this->_ot['value'] = $datos[0]['ot']; 
			 $this->_nro_asesor['value'] = $datos[0]['nro_asesor']; 
			 $this->_email_asesor['value'] = $datos[0]['email_asesor']; 
			 $this->_fecha_creacion['value'] = $datos[0]['fecha_creacion']; 
		 }else{ 
			 $this->_id['value'] = null; 
			 $this->_fecha_ingreso['value'] = null; 
			 $this->_fecha_actualizacion['value'] = null; 
			 $this->_vehiculo_modelo['value'] = ''; 
			 $this->_cliente['value'] = ''; 
			 $this->_chasis['value'] = ''; 
			 $this->_chapa['value'] = ''; 
			 $this->_ot['value'] = ''; 
			 $this->_fecha_fin_estado_terminado['value'] = null; 
			 $this->_id_estado_actual['value'] = null; 
			 $this->_nro_asesor['value'] = ''; 
			 $this->_email_asesor['value'] = ''; 
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
			 $query = new DBQuery('INSERT INTO ordenes_reabiertas(ot,fecha_ingreso,fecha_actualizacion, vehiculo_modelo, cliente, chasis, chapa, nro_asesor)VALUES({ot},{fecha_ingreso},{fecha_actualizacion}, {vehiculo_modelo}, {cliente}, {chasis}, {chapa}, {nro_asesor})'); 
			 $query->addParam('ot', $this->_ot['value'], $this->_ot['datatype']); 
			 $query->addParam('fecha_actualizacion', $this->_fecha_actualizacion['value'], $this->_fecha_actualizacion['datatype']); 
			 $query->addParam('fecha_ingreso', $this->_fecha_ingreso['value'], $this->_fecha_ingreso['datatype']); 
			 $query->addParam('vehiculo_modelo', $this->_vehiculo_modelo['value'], $this->_vehiculo_modelo['datatype']); 
			 $query->addParam('cliente', $this->_cliente['value'], $this->_cliente['datatype']); 
			 $query->addParam('chasis', $this->_chasis['value'], $this->_chasis['datatype']); 
			 $query->addParam('chapa', $this->_chapa['value'], $this->_chapa['datatype']); 
			 $query->addParam('nro_asesor', $this->_nro_asesor['value'], $this->_nro_asesor['datatype']); 
			 $query->addParam('email_asesor', $this->_email_asesor['value'], $this->_email_asesor['datatype']); 
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']); 
			 $query->addParam('fecha_fin_estado_terminado', $this->_fecha_fin_estado_terminado['value'], $this->_fecha_fin_estado_terminado['datatype']); 
			 $query->addParam('id_estado_actual', $this->_id_estado_actual['value'], $this->_id_estado_actual['datatype']);
			 
		 }else{ 
			 $query = new DBQuery('UPDATE ordenes_reabiertas SET fecha_ingreso = {fecha_ingreso},fecha_actualizacion = {fecha_actualizacion},ot = {ot}, vehiculo_modelo = {vehiculo_modelo}, cliente = {cliente}, chasis = {chasis}, chapa = {chapa}, nro_asesor = {nro_asesor} WHERE id = {id}'); 
			 $query->addParam('id', $this->_id['value'], $this->_id['datatype']); 
			 $query->addParam('ot', $this->_ot['value'], $this->_ot['datatype']); 
			 $query->addParam('fecha_ingreso', $this->_fecha_ingreso['value'], $this->_fecha_ingreso['datatype']); 
			 $query->addParam('fecha_actualizacion', $this->_fecha_actualizacion['value'], $this->_fecha_actualizacion['datatype']); 
			 $query->addParam('cliente', $this->_cliente['value'], $this->_cliente['datatype']); 
			 $query->addParam('vehiculo_modelo', $this->_vehiculo_modelo['value'], $this->_vehiculo_modelo['datatype']); 
			 $query->addParam('chasis', $this->_chasis['value'], $this->_chasis['datatype']); 
			 $query->addParam('chapa', $this->_chapa['value'], $this->_chapa['datatype']); 
			 $query->addParam('nro_asesor', $this->_nro_asesor['value'], $this->_nro_asesor['datatype']);
			 $query->addParam('email_asesor', $this->_email_asesor['value'], $this->_email_asesor['datatype']);  
			 $query->addParam('fecha_creacion', $this->_fecha_creacion['value'], $this->_fecha_creacion['datatype']);
			 $query->addParam('fecha_fin_estado_terminado', $this->_fecha_fin_estado_terminado['value'], $this->_fecha_fin_estado_terminado['datatype']); 
			 $query->addParam('id_estado_actual', $this->_id_estado_actual['value'], $this->_id_estado_actual['datatype']); 
			 
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
		 $query = new DBQuery('DELETE FROM ordenes_reabiertas WHERE id = {id}'); 
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

		 $sql_from = ' ordenes_reabiertas  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  ordenes_reabiertas.*  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "ordenes_reabiertas.id = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 if(preg_match('/(?:0[1-9]|[12][0-9]|3[01])\/(?:0[1-9]|1[0-2])\/(?:19|20\d{2})/', $p_valor)) { 
			 $filtro.= ($filtro == '')?' ': ' OR '; 
			 $filtro.= "ordenes_reabiertas.fecha_ingreso = " . DBManager::formatSQLValue($p_valor, "Date") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.vehiculo_modelo) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.ot) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.cliente) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.chasis) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.chapa) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.nro_asesor) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 

		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(ordenes_reabiertas.email_asesor) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") ";
		 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>