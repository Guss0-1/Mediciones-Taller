<?php
error_reporting(E_ERROR|E_CORE_WARNING);
date_default_timezone_set('America/Asuncion');
ini_set('max_execution_time', 0);
ini_set('upload_max_filesize', "128M");
ini_set('post_max_size', "128M");


ini_set("session.cookie_lifetime","28800");
ini_set("session.gc_maxlifetime","28800");
//error_reporting(E_ALL);
ini_set('display_errors', true);
session_start();

define('CONF_SITE_TITLE', "Perfecta Automotores");
define('CONF_ROOT_PATH', "/");
define('CONF_SITE_URL', "http://" . $_SERVER['HTTP_HOST'] . CONF_ROOT_PATH);
define('CONF_ADMIN_URL', CONF_SITE_URL . "admin/");
define('CONF_UPLOAD_PATH', CONF_ROOT_PATH . "upload/");

define('CONF_ABS_ROOT_PATH', realpath(dirname(__FILE__). '/../') . '/');
define('CONF_ABS_UPLOAD_PATH', CONF_ABS_ROOT_PATH . 'upload');

// BASE DE DATOS

include('db.inc.php');

define('CONF_REG_X_PAG', 15);

// UPLOAD DE ARCHIVOSñ

define('CONF_UPLOAD_ALLOWED_IMAGES', 'image\/x-png|image\/png|image\/pjpeg|image\/jpeg|image\/gif');
define('CONF_UPLOAD_ALLOWED_FILES',  'image\/x-png|image\/png|image\/pjpeg|image\/jpeg|image\/gif|application\/zip|application\/x-rar-compressed|application\/pdf|application\/msword|application\/vnd.openxmlformats-officedocument.wordprocessingml.document|application\/vnd.ms-excel|application\/vnd.openxmlformats-officedocument.spreadsheetml.sheet|application\/vnd.ms-powerpoint|application\/vnd.openxmlformats-officedocument.presentationml.presentation');
define('CONF_UPLOAD_MAX_SIZE', 10485760); // 10MB

// SEGURIDAD 

define('CONF_PASSWORD_LENGTH', '6');
define('CONF_PASSWORD_FORMAT', '');
define('CONF_PASSWORD_EXPIRATION', '0');
define('CONF_PASSWORD_CHECK_VULNERABILITY','N');
define('CONF_PASSWORD_REPEAT', '0');

// ENUMS
$conf_dias_semana = array('1' => 'Lunes', '2' => 'Martes', '3' => 'Miercoles', '4' => 'Jueves', '5' => 'Viernes', '6' => 'Sabado', '7' => 'Domingo');

function __autoload($classname) {
    if(file_exists(CONF_ABS_ROOT_PATH . "classes/" . strtolower($classname) . ".class.php")){
        include_once(CONF_ABS_ROOT_PATH . "classes/" . strtolower($classname) . ".class.php");
    }elseif(file_exists(CONF_ABS_ROOT_PATH . "classes/helpers/" . strtolower($classname) . ".class.php")){
        include_once( CONF_ABS_ROOT_PATH . "classes/helpers/" . strtolower($classname) . ".class.php");
    }
}
?>