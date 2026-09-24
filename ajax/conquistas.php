<?php 
include_once '../inc/config.inc.php'; 

header('Content-type: application/json');

$_parametros['evento'] = TextHelper::cleanNumber($_POST['evento']);
$_parametros['vendedor'] = TextHelper::cleanNumber($_POST['vendedor']);
$_parametros['nombre'] = TextHelper::cleanString($_POST['nombre']);
$_parametros['apellido'] = TextHelper::cleanString($_POST['apellido']);
$_parametros['genero'] = TextHelper::cleanString($_POST['genero']);
$_parametros['pais'] = TextHelper::cleanNumber($_POST['pais']);
$_parametros['newsletter'] = TextHelper::cleanString(implode(',',$_POST['newsletter']));
$_parametros['marca'] = TextHelper::cleanNumber($_POST['marca']);
$_parametros['modelo'] = TextHelper::cleanNumber($_POST['modelo']);
$_parametros['email'] = TextHelper::cleanString($_POST['email']);
$_parametros['telefono'] = TextHelper::cleanString($_POST['telefono']);
$_parametros['tipo_telefono'] = TextHelper::cleanString($_POST['tipo_telefono']);
$_parametros['comentarios'] = TextHelper::cleanString($_POST['comentarios']);
$_parametros['nro_documento'] = TextHelper::cleanString($_POST['nro_documento']);
$_parametros['nro_entrada'] = TextHelper::cleanString($_POST['nro_entrada']);

try{

	$conquistas = new conquistas(); 
	$conquistas->set_id(null); 
	$conquistas->set_id_evento( $_parametros['evento']); 
	$conquistas->set_id_invitacion( $_parametros['vendedor']); 
	$conquistas->set_nombre( $_parametros['nombre']); 
	$conquistas->set_apellido( $_parametros['apellido']); 
	$conquistas->set_genero( $_parametros['genero']); 
	$conquistas->set_id_pais( $_parametros['pais']); 
	$conquistas->set_ids_newsletter( $_parametros['newsletter']); 
	$conquistas->set_id_marca_automovil_interes( $_parametros['marca']); 
	$conquistas->set_id_modelo_automovil_interes( $_parametros['modelo']); 
	$conquistas->set_email( $_parametros['email']); 
	$conquistas->set_telefono( $_parametros['telefono']); 
	$conquistas->set_tipo_telefono( $_parametros['tipo_telefono']); 
	$conquistas->set_comentarios( $_parametros['comentarios']); 
	$conquistas->set_id_usuario( $_SESSION['s_id_usuario']); 
	$conquistas->set_nro_documento( $_parametros['nro_documento']); 
	$conquistas->set_nro_entrada(  $_parametros['nro_entrada']); 
	$conquistas->guarda(); 

	echo json_encode(array('success'=>true));

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}