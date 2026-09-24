<?php

class Security {

    protected static $_ultimo_error = "";

    public static function get_last_error() {
        return self::$_ultimo_error;
    }

    public static function generateRandomPassword() {
        $p_password_clave = "";
        for ($i = 0; $i < 3; $i++) {
            $p_password_clave.= chr(rand(65, 90));
            $p_password_clave.= chr(rand(49, 57));
            $p_password_clave.= chr(rand(97, 122));
        }
        $p_password_clave.= chr(rand(97, 122));
        return $p_password_clave;
    }

    public static function validatePasswordFormat($p_password) {
        
        self::$_ultimo_error = '';
        
        if (intval(CONF_PASSWORD_LENGTH) > 0 && strlen($p_password) < intval(CONF_PASSWORD_LENGTH)) {
            self::$_ultimo_error = "La contraseña debe tener como mínimo " . CONF_PASSWORD_LENGTH . " letras.";
            return false;
        }
        
        $valid = true;
        $arr_password_conditions = preg_split('/\|/', CONF_PASSWORD_FORMAT);
        foreach ($arr_password_conditions as $condition):
            switch ($condition) {
                case 'a-z':
                    if (!preg_match('/[a-z]/', $p_password)) {
                        self::$_ultimo_error .= ((self::$_ultimo_error == '')?'':', ') . "letras en minuscula";
                         $valid = false;
                    }
                    break;
                case 'A-Z':
                    if (!preg_match('/[A-Z]/', $p_password)) {
                        self::$_ultimo_error .= ((self::$_ultimo_error == '')?'':', ') . "letras en mayuscula";
                         $valid = false;
                    }
                    break;
                case "0-9":
                    if (!preg_match('/[0-9]/', $p_password)) {
                        self::$_ultimo_error .= ((self::$_ultimo_error == '')?'':', ') . "números";
                         $valid = false;
                    }
                    break;
                case "#":
                    if (!preg_match('/(\*|\$|\#|\@|\%|\!|\-|\.|\,|\_")/', $p_password)) {
                        self::$_ultimo_error .= ((self::$_ultimo_error == '')?'':', ') . "caracteres especiales (\$#@%!-.,_).";
                        $valid = false;
                    }
                    break;
            }
        endforeach;
        if(!$valid){
            self::$_ultimo_error = 'El formato de la contraseña no es correcto. Las contraseña deben contener: ' . self::$_ultimo_error;
            return false;
        }
        
        if(CONF_PASSWORD_CHECK_VULNERABILITY == '1'){
            $palabras = claves_vulnerables::lista(array('filtro' => 'WHERE clave_vulnerable = ' . DBManager::formatSQLValue($p_password)));
            if (count($palabras['datos']) > 0) {
                self::$_ultimo_error = "La contraseña elegida es considerada vulnerable.";
                return false;
            }
        }

        return true;
    }

}

?>
