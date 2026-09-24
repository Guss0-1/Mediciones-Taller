<?php

/**
 * Formatea una consulta SQL para ser ejecutada
 *
 * @author Marco Gulino
 * @version 1.0 2012-06-27
 */
class DBQuery {
 
    protected $_sql = "";
    protected $_params = array();
    
    /**
     * Crea una nueva instancia del Consulta
     * @param String $p_sql Consulta SQL
     */
    public function __construct($p_sql = "") {
        $this->_sql = $p_sql;
    }
    
    /**
     * Establece la consulta a ejecutar
     * @param String $p_sql Consulta SQL
     */
    public function setQuery($p_sql){
        $this->_sql = $p_sql;
    }

    /**
     * Agrega un parámetro a la consulta
     * @param String $p_param_name nombre del parametro
     * @param String $p_value valor del parametro
     * @param String $p_datatype tipo de datos del parametro. 
     *   Este parametro es utilizado para el formateo de los datos.
     *   Se deben utilizar los tipos de datos definidos en la clase DBType.
     * @return Boolean 
     */
    public function addParam($p_param_name, $p_value, $p_datatype = DBType::String) {
        
        try{
            $dbtype = new DBType($p_datatype);
        }catch(UnexpectedValueException $exc){ 
            EventLog::writeEntry($exc->getMessage(), 'error');
            die($exc->getMessage());
        }
        
        $p_param_name = strtolower($p_param_name);
        
        // Verificación de que el parametro no se duplique
        foreach ($this->_params as $key => $data):
            if ($key == $p_param_name)
                return false;
        endforeach;
        $this->_params[$p_param_name] = array('value' => $p_value, 'datatype' => $p_datatype);
        return true;
    }

    /**
     * Devuelve la consulta con los parametros remplazados por sus valores formateados.
     * @return String script SQL
     */
    public function getQuery(){
        
        $sql = $this->_sql;
        
        foreach ($this->_params as $param_name => $param_info):
            $sql = preg_replace(
                    "/\{$param_name\}/", 
                    self::formatSQLValue($param_info['value'], $param_info['datatype']), 
                    $sql);
        endforeach;
        
        $missing_params_text = '';
        preg_match('#\{(.*?)\}#', $sql, $missing_params);
        foreach($missing_params as $missing_param):
            $missing_params_text .= (($missing_params_text == '')?'':', ') . $missing_param;
        endforeach;
        if($missing_params_text != ''):
            die('No se definieron valores para los parametros: ' . $missing_params_text . $this->_sql);
        endif;
        
        return $sql;
    }
    
    /**
     * Formatea un valor SQL
     * @param type $p_value
     * @param type $p_datatype
     * @return string 
     */
    public static function formatSQLValue($p_value, $p_datatype = DBType::String) {
       
        $valor_formateado = addslashes($p_value);

        // CADENAS DE TEXTO
        if (preg_match('/string|text/', strtolower($p_datatype))):
            $valor_formateado = (strlen($valor_formateado) == 0) ? 'NULL' : "'{$valor_formateado}'";
            
        // NÚMEROS
        elseif (preg_match('/integer|decimal/', strtolower($p_datatype))):
            $valor_formateado = str_replace(',', '', $valor_formateado);
            if (($valor_formateado == "") || (!preg_match('/^\d+$/', $valor_formateado))):
                $valor_formateado = "NULL";
            else:
                $valor_formateado = $valor_formateado;
            endif;

        // FECHAS
        elseif (preg_match('/date|datetime/', strtolower($p_datatype))):
            if ($valor_formateado == ""):
                $valor_formateado = "NULL";
            else:
                $fecha_hora = preg_split("/ /", $valor_formateado);
                $arr_fecha = preg_split("/\//", $fecha_hora[0]);
                if (count($arr_fecha) === 3):
                    $valor_formateado = $arr_fecha[2] . "-" . $arr_fecha[1] . "-" . $arr_fecha[0];
                    if (count($fecha_hora) === 2)
                        $valor_formateado .= " " . $fecha_hora[1];
                    $valor_formateado = '\'' . $valor_formateado . '\'';
                else:
                    $arr_fecha = preg_split("/\-/", $fecha_hora[0]);
                    if (count($arr_fecha) === 3):
                        $valor_formateado = '\'' . $fecha_hora[0] . ' ' . $fecha_hora[1] . '\'';
                    else:
                        $valor_formateado = "NULL";
                    endif;
                endif;
            endif;
        elseif (preg_match('/time/', strtolower($p_datatype))):
            if(!preg_match('/([01]?[0-9]|2[0-3]):[0-5][0-9]/', $valor_formateado))
                $valor_formateado = "NULL";
        endif;
        return $valor_formateado;
    }
    
}

?>
