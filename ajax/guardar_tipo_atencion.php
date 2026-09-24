<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

$_seguimiento_ordenes_id = TextHelper::cleanNumber($_POST['seguimiento_ordenes_id']);
$_parametros['id_tipo_de_atencion'] = TextHelper::cleanNumber($_POST['id_tipo_de_atencion']);

//SEGUIMIENTO DE ORDENES
$qseguimiento = new DBQuery("SELECT id_tipo_de_atencion
							  FROM seguimiento_ordenes so
							 	WHERE so.id = '$_seguimiento_ordenes_id'
							 	ORDER BY id DESC LIMIT 1");
$seguimiento = $db->executeQuery($qseguimiento);

try {

	if($_parametros['id_tipo_de_atencion'] <> $seguimiento[0]['id_tipo_de_atencion']){
		$id_tipo = $_parametros['id_tipo_de_atencion'];
		if($id_tipo != ''){
			$query = new DBQuery("UPDATE seguimiento_ordenes SET id_tipo_de_atencion = '$id_tipo' WHERE id = '$_seguimiento_ordenes_id'");
			$db->executeNonQuery($query);

			echo json_encode(array('success'=>true, 'mensaje' => 'La OT fue modificada con éxito.'));
		}else{

			$query = new DBQuery("UPDATE seguimiento_ordenes SET id_tipo_de_atencion = NULL WHERE id = '$_seguimiento_ordenes_id'");
			$db->executeNonQuery($query);

			echo json_encode(array('success'=>true, 'mensaje' => 'La OT fue modificada con éxito.'));

		}

	}
header("Location: {$_SERVER['HTTP_REFERER']}");
} catch (Exception $e) {
	    echo json_encode(array('success'=>false));
}
