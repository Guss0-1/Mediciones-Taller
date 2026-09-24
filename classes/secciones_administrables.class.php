<?php 

/** 
 * secciones_administrables 
 * 
 * 18/06/2016 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class secciones_administrables { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_codigo_seccion_administrable = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_seccion_administrable = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_url = Array('value' => '', 'datatype' => DBType::String, 'validators' => array('required' => true)); 
	 protected $_grupo = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_formulario_principal = Array('value' => null, 'datatype' => DBType::String, 'validators' => array('required' => true)); 

	 /** 
	  * Crea una nueva instacia del objeto secciones_administrables. Inicializa las propiedades del objeto.
	  */ 
	 public function __construct() { 
		 $this->_dbmanager = new DBManager(); 
	 } 

	 /************************************ 
	  * PROPIEDADES PUBLICAS DE LA CLASE * 
	  ************************************/ 

	 public function set_codigo_seccion_administrable($p_codigo_seccion_administrable){ 
		 $this->_codigo_seccion_administrable['value'] = $p_codigo_seccion_administrable; 
	 } 
	 public function get_codigo_seccion_administrable(){ return $this->_codigo_seccion_administrable['value']; } 

	 public function set_seccion_administrable($p_seccion_administrable){ 
		 if(!DataValidator::validate($p_seccion_administrable, $this->_seccion_administrable['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>seccion_administrable</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_seccion_administrable['value'] = $p_seccion_administrable; 
	 } 
	 public function get_seccion_administrable(){ return $this->_seccion_administrable['value']; } 

	 public function set_url($p_url){ 
		 if(!DataValidator::validate($p_url, $this->_url['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>url</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_url['value'] = $p_url; 
	 } 
	 public function get_url(){ return $this->_url['value']; } 

	 public function set_grupo($p_grupo){ 
		 if(!DataValidator::validate($p_grupo, $this->_grupo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>grupo</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_grupo['value'] = $p_grupo; 
	 } 
	 public function get_grupo(){ return $this->_grupo['value']; } 

	 public function set_formulario_principal($p_formulario_principal){ 
		 if(!DataValidator::validate($p_formulario_principal, $this->_formulario_principal['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>formulario_principal</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_formulario_principal['value'] = $p_formulario_principal; 
	 } 
	 public function get_formulario_principal(){ return $this->_formulario_principal['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_codigo_seccion_administrable ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_codigo_seccion_administrable) { 
		 $query = new DBQuery('SELECT * FROM secciones_administrables WHERE codigo_seccion_administrable = {codigo_seccion_administrable}'); 
			 $query->addParam('codigo_seccion_administrable', $p_codigo_seccion_administrable, $this->_codigo_seccion_administrable['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_codigo_seccion_administrable['value'] = $datos[0]['codigo_seccion_administrable']; 
			 $this->_seccion_administrable['value'] = $datos[0]['seccion_administrable']; 
			 $this->_url['value'] = $datos[0]['url']; 
			 $this->_grupo['value'] = $datos[0]['grupo']; 
			 $this->_formulario_principal['value'] = $datos[0]['formulario_principal']; 
		 }else{ 
			 $this->_codigo_seccion_administrable['value'] = ''; 
			 $this->_seccion_administrable['value'] = ''; 
			 $this->_url['value'] = ''; 
			 $this->_grupo['value'] = ''; 
			 $this->_formulario_principal['value'] = null; 
		 } 
		 return ($this->_codigo_seccion_administrable['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_codigo_seccion_administrable['value'] == null) { 
			 $query = new DBQuery('INSERT INTO secciones_administrables(seccion_administrable, url, grupo, formulario_principal)VALUES({seccion_administrable}, {url}, {grupo}, {formulario_principal})'); 
			 $query->addParam('seccion_administrable', $this->_seccion_administrable['value'], $this->_seccion_administrable['datatype']); 
			 $query->addParam('url', $this->_url['value'], $this->_url['datatype']); 
			 $query->addParam('grupo', $this->_grupo['value'], $this->_grupo['datatype']); 
			 $query->addParam('formulario_principal', $this->_formulario_principal['value'], $this->_formulario_principal['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE secciones_administrables SET seccion_administrable = {seccion_administrable}, url = {url}, grupo = {grupo}, formulario_principal = {formulario_principal} WHERE codigo_seccion_administrable = {codigo_seccion_administrable}'); 
			 $query->addParam('codigo_seccion_administrable', $this->_codigo_seccion_administrable['value'], $this->_codigo_seccion_administrable['datatype']); 
			 $query->addParam('seccion_administrable', $this->_seccion_administrable['value'], $this->_seccion_administrable['datatype']); 
			 $query->addParam('url', $this->_url['value'], $this->_url['datatype']); 
			 $query->addParam('grupo', $this->_grupo['value'], $this->_grupo['datatype']); 
			 $query->addParam('formulario_principal', $this->_formulario_principal['value'], $this->_formulario_principal['datatype']); 
		 } 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($this->get_codigo_seccion_administrable() == null) { $this->set_codigo_seccion_administrable($this->_dbmanager->lastID()); } 
		 return ($filas_afectadas == -1)?false:true; 
	 } 

	 /** 
	  * Elimina un registro de la base de datos.
	  * @return Boolean Verdadero cuando el registro se elimino correctamente. 
	  */ 
	 public function elimina() { 
		 $query = new DBQuery('DELETE FROM secciones_administrables WHERE codigo_seccion_administrable = {codigo_seccion_administrable}'); 
			 $query->addParam('codigo_seccion_administrable', $this->_codigo_seccion_administrable['value'], $this->_codigo_seccion_administrable['datatype']); 
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

		 $sql_from = ' secciones_administrables  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  secciones_administrables.*  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
		 if($paginar === true){ 
			 $sql.= ' LIMIT ' . $num_inicio . ', ' . $reg_x_pag; 
		 } 
		 $datos = $dbmanager->executeQuery(new DBQuery($sql)); 

		 $retorno = array('datos' => $datos, 'cant_paginas' => $cant_paginas); 
		 return $retorno; 
	 } 

	 protected static function recupera_filtro_global($p_valor, $p_filtro = '') { 
		 $filtro = ''; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(secciones_administrables.codigo_seccion_administrable) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(secciones_administrables.seccion_administrable) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(secciones_administrables.url) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(secciones_administrables.grupo) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 //$filtro.= ($filtro == '')?' ': ' OR '; 
		 //$filtro.= "LOWER(CAST(secciones_administrables.formulario_principal AS \"varchar\"(100))) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>