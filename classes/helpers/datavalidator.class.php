<?php
/**
 * Description of DataValidator
 *
 * @author  Marco Gulino
 * @version 1.0 2012-06-27
 */
class DataValidator {
    
   protected $_rules = array();
   protected $_rules_list = array('required','min','max','email','url','date','number','digits','minlength', 'maxlength');
   
   private static $_invalid_text = '';

   public static function validate($p_value, $p_validation_rules){
       $valid_data = true;
       self::$_invalid_text = '';
       if(!is_array($p_validation_rules)):
           throw new Exception('El parametro validation_rules no es valido.<br/>');
       endif;
       foreach($p_validation_rules as $rule => $value):
           switch($rule):
                case 'required':
                    if(($value === true) && !(strlen($p_value) > 0)):
                        $valid_data = false;
                        self::$_invalid_text .= 'El campo requerido<br/>';
                    endif; 
                    break;
                case 'min':
                    if(!empty($p_value) && ($value > $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'El valor mínimo para el campo es ' . $value . '<br/>';
                    endif; 
                    break;
                 case 'max':
                    if(!empty($p_value) && ($value < $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'El valor máximo para el campo es ' . $value . '<br/>';
                    endif; 
                    break;
                  case 'minlength':
                    if(!empty($p_value) && ($value > strlen($p_value))):
                        $valid_data = false;
                        self::$_invalid_text .= 'La longitud mínima para el campo es ' . $value . '<br/>';
                    endif; 
                    break;
                  case 'maxlength':
                    if(!empty($p_value) && ($value < strlen($p_value))):
                        $valid_data = false;
                        self::$_invalid_text .= 'La longitud máxima para el campo es ' . $value . '<br/>';
                    endif; 
                    break;
                 case 'url':
                     if(!empty($p_value) && !preg_match('/^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$/i', $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'El valor no es una URL valida<br />';
                     endif;
                     break;
                 case 'email':
                      if(!empty($p_value) && !preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'Email no valido<br />';
                     endif;
                     break;
                 case 'date':
                      if(!empty($p_value) && !preg_match('/(?:0[1-9]|[12][0-9]|3[01])\/(?:0[1-9]|1[0-2])\/(?:19|20\d{2})/', $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'Fecha no valida<br />';
                     endif;
                     break;
                 case 'number':
                      if(!empty($p_value) && !preg_match('/^-?(?:\d+|\d{1,3}(?:,\d{3})+)(?:\.\d+)?$/', $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'Numero no valido<br />';
                     endif;
                     break;
                   case 'digits':
                      if(!empty($p_value) && !preg_match('/^\d+$/', $p_value)):
                        $valid_data = false;
                        self::$_invalid_text .= 'Numero no valido<br />';
                     endif;
                     break;  
           endswitch;
           if(!$valid_data)
               break;
       endforeach;
       return $valid_data;
   }
   
   public static function get_error_text(){
       return self::$_invalid_text;
   }
}
?>
