<?php 
include_once '../inc/config.inc.php'; 

header('Content-type: application/json');

$_parametros['fecha_reclamo'] = TextHelper::cleanString($_POST['fecha_reclamo']);
$_parametros['razon_social'] = TextHelper::cleanString($_POST['razon_social']);
$_parametros['modelo_automovil'] = TextHelper::cleanNumber($_POST['modelo_automovil']);
$_parametros['contacto'] = TextHelper::cleanString($_POST['contacto']);
$_parametros['id_ciudad_cliente'] = TextHelper::cleanNumber($_POST['ciudad']);
$_parametros['id_canal_queja'] = TextHelper::cleanNumber($_POST['canal_queja']);
$_parametros['reclamo'] = TextHelper::cleanString($_POST['reclamo']);
$_parametros['id_area_afectada'] = TextHelper::cleanNumber($_POST['area_afectada']);
$_parametros['observaciones'] = TextHelper::cleanString($_POST['comentarios']);

try{

	 $reclamos_clientes = new reclamos_clientes(); 
	 $reclamos_clientes->set_id(null); 
	 $reclamos_clientes->set_fecha_reclamo( $_parametros['fecha_reclamo']); 
	 $reclamos_clientes->set_razon_social( $_parametros['razon_social']); 
	 $reclamos_clientes->set_contacto( $_parametros['contacto']); 
	 $reclamos_clientes->set_id_modelo_automovil( $_parametros['modelo_automovil']); 
	 $reclamos_clientes->set_id_ciudad_cliente( $_parametros['id_ciudad_cliente']); 
	 $reclamos_clientes->set_id_canal_queja( $_parametros['id_canal_queja']); 
	 $reclamos_clientes->set_reclamo( $_parametros['reclamo']); 
	 $reclamos_clientes->set_id_area_afectada( $_parametros['id_area_afectada']); 
	 $reclamos_clientes->set_observaciones( $_parametros['observaciones']); 
	 $reclamos_clientes->set_status( 'ABIERTO'); 
	 $reclamos_clientes->set_id_usuario( $_SESSION['s_id_usuario']); 
	 $reclamos_clientes->guarda(); 

	echo json_encode(array('success'=>true));

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}