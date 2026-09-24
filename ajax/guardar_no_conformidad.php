<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

$_seguimiento_ordenes_id = TextHelper::cleanNumber($_POST['seguimiento_ordenes_id']);
$_no_conformidad = TextHelper::cleanNumber($_POST['no_conformidad']);
$_comentarios = TextHelper::cleanString($_POST['comentarios']);
$_id_jefe_grupo = TextHelper::cleanNumber($_POST['jefe_grupo_no_conf']);
$_id_tecnico = TextHelper::cleanNumber($_POST['tecnico_no_conf']);
$_id_usuario = $_SESSION['s_id_usuario'];

$qseguimiento = new DBQuery("SELECT so.id, so.comentario_no_conformidad
							  FROM seguimiento_ordenes so
							 	WHERE so.id = '$_seguimiento_ordenes_id'
							 	limit 1");
$seguimiento = $db->executeQuery($qseguimiento);

try {

	$_id_jefe_grupo = !empty($_id_jefe_grupo) ? "'$_id_jefe_grupo'" : "NULL";
	$_id_tecnico = !empty($_id_tecnico) ? "'$_id_tecnico'" : "NULL";

	if($_no_conformidad == 0 ){
		//crea
					$qupdateseguimiento = new DBQuery("UPDATE seguimiento_ordenes
																	 set no_conformidad = 1, comentario_no_conformidad = '$_comentarios',
																	 fecha_no_conformidad = NOW(), id_usuario_no_conformidad =  $_id_usuario,
																	 id_jefe_grupo_no_conformidad = $_id_jefe_grupo, id_tecnico_no_conformidad = $_id_tecnico
																	 WHERE id = '$_seguimiento_ordenes_id'");
					 $db->executeNonQuery($qupdateseguimiento);
					 echo json_encode(array('success'=>true, 'mensaje' => 'No conformidad cargada correctamente.'));
	}else{
		//actualiza
		$qupdateseguimiento = new DBQuery("UPDATE seguimiento_ordenes
														 set no_conformidad = 1, comentario_no_conformidad = '$_comentarios',
														 id_usuario_no_conformidad =  $_id_usuario, id_jefe_grupo_no_conformidad = $_id_jefe_grupo,
														 id_tecnico_no_conformidad = $_id_tecnico
														 WHERE id = '$_seguimiento_ordenes_id'");
		 $db->executeNonQuery($qupdateseguimiento);
		 echo json_encode(array('success'=>true, 'mensaje' => 'No conformidad actualizada correctamente.'));

	}
header("Location: {$_SERVER['HTTP_REFERER']}");
} catch (Exception $e) {
	    echo json_encode(array('success'=>false));
}
