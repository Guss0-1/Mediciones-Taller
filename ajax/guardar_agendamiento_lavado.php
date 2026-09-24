<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();
$id_agendamiento = $_POST['id_lavado'];
$fecha_hora_agendamiento = $_POST['fecha_agendamiento'];
$seguimiento_ordenes_id = TextHelper::cleanNumber($_POST['id_seguimiento_ordenes_lav']);
$id_usuario = $_SESSION['s_id_usuario'];

$qseguimiento = new DBQuery("SELECT so.id, so.comentario_no_conformidad, so.ot
							  FROM seguimiento_ordenes so
							 	WHERE so.id = '$seguimiento_ordenes_id'
							 	limit 1");
$seguimiento = $db->executeQuery($qseguimiento);

try {
	$myDateTime = DateTime::createFromFormat('d/m/Y H:i:s', $fecha_hora_agendamiento);
  $fecha_hora_agendamiento = $myDateTime->format('Y-m-d H:i:s');
	$ot = $seguimiento[0]['ot'];

	if(empty($id_agendamiento) ){
		//crea
		$qcrearlavado = new DBQuery("INSERT INTO lavado (
				id_seguimiento_ordenes, fecha_agendamiento, estado, ot
			) VALUES (
				'$seguimiento_ordenes_id', '$fecha_hora_agendamiento', 0, '$ot') ;");

		$db->executeNonQuery($qcrearlavado);
		echo json_encode(array('success'=>true, 'mensaje' => 'Lavado agendado.'));
	}else{
		//actualiza
		 $qupdatelavado = new DBQuery("UPDATE conquestool.lavado
			SET fecha_agendamiento = '$fecha_hora_agendamiento', estado = 0
			WHERE id_lavado = '$id_agendamiento';");
		 $db->executeNonQuery($qupdatelavado);
		 echo json_encode(array('success'=>true, 'mensaje' => 'Agendamiento de lavado actualizado.'));

	}
  header("Location: {$_SERVER['HTTP_REFERER']}");
} catch (Exception $e) {
	 echo json_encode(array('success'=>false));
}
