<?php 

/** 
 * permisos_secciones_administrables 
 * 
 * 22/03/2017 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class permisos_secciones_administrables { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id_permiso_seccion_administrable = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_id_rol = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_codigo_seccion_administrable = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_alta = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_baja = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_modificacion = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_consulta = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto permisos_secciones_administrables. Inicializa las propiedades del objeto.
	  */ 
	 public function __construct() { 
		 $this->_dbmanager = new DBManager(); 
	 } 

	 /************************************ 
	  * PROPIEDADES PUBLICAS DE LA CLASE * 
	  ************************************/ 

	 public function set_id_permiso_seccion_administrable($p_id_permiso_seccion_administrable){ 
		 $this->_id_permiso_seccion_administrable['value'] = $p_id_permiso_seccion_administrable; 
	 } 
	 public function get_id_permiso_seccion_administrable(){ return $this->_id_permiso_seccion_administrable['value']; } 

	 public function set_id_rol($p_id_rol){ 
		 if(!DataValidator::validate($p_id_rol, $this->_id_rol['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_rol</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_rol['value'] = $p_id_rol; 
	 } 
	 public function get_id_rol(){ return $this->_id_rol['value']; } 

	 public function set_codigo_seccion_administrable($p_codigo_seccion_administrable){ 
		 if(!DataValidator::validate($p_codigo_seccion_administrable, $this->_codigo_seccion_administrable['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>codigo_seccion_administrable</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_codigo_seccion_administrable['value'] = $p_codigo_seccion_administrable; 
	 } 
	 public function get_codigo_seccion_administrable(){ return $this->_codigo_seccion_administrable['value']; } 

	 public function set_alta($p_alta){ 
		 if(!DataValidator::validate($p_alta, $this->_alta['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>alta</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_alta['value'] = $p_alta; 
	 } 
	 public function get_alta(){ return $this->_alta['value']; } 

	 public function set_baja($p_baja){ 
		 if(!DataValidator::validate($p_baja, $this->_baja['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>baja</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_baja['value'] = $p_baja; 
	 } 
	 public function get_baja(){ return $this->_baja['value']; } 

	 public function set_modificacion($p_modificacion){ 
		 if(!DataValidator::validate($p_modificacion, $this->_modificacion['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>modificacion</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_modificacion['value'] = $p_modificacion; 
	 } 
	 public function get_modificacion(){ return $this->_modificacion['value']; } 

	 public function set_consulta($p_consulta){ 
		 if(!DataValidator::validate($p_consulta, $this->_consulta['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>consulta</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_consulta['value'] = $p_consulta; 
	 } 
	 public function get_consulta(){ return $this->_consulta['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id_permiso_seccion_administrable ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id_permiso_seccion_administrable) { 
		 $query = new DBQuery('SELECT * FROM permisos_secciones_administrables WHERE id_permiso_seccion_administrable = {id_permiso_seccion_administrable}'); 
		 $query->addParam('id_permiso_seccion_administrable', $p_id_permiso_seccion_administrable, $this->_id_permiso_seccion_administrable['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id_permiso_seccion_administrable['value'] = $datos[0]['id_permiso_seccion_administrable']; 
			 $this->_id_rol['value'] = $datos[0]['id_rol']; 
			 $this->_codigo_seccion_administrable['value'] = $datos[0]['codigo_seccion_administrable']; 
			 $this->_alta['value'] = $datos[0]['alta']; 
			 $this->_baja['value'] = $datos[0]['baja']; 
			 $this->_modificacion['value'] = $datos[0]['modificacion']; 
			 $this->_consulta['value'] = $datos[0]['consulta']; 
		 }else{ 
			 $this->_id_permiso_seccion_administrable['value'] = null; 
			 $this->_id_rol['value'] = null; 
			 $this->_codigo_seccion_administrable['value'] = ''; 
			 $this->_alta['value'] = null; 
			 $this->_baja['value'] = null; 
			 $this->_modificacion['value'] = null; 
			 $this->_consulta['value'] = null; 
		 } 
		 return ($this->_id_permiso_seccion_administrable['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id_permiso_seccion_administrable['value'] == null) { 
			 $query = new DBQuery('INSERT INTO permisos_secciones_administrables(id_rol, codigo_seccion_administrable, alta, baja, modificacion, consulta)VALUES({id_rol}, {codigo_seccion_administrable}, {alta}, {baja}, {modificacion}, {consulta})'); 
			 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
			 $query->addParam('codigo_seccion_administrable', $this->_codigo_seccion_administrable['value'], $this->_codigo_seccion_administrable['datatype']); 
			 $query->addParam('alta', $this->_alta['value'], $this->_alta['datatype']); 
			 $query->addParam('baja', $this->_baja['value'], $this->_baja['datatype']); 
			 $query->addParam('modificacion', $this->_modificacion['value'], $this->_modificacion['datatype']); 
			 $query->addParam('consulta', $this->_consulta['value'], $this->_consulta['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE permisos_secciones_administrables SET id_rol = {id_rol}, codigo_seccion_administrable = {codigo_seccion_administrable}, alta = {alta}, baja = {baja}, modificacion = {modificacion}, consulta = {consulta} WHERE id_permiso_seccion_administrable = {id_permiso_seccion_administrable}'); 
			 $query->addParam('id_permiso_seccion_administrable', $this->_id_permiso_seccion_administrable['value'], $this->_id_permiso_seccion_administrable['datatype']); 
			 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
			 $query->addParam('codigo_seccion_administrable', $this->_codigo_seccion_administrable['value'], $this->_codigo_seccion_administrable['datatype']); 
			 $query->addParam('alta', $this->_alta['value'], $this->_alta['datatype']); 
			 $query->addParam('baja', $this->_baja['value'], $this->_baja['datatype']); 
			 $query->addParam('modificacion', $this->_modificacion['value'], $this->_modificacion['datatype']); 
			 $query->addParam('consulta', $this->_consulta['value'], $this->_consulta['datatype']); 
		 } 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($this->get_id_permiso_seccion_administrable() == null) { $this->set_id_permiso_seccion_administrable($this->_dbmanager->lastID()); } 
		 return ($filas_afectadas == -1)?false:true; 
	 } 

	 /** 
	  * Elimina un registro de la base de datos.
	  * @return Boolean Verdadero cuando el registro se elimino correctamente. 
	  */ 
	 public function elimina() { 
		 $query = new DBQuery('DELETE FROM permisos_secciones_administrables WHERE id_permiso_seccion_administrable = {id_permiso_seccion_administrable}'); 
		 $query->addParam('id_permiso_seccion_administrable', $this->_id_permiso_seccion_administrable['value'], $this->_id_permiso_seccion_administrable['datatype']); 
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

		 $sql_from = ' permisos_secciones_administrables LEFT JOIN roles ON permisos_secciones_administrables.id_rol = roles.id_rol LEFT JOIN secciones_administrables ON permisos_secciones_administrables.codigo_seccion_administrable = secciones_administrables.codigo_seccion_administrable  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  permisos_secciones_administrables.* , roles.rol as roles_rol , secciones_administrables.codigo_seccion_administrable as secciones_administrables_codigo_seccion_administrable , secciones_administrables.seccion_administrable as secciones_administrables_seccion_administrable , secciones_administrables.url as secciones_administrables_url , secciones_administrables.grupo as secciones_administrables_grupo  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "permisos_secciones_administrables.id_permiso_seccion_administrable = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "roles.rol LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(permisos_secciones_administrables.codigo_seccion_administrable) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(CAST(permisos_secciones_administrables.alta AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(CAST(permisos_secciones_administrables.baja AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(CAST(permisos_secciones_administrables.modificacion AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(CAST(permisos_secciones_administrables.consulta AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>