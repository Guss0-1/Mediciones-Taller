<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');
//$pdo = new PDO("sqlsrv:Server=192.168.10.2;Database=Perfecta Automotores", "sa", "perfecta01");
$pdo = new PDO("dblib:host=mssql;dbname=Perfecta Automotores", "sa", "perfecta01");

//recibir parametros
$marcacion_id = $_POST['marcacion_id'];
$nro_tecnico_id = $_POST['nro_tecnico'];
$cod_tiempo_improductivo = $_POST['cod_tiempo_improductivo'];
$fecha_inicio = TextHelper::cleanString($_POST['fecha_inicio']);
$observaciones= TextHelper::cleanString($_POST['observaciones']);

//obtener marcacion
$qmarcaciones_incadea = "SELECT top 1 * FROM [dbo].[Productividad_marcaciones_improductivas] where id = ".$marcacion_id;
if($marcacion_id){
	$marcacion_incadea = $pdo->query($qmarcaciones_incadea)->fetchAll();
}

try{

//if(empty($marcacion_incadea)
/*$seguimiento[0]['tecnico'] <> $_parametros['tecnico'] ||
$seguimiento[0]['id_estado_actual'] <> $_parametros['estados_ordenes'] ||
$_parametros['fecha_comprometida'] <> $_fecha_comprometida  ||
$_parametros['observaciones'] <> ''  ||*/
	if(empty($marcacion_id) || $marcacion_id == 0)
	{

   //crear una marcacion nueva
	  $insert_marcacion = "INSERT INTO [dbo].[Productividad_marcaciones_improductivas]
		([nro_tecnico],[cod_tiempo_improductivo],[observacion],[fecha_inicio])
		VALUES
		($nro_tecnico_id
		,'$cod_tiempo_improductivo'
		,'$observaciones'
		,'$fecha_inicio'
		)";

		if($pdo->exec($insert_marcacion) === false){
			echo json_encode(array('success'=>false, 'mensaje' => 'Error, no fue insertado'));
		}else{
			 echo json_encode(array('success'=>true, 'mensaje' => 'Insertado con exito'));
		}

	}else{
		//actualizar la marcacion que exista
		//if(isset($_POST['finalizar_marcacion'])){
				//finalizar la marcacion solo si marcó finalizar
			$finalizar = ',[fecha_fin] = GETDATE() ';
		//}

		$update_marcacion = "UPDATE [dbo].[Productividad_marcaciones_improductivas]
    SET [cod_tiempo_improductivo] = '$cod_tiempo_improductivo',[observacion] = '$observaciones' $finalizar
 		WHERE id = $marcacion_id";

		if($pdo->exec($update_marcacion) === true){
			echo json_encode(array('success'=>false, 'mensaje' => 'Error, no fue actualizado'));

		}else{
			echo json_encode(array('success'=>true, 'mensaje' => 'Actualizado con exito'));
		}

	}

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}
