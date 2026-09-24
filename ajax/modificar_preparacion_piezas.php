<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once CONF_ABS_ROOT_PATH . 'vendor/PHPMailer/src/Exception.php';
require_once CONF_ABS_ROOT_PATH . 'vendor/PHPMailer/src/PHPMailer.php';
require_once CONF_ABS_ROOT_PATH . 'vendor/PHPMailer/src/SMTP.php';

$db = new DBManager();

$_parametros['tecnico'] = TextHelper::cleanNumber($_POST['tecnico']);
$_parametros['jefe_grupo'] = TextHelper::cleanNumber($_POST['jefe_grupo']);
$_parametros['seguimiento_ordenes_id'] = TextHelper::cleanNumber($_POST['seguimiento_ordenes_id']);
$_parametros['estados_ordenes'] = $_POST['estados_ordenes'];
$_parametros['observaciones'] = $_POST['observaciones'];
$_parametros['tiempos_ordenes'] = $_POST['tiempos_ordenes'];

//SEGUIMIENTO DE ORDENES
$_seguimiento_ordenes_id = $_parametros['seguimiento_ordenes_id'];
$qseguimiento = new DBQuery("SELECT tecnico,ci,email_asesor, usu.nombre, usu.apellido, so.ot as ot, nro_asesor, estado, id_estado_actual, fecha_comprometida, nro_asesor, vehiculo_modelo, cliente, chasis, chapa, fecha_ingreso, color
							   FROM seguimiento_ordenes so
				               LEFT OUTER JOIN tiempos_ordenes tot ON so.id = tot.id_seguimiento and id_Estado = id_estado_actual
				               LEFT OUTER JOIN estados_ordenes eo ON eo.id = tot.id_estado
				               LEFT OUTER JOIN usuarios usu on usu.id_usuario = tot.id_usuario
							 	WHERE so.id = '$_seguimiento_ordenes_id'
							 	order by tot.fecha_creacion
							 	desc limit 1");
$seguimiento = $db->executeQuery($qseguimiento);

//TECNICOS
$id_tecnico = $_parametros['tecnico'];
$qtecnicos = new DBQuery("SELECT tecnico FROM tecnicos WHERE id = '$id_tecnico'");
$tecnicos = $db->executeQuery($qtecnicos);

//JEFE GRUPO
$jefe_grupo = $_parametros['jefe_grupo'];
$qjefes_grupos = new DBQuery("SELECT nombre_apellido, email FROM jefes_grupos WHERE id = '$jefe_grupo'");
$jefes_grupos = $db->executeQuery($qjefes_grupos);

try{

		//recorrer los estados de preparacion de piezas, si está terminado actualizar tiempo
		foreach($_parametros['estados_ordenes'] as $id_prep => $rs)
		{

		    $usuario_mod = $_SESSION['s_id_usuario'];
		    $estado = $rs;
		    $observacion = trim($_parametros['observaciones'][$id_prep]);
		    $tiempos_ordenes_id = $_parametros['tiempos_ordenes'][$id_prep];

		    $qpreparacion_piezas = new DBQuery("UPDATE preparacion_piezas SET id_usuario_modificacion = '$usuario_mod', estado = '$estado', observacion = '$observacion'  WHERE id = '$id_prep'");

			$db->executeNonQuery($qpreparacion_piezas);

			if($rs == 1){
				$qpreparacion_piezas = new DBQuery("UPDATE preparacion_piezas SET fecha_fin = NOW() WHERE id = '$id_prep' and estado =1");
				$db->executeNonQuery($qpreparacion_piezas);
			}

			$qestados = new DBQuery("UPDATE tiempos_ordenes set fecha_fin = NOW() WHERE id = '$tiempos_ordenes_id'");
			$db->executeNonQuery($qestados);
		}


            // ENVIAR CORREO A POST VENTA
		$cuerpo = file_get_contents(CONF_ABS_ROOT_PATH . 'mail_template/index.htm');
	  $cuerpo = str_replace('%vehiculo_cliente%', 'Status del Vehiculo '.$seguimiento[0]['vehiculo_modelo'].' del Cliente '.$seguimiento[0]['cliente'], $cuerpo);
	  $cuerpo = str_replace('%fecha_ingreso%', date('d/m/Y', strtotime($seguimiento[0]['fecha_ingreso'])), $cuerpo);
	  $cuerpo = str_replace('%ot%', $seguimiento[0]['ot'], $cuerpo);
	  $cuerpo = str_replace('%chasis%', $seguimiento[0]['chasis'], $cuerpo);
	  $cuerpo = str_replace('%chapa%', $seguimiento[0]['chapa'], $cuerpo);
	  $cuerpo = str_replace('%estado_vehiculo_color%', $seguimiento[0]['color'], $cuerpo);
	  $cuerpo = str_replace('%estado_vehiculo%',$seguimiento[0]['estado'], $cuerpo);
	  $cuerpo = str_replace('%fecha_comprometida%', (($seguimiento[0]['id_estado_actual'] != 10) ? $seguimiento[0]['fecha_comprometida'] : ''), $cuerpo);
	  $cuerpo = str_replace('%jefe_grupo%', $jefes_grupos[0]['nombre_apellido'], $cuerpo);
	  $cuerpo = str_replace('%tecnico_actual%', (($seguimiento[0]['id_estado_actual'] != 10) ? $tecnicos[0]['tecnico'] : ''), $cuerpo);
	  $cuerpo = str_replace('%observaciones%', 'Ha habido una actualización de preparación de piezas', $cuerpo);
	  $cuerpo = str_replace('%actualizado_por%', $seguimiento[0]['nombre'].' '.$seguimiento[0]['apellido'], $cuerpo);
	  $cuerpo = str_replace('%link_ot%', $seguimiento[0]['ot'], $cuerpo);

		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = 'smtp.office365.com';
		$mail->Port       = 25;
		$mail->SMTPSecure = 'tls';
		$mail->CharSet="UTF-8";
		$mail->Username = 'servicios@perfecta.com.py';
		$mail->Password = 'Perfecta2019';
		$mail->SMTPAuth = true;
		$mail->From = 'servicios@perfecta.com.py';
		$mail->FromName = $_parametros['nombre'];
		$mail->IsHTML(true);
		$mail->Timeout = 60;
		$mail->AddEmbeddedImage(CONF_ABS_ROOT_PATH . 'mail_template/images/perfecta-logo.jpg', 'logo_perfecta');
		$mail->CharSet = 'UTF-8';
		$mail->Subject = trim($seguimiento[0]['cliente']) . " - " . trim($seguimiento[0]['vehiculo_modelo']) . " - " . trim($seguimiento[0]['estado']);


		//JEFE DE GRUPO
		$mail->AddCC($jefes_grupos[0]['email'], $jefes_grupos[0]['nombre_apellido']);
		//ATENCION TALLER
		if (substr( $seguimiento[0]['ot'], 0, 3 ) === "OTH") {
			$mail->AddCC('cesar.saucedo@perfecta.com.py', 'Cesar Saucedo');
		} elseif (substr( $seguimiento[0]['ot'], 0, 3 ) === "OTE") {
			 $mail->AddCC('lucas.rojas@perfecta.com.py', 'Lucas Rojas');

		}else{
			$mail->AddCC('at@perfecta.com.py', 'Atencion taller');
		}


		$mail->MsgHTML($cuerpo);
		if($mail->Send()){
			die(json_encode(array("success" => true, 'mensaje' => 'El mensaje ha sido enviado')));
		}

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}
