<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

$_parametros['asistencia_tecnica_id'] = TextHelper::cleanNumber($_POST['asistencia_tecnica_id']);
$_parametros['solicitud'] = TextHelper::cleanString($_POST['solicitud']);
$_parametros['estados_a'] = TextHelper::cleanNumber($_POST['estados_a']);
$_parametros['observaciones'] = trim(TextHelper::cleanString($_POST['observaciones']));

//SEGUIMIENTO DE ORDENES
$_idasistenciatecnica = $_parametros['asistencia_tecnica_id'];
$qasistenciatec = new DBQuery("SELECT * from asistencia_tecnica where id ='$_idasistenciatecnica'");
$asistencia = $db->executeQuery($qasistenciatec);

try{

	if(
	   $asistencia[0]['id_estado'] <> $_parametros['estados_a'] ||
	   $asistencia[0]['solicitud'] <> $_parametros['solicitud'] ||
	   $asistencia[0]['observacion'] <> $_parametros['observaciones']
	)
	{

		$usuario_mod = $_SESSION['s_id_usuario'];
		$idestado = $_parametros['estados_a'];
		$solicitud = $_parametros['solicitud'];
		$observaciones = $_parametros['observaciones'];
		$actualizar = "";
		if($_parametros['estados_a'] == 1){//terminado
			$actualizar = ", fecha_terminado = NOW() ";
		}

		if($_parametros['estados_a'] == 2){//terminado
			$actualizar = " ,fecha_proceso = NOW() ";
		}

		$qupdateasistencia = new DBQuery("UPDATE asistencia_tecnica SET fecha_edicion = NOW(), id_usuario_edicion = '$usuario_mod', id_estado = '$idestado', solicitud= '$solicitud' , observacion = '$observaciones' $actualizar WHERE id = '$_idasistenciatecnica'");
	  $db->executeNonQuery($qupdateasistencia);

		echo json_encode(array('success'=>true, 'mensaje' => 'La AT fue modificada con exito.'));

	}else{
		echo json_encode(array('success'=>true, 'mensaje' => 'La AT no fue modificada.'));
	}

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}
