<?php 

/** 
 * vehiculo 
 * 
 * 13/07/2019 - Autor - Registrá en este espacio las modificaciones realizadas en la clase iniciando la linea con la fecha en que haces los cambios y tu nombre. No te olvide de cambiar el nro. de version. * 
 * @version	1.0 
 * @autor 		PHPGen - version 2.0
 */ 

class vehiculo { 

	 protected $_dbmanager = null; 

	 // Propiedades del objeto que representan los campos de la tabla. 
	 protected $_id_vehiculo = Array('value' => null, 'datatype' => DBTYpe::Integer, 'validators' => array('required' => true, 'digits' => true)); 
	 protected $_chasis = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_chapa = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_modelo = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 
	 protected $_anio = Array('value' => '', 'datatype' => DBType::String, 'validators' => array()); 

	 /** 
	  * Crea una nueva instacia del objeto vehiculo. Inicializa las propiedades del objeto.
	  */ 
	 public function __construct() { 
		 $this->_dbmanager = new DBManager(); 
	 } 

	 /************************************ 
	  * PROPIEDADES PUBLICAS DE LA CLASE * 
	  ************************************/ 

	 public function set_id_vehiculo($p_id_vehiculo){ 
		 $this->_id_vehiculo['value'] = $p_id_vehiculo; 
	 } 
	 public function get_id_vehiculo(){ return $this->_id_vehiculo['value']; } 

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

	 public function set_modelo($p_modelo){ 
		 if(!DataValidator::validate($p_modelo, $this->_modelo['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>modelo</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_modelo['value'] = $p_modelo; 
	 } 
	 public function get_modelo(){ return $this->_modelo['value']; } 

	 public function set_anio($p_anio){ 
		 if(!DataValidator::validate($p_anio, $this->_anio['validators'])) 
			 throw new Exception('Error al establecer el valor de <strong>anio</strong>:<br/>' . DataValidator::get_error_text()); 
		 $this->_anio['value'] = $p_anio; 
	 } 
	 public function get_anio(){ return $this->_anio['value']; } 

	 /************************************************** 
	  * METODOS PARA RECUPERACION Y GUARADADO DE DATOS * 
	  **************************************************/ 

	 /** 
	  * Recupera en las propiedades del objeto la información de un registro en la base de datos.
	  * @param Integer $p_id_vehiculo ID del registro a cargar. 
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function carga($p_id_vehiculo) { 
		 $query = new DBQuery('SELECT * FROM vehiculo WHERE id_vehiculo = {id_vehiculo}'); 
		 $query->addParam('id_vehiculo', $p_id_vehiculo, $this->_id_vehiculo['datatype']); 
		 $datos = $this->_dbmanager->executeQuery($query); 
		 if(count($datos) > 0) { 
			 $this->_id_vehiculo['value'] = $datos[0]['id_vehiculo']; 
			 $this->_chasis['value'] = $datos[0]['chasis']; 
			 $this->_chapa['value'] = $datos[0]['chapa']; 
			 $this->_modelo['value'] = $datos[0]['modelo']; 
			 $this->_anio['value'] = $datos[0]['anio']; 
		 }else{ 
			 $this->_id_vehiculo['value'] = null; 
			 $this->_chasis['value'] = ''; 
			 $this->_chapa['value'] = ''; 
			 $this->_modelo['value'] = ''; 
			 $this->_anio['value'] = ''; 
		 } 
		 return ($this->_id_vehiculo['value'] == null) ? false : true; 
	 } 

	 /** 
	  * Guarda la información de las propiedades en la BD.
	  * @return Boolean Verdadero cuando el registro se cargo correctamente. 
	  */ 
	 public function guarda() { 
		 if($this->_id_vehiculo['value'] == null) { 
			 $query = new DBQuery('INSERT INTO vehiculo(chasis, chapa, modelo, anio)VALUES({chasis}, {chapa}, {modelo}, {anio})'); 
			 $query->addParam('chasis', $this->_chasis['value'], $this->_chasis['datatype']); 
			 $query->addParam('chapa', $this->_chapa['value'], $this->_chapa['datatype']); 
			 $query->addParam('modelo', $this->_modelo['value'], $this->_modelo['datatype']); 
			 $query->addParam('anio', $this->_anio['value'], $this->_anio['datatype']); 
		 }else{ 
			 $query = new DBQuery('UPDATE vehiculo SET chasis = {chasis}, chapa = {chapa}, modelo = {modelo}, anio = {anio} WHERE id_vehiculo = {id_vehiculo}'); 
			 $query->addParam('id_vehiculo', $this->_id_vehiculo['value'], $this->_id_vehiculo['datatype']); 
			 $query->addParam('chasis', $this->_chasis['value'], $this->_chasis['datatype']); 
			 $query->addParam('chapa', $this->_chapa['value'], $this->_chapa['datatype']); 
			 $query->addParam('modelo', $this->_modelo['value'], $this->_modelo['datatype']); 
			 $query->addParam('anio', $this->_anio['value'], $this->_anio['datatype']); 
		 } 
		 $filas_afectadas = $this->_dbmanager->executeNonQuery($query); 
		 if($this->get_id_vehiculo() == null) { $this->set_id_vehiculo($this->_dbmanager->lastID()); } 
		 return ($filas_afectadas == -1)?false:true; 
	 } 

	 /** 
	  * Elimina un registro de la base de datos.
	  * @return Boolean Verdadero cuando el registro se elimino correctamente. 
	  */ 
	 public function elimina() { 
		 $query = new DBQuery('DELETE FROM vehiculo WHERE id_vehiculo = {id_vehiculo}'); 
		 $query->addParam('id_vehiculo', $this->_id_vehiculo['value'], $this->_id_vehiculo['datatype']); 
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

		 $sql_from = ' vehiculo  '; 

		 $cant_filas = $dbmanager->executeScalar(new DBQuery('SELECT count(*) FROM ' . $sql_from . ' ' . $filtro)); 
		 $cant_paginas = ceil($cant_filas / $reg_x_pag); 
		 $num_inicio = (($num_pagina - 1) * $reg_x_pag); 

		 $sql = 'SELECT  vehiculo.*  FROM ' . $sql_from . ' ' . $filtro . ' ' . $orden; 
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
			 $filtro.= "vehiculo.id_vehiculo = " . DBManager::formatSQLValue($p_valor,"Integer") . " "; 
		 } 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(vehiculo.chasis) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(vehiculo.chapa) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(vehiculo.modelo) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro.= ($filtro == '')?' ': ' OR '; 
		 $filtro.= "LOWER(vehiculo.anio) LIKE LOWER(" . DBManager::formatSQLValue('%'.$p_valor.'%') . ") "; 
		 $filtro = (($p_filtro == '')?' WHERE (' : $p_filtro . ' AND (') . $filtro . ' ) '; 
		 return $filtro; 
	 } 

} 
?>