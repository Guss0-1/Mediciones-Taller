<?php 

/** 
 * usuarios 
 * 
 * 10/04/2013 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class usuarios { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id_usuario = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_usuario = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_clave = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_nombre = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_apellido = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_email = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_id_rol = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto usuarios. Inicializa las propiedades del objeto.
	  */ 
	 public function __construct() { 
		 $this->_dbmanager = new DBManager(); 
	 } 

	 /************************************ 
	  * PROPIEDADES PUBLICAS DE LA CLASE * 
	  ************************************/ 

	 public function set_id_usuario($p_id_usuario){ 
		 $this->_id_usuario['value'] = $p_id_usuario; 
	 } 
	 public function get_id_usuario(){ return $this->_id_usuario['value']; } 

	 public function set_usuario($p_usuario){ 
		 if(!DataValidator::validate($p_usuario, $this->_usuario['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>usuario</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_usuario['value'] = $p_usuario; 
	 } 
	 public function get_usuario(){ return $this->_usuario['value']; } 

	 public function set_clave($p_clave){ 
		 if(!DataValidator::validate($p_clave, $this->_clave['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>clave</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_clave['value'] = $p_clave; 
	 } 
	 public function get_clave(){ return $this->_clave['value']; } 

	 public function set_nombre($p_nombre){ 
		 if(!DataValidator::validate($p_nombre, $this->_nombre['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>nombre</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_nombre['value'] = $p_nombre; 
	 } 
	 public function get_nombre(){ return $this->_nombre['value']; } 

	 public function set_apellido($p_apellido){ 
		 if(!DataValidator::validate($p_apellido, $this->_apellido['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>apellido</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_apellido['value'] = $p_apellido; 
	 } 
	 public function get_apellido(){ return $this->_apellido['value']; } 

	 public function set_email($p_email){ 
		 if(!DataValidator::validate($p_email, $this->_email['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>email</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_email['value'] = $p_email; 
	 } 
	 public function get_email(){ return $this->_email['value']; } 

	 public function set_id_rol($p_id_rol){ 
		 if(!DataValidator::validate($p_id_rol, $this->_id_rol['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>id_rol</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_id_rol['value'] = $p_id_rol; 
	 } 
	 public function get_id_rol(){ return $this->_id_rol['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id_usuario ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id_usuario) { 
		 $query = new DBQuery('SELECT * FROM usuarios WHERE id_usuario = {id_usuario}'); 
			 $query->addParam('id_usuario', $p_id_usuario, $this->_id_usuario['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id_usuario['value'] = $datos[0]['id_usuario']; 
			 $this->_usuario['value'] = $datos[0]['usuario']; 
			 $this->_clave['value'] = $datos[0]['clave']; 
			 $this->_nombre['value'] = $datos[0]['nombre']; 
			 $this->_apellido['value'] = $datos[0]['apellido']; 
			 $this->_email['value'] = $datos[0]['email']; 
			 $this->_id_rol['value'] = $datos[0]['id_rol']; 
		 }else{ 
			 $this->_id_usuario['value'] = null; 
			 $this->_usuario['value'] = ''; 
			 $this->_clave['value'] = ''; 
			 $this->_nombre['value'] = ''; 
			 $this->_apellido['value'] = ''; 
			 $this->_email['value'] = ''; 
			 $this->_id_rol['value'] = null; 
		 } 
		 return ($this->_id_usuario['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id_usuario['value'] == null) { 
			 $query = new DBQuery('INSERT INTO usuarios(usuario, clave, nombre, apellido, email, id_rol)VALUES({usuario}, {clave}, {nombre}, {apellido}, {email}, {id_rol})'); 
			 $query->addParam('usuario', $this->_usuario['value'], $this->_usuario['datatype']); 
			 $query->addParam('clave', $this->_clave['value'], $this->_clave['datatype']); 
			 $query->addParam('nombre', $this->_nombre['value'], $this->_nombre['datatype']); 
			 $query->addParam('apellido', $this->_apellido['value'], $this->_apellido['datatype']); 
			 $query->addParam('email', $this->_email['value'], $this->_email['datatype']); 
			 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE usuarios SET usuario = {usuario}, clave = {clave}, nombre = {nombre}, apellido = {apellido}, email = {email}, id_rol = {id_rol} WHERE id_usuario = {id_usuario}'); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
			 $query->addParam('usuario', $this->_usuario['value'], $this->_usuario['datatype']); 
			 $query->addParam('clave', $this->_clave['value'], $this->_clave['datatype']); 
			 $query->addParam('nombre', $this->_nombre['value'], $this->_nombre['datatype']); 
			 $query->addParam('apellido', $this->_apellido['value'], $this->_apellido['datatype']); 
			 $query->addParam('email', $this->_email['value'], $this->_email['datatype']); 
			 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
		 } 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($this->get_id_usuario() == null) { $this->set_id_usuario($this->_dbmanager->lastID()); } 
		 return ($filas_afectadas == -1)?false:true; 
	 } 

	 /** 
	  * Elimina un registro de la base de datos.
	  * @return Boolean Verdadero cuando el registro se elimino correctamente. 
	  */ 
	 public function elimina() { 
		 $query = new DBQuery('DELETE FROM usuarios WHERE id_usuario = {id_usuario}'); 
			 $query->addParam('id_usuario', $this->_id_usuario['value'], $this->_id_usuario['datatype']); 
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

		 $sql_from = ' usuarios LEFT JOIN roles ON usuarios.id_rol = roles.id_rol  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  usuarios.* , roles.rol as roles_rol  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "usuarios.id_usuario = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(usuarios.usuario) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(usuarios.nombre) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(usuarios.apellido) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(usuarios.email) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "roles.rol LIKE " . DBManager::formatSQLValue('%'.$p_valor.'%') . " "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

	 /** 
	 * Valida las credenciales de un usuario
	 * @param type $p_usuario alias del usuario
	 * @param type $p_clave clave de acceso
	 * @return boolean verdadero si los daos son validos
	 */
	 public function inicia_sesion($p_usuario, $p_clave) { 
		 $arr_usuario = $this->lista(array( 
 			 'filtro' => sprintf('WHERE usuario = %s AND clave = md5(%s)', DBManager::formatSQLValue($p_usuario), DBManager::formatSQLValue($p_clave)) 
		 ));
		 if (count($arr_usuario['datos']) > 0):
			 $this->carga($arr_usuario['datos'][0]['id_usuario']);
			 return true;
		 else: 
			 $this->carga(-1); 
		 endif;
		 return false;	 }

	 /**
	 * Recupera el nivel de acceso del usuario sobre una seccion del administrador.
	 * @param type $p_codigo_seccion codigo de la sección.
	 * @return array vector con los permisos del usuario sobre una pantalla.
	 */
	 public function recupera_permisos($p_codigo_seccion) {
		 $permisos = array('alta' => 'N', 'baja' => 'N', 'modificacion' => 'N', 'consulta' => 'N');
		 $query = new DBQuery('SELECT * FROM permisos_secciones_administrables WHERE id_rol = {id_rol} AND codigo_seccion_administrable = {codigo_seccion_administrable}'); 
			 $query->addParam('id_rol', $this->_id_rol['value'], $this->_id_rol['datatype']); 
		 $query->addParam('codigo_seccion_administrable', $p_codigo_seccion, DBType::String); 
		 $datos = $this->_dbmanager->executeQuery($query);
		 if(count($datos) > 0): 
			 $permisos['alta'] = $datos[0]['alta']; 
			 $permisos['baja'] = $datos[0]['baja']; 
			 $permisos['modificacion'] = $datos[0]['modificacion']; 
			 $permisos['consulta'] = $datos[0]['consulta']; 
		 endif; 
		 return $permisos; 
	 } 

	 /** 
	 * Consulta las secciones sobre las cuales tiene permiso el usuario 
	 * @return array registros de los permisos a una seccion 
	 */
	 public function recupera_secciones() { 
		 $query =  new DBQuery("SELECT id_permiso_seccion_administrable, secciones_administrables.codigo_seccion_administrable, seccion_administrable, url, formulario_principal, grupo 
			 FROM  permisos_secciones_administrables INNER JOIN secciones_administrables 
				 ON secciones_administrables.codigo_seccion_administrable = permisos_secciones_administrables.codigo_seccion_administrable 
			 WHERE id_rol = {$this->_id_rol['value']}  
			 ORDER BY grupo, seccion_administrable"); 
		 return $this->_dbmanager->executeQuery($query);
	 } 

} 
?>