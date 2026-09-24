<?php
/**
 * Description of dbtype
 *
 * @author  Marco Gulino
 * @version 1.0 2012-06-27
 */
class DBType {

    const String    = "string";
    const DateTime  = "datetime";
    const Date      = "date";
    const Time      = "time";
    const Integer   = "integer";
    const Decimal   = "decimal";
    
    private $_type   = "string";
    
    public function __construct($p_dbtype = "string") {
        if(!preg_match('/string|datetime|date|datetime|time|integer|decimal/', $p_dbtype)){
            throw new UnexpectedValueException("{$p_dbtype} no es un tipo de datos no válido", $code, $previous);
        }else{
            $this->_type = $p_dbtype;
        }
    }
    
    public function __toString(){
        return $this->_type;
    }
     
}
?>
