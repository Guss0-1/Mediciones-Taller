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
$_parametros['jefe_grupo'] = TextHelper::cleanNumber($_POST['id_jefe']);
$_parametros['estados_ordenes'] = TextHelper::cleanNumber($_POST['estados_ordenes']);
$_parametros['fecha_comprometida'] = TextHelper::cleanString($_POST['fecha_comprometida']);
$_parametros['seguimiento_ordenes_id'] = TextHelper::cleanNumber($_POST['seguimiento_ordenes_id']);
$_parametros['tiempos_ordenes_id'] = TextHelper::cleanNumber($_POST['tiempos_ordenes_id']);
$_parametros['observaciones'] = TextHelper::cleanString($_POST['observaciones']);
$_parametros['reingreso'] = $_POST['reingreso'];

//SEGUIMIENTO DE ORDENES
$_seguimiento_ordenes_id = $_parametros['seguimiento_ordenes_id'];
$qseguimiento = new DBQuery("SELECT tecnico,ci,email_asesor, usu.nombre, usu.apellido, so.ot as ot, nro_asesor, estado, id_estado_actual, fecha_comprometida, nro_asesor, vehiculo_modelo, cliente, chasis, chapa, fecha_ingreso
							   FROM seguimiento_ordenes so
				               LEFT OUTER JOIN tiempos_ordenes tot ON so.id = tot.id_seguimiento and id_Estado = id_estado_actual
				               LEFT OUTER JOIN estados_ordenes eo ON eo.id = tot.id_estado
				               LEFT OUTER JOIN usuarios usu on usu.id_usuario = tot.id_usuario
							 	WHERE so.id = '$_seguimiento_ordenes_id'
							 	order by tot.fecha_creacion
							 	desc limit 1");
$seguimiento = $db->executeQuery($qseguimiento);

//ESTADOS DE ORDENES
$id_estado = $_parametros['estados_ordenes'];
$qestados = new DBQuery("SELECT estado,color  FROM estados_ordenes WHERE id = '$id_estado'");
$estados = $db->executeQuery($qestados);

//TECNICOS
$id_tecnico = $_parametros['tecnico'];
$qtecnicos = new DBQuery("SELECT tecnico FROM tecnicos WHERE id = '$id_tecnico'");
$tecnicos = $db->executeQuery($qtecnicos);

//JEFE GRUPO
$jefe_grupo = $_parametros['jefe_grupo'];
$qjefes_grupos = new DBQuery("SELECT nombre_apellido, email FROM jefes_grupos WHERE id = '$jefe_grupo'");
$jefes_grupos = $db->executeQuery($qjefes_grupos);

//ACTUALZAR DETALLE DE ORDENES
foreach($_parametros['reingreso'] as $i => $rs)
{
	$estado = ($rs == 1) ? 1 : 0;
	$qdetalle_ordenes = new DBQuery("UPDATE detalle_ordenes SET reingreso = '$estado' WHERE id = '$i'");
	$db->executeNonQuery($qdetalle_ordenes);
}

try{

	$_fecha_comprometida = date('d/m/Y H:i:s', strtotime($seguimiento[0]['fecha_comprometida']));

	if(
	   $seguimiento[0]['tecnico'] <> $_parametros['tecnico'] ||
	   $seguimiento[0]['id_estado_actual'] <> $_parametros['estados_ordenes'] ||
	   $_parametros['fecha_comprometida'] <> $_fecha_comprometida  ||
	   $_parametros['observaciones'] <> ''
	)
	{

		 $tiempos_ordenes  = new tiempos_ordenes();
		 $tiempos_ordenes->set_id(null);
		 $tiempos_ordenes->set_id_seguimiento( $_parametros['seguimiento_ordenes_id']);
		 $tiempos_ordenes->set_id_usuario( $_SESSION['s_id_usuario']);
		 $tiempos_ordenes->set_id_estado( $_parametros['estados_ordenes']);
		 $tiempos_ordenes->set_tecnico( $_parametros['tecnico']);
		 $tiempos_ordenes->set_id_jefe( $_parametros['jefe_grupo']);
		 $tiempos_ordenes->set_observaciones( $_parametros['observaciones']);
		 $tiempos_ordenes->set_fecha_comprometida( $_parametros['fecha_comprometida']);

		//ACTUALIZA EL ESTADO ACTUAL EN LA TABLA SEGUIMIENTO ORDENES
		$query_seguimiento = '';
		if($id_estado == 10 || $id_estado == 12)
		{
			$query_seguimiento = ', fecha_fin_estado_terminado = NOW()';
			$tiempos_ordenes->set_fecha_fin(date('Y-m-d H:i:s'));
		}

		 if($tiempos_ordenes->guarda())
		 {

				if(!empty($_parametros['tiempos_ordenes_id']))
			 	{
				 	$tiempos_ordenes_id = $_parametros['tiempos_ordenes_id'];
					$qestados = new DBQuery("UPDATE tiempos_ordenes set fecha_fin = NOW() WHERE id = '$tiempos_ordenes_id'");
					$db->executeNonQuery($qestados);
				}

				$query = new DBQuery("UPDATE seguimiento_ordenes SET id_estado_actual = '$id_estado' $query_seguimiento WHERE id = '$_seguimiento_ordenes_id'");
	      $db->executeNonQuery($query);

		      	// ENVIAR CORREO A POST VENTA
				$cuerpo = file_get_contents(CONF_ABS_ROOT_PATH . 'mail_template/index.htm');
			  $cuerpo = str_replace('%vehiculo_cliente%', 'Status del Vehiculo '.$seguimiento[0]['vehiculo_modelo'].' del Cliente '.$seguimiento[0]['cliente'], $cuerpo);
			  $cuerpo = str_replace('%fecha_ingreso%', date('d/m/Y', strtotime($seguimiento[0]['fecha_ingreso'])), $cuerpo);
			  $cuerpo = str_replace('%ot%', $seguimiento[0]['ot'], $cuerpo);
			  $cuerpo = str_replace('%chasis%', $seguimiento[0]['chasis'], $cuerpo);
			  $cuerpo = str_replace('%chapa%', $seguimiento[0]['chapa'], $cuerpo);
			  $cuerpo = str_replace('%estado_vehiculo_color%', $estados[0]['color'], $cuerpo);
			  $cuerpo = str_replace('%estado_vehiculo%', $estados[0]['estado'], $cuerpo);
			  $cuerpo = str_replace('%fecha_comprometida%', (($id_estado != 10) ? $_parametros['fecha_comprometida'] : ''), $cuerpo);
			  $cuerpo = str_replace('%jefe_grupo%', $jefes_grupos[0]['nombre_apellido'], $cuerpo);
			  $cuerpo = str_replace('%tecnico_actual%', (($id_estado != 10) ? $tecnicos[0]['tecnico'] : ''), $cuerpo);
			  $cuerpo = str_replace('%observaciones%', ((!empty($_parametros['observaciones'])) ? $_parametros['observaciones'] : ''), $cuerpo);
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
				$mail->Subject = trim($seguimiento[0]['cliente']) . " - " . trim($seguimiento[0]['vehiculo_modelo']) . " - " . trim($estados[0]['estado']);


				//crear asistencia tecnica
			 if($id_estado == 14 && $seguimiento[0]['id_estado_actual'] != 14){

				 $asistencia_tecnica  = new asistencia_tecnica();
				 $asistencia_tecnica->set_id(null);
				 $asistencia_tecnica->set_ot($seguimiento[0]['ot']);
				 $asistencia_tecnica->set_vehiculo_modelo($seguimiento[0]['vehiculo_modelo']);
				 $asistencia_tecnica->set_cliente($seguimiento[0]['cliente']);
				 $asistencia_tecnica->set_chasis($seguimiento[0]['chasis']);
				 $asistencia_tecnica->set_chapa($seguimiento[0]['chapa']);
				 $asistencia_tecnica->set_solicitud($_parametros['observaciones']);
				 $asistencia_tecnica->set_id_usuario_creacion($_SESSION['s_id_usuario']);
				 $asistencia_tecnica->set_id_tecnico(361);
				 $asistencia_tecnica->set_id_estado(0);

				 if($asistencia_tecnica->guarda())
				 {
					 $id_insertado =	$asistencia_tecnica->get_id();
					 $asistencia_tecnica->set_at('ATC-'.$id_insertado);
					 $asistencia_tecnica->guarda();
					 $at = 'ATC-'.$id_insertado;

					 $link = '<![if !mso]><a style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;
					 text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #4eaacc;font-family: PT Serif, Georgia, serif;"
					 href="http://mediciones.perfecta.lan/modificar_at.php?chasis='.$at.'">VER DETALLES</a><![endif]>';

					 $cuerpoAT = "<p>Se ha creado la asistenia t&eacute;cnica numero $at : $link </p>";

					 $mail->AddCC('marcelo.llanes@perfecta.com.py', 'Marcelo Llanes');
					 $mail->MsgHTML($cuerpoAT);
					 $mail->Send();

					}
			 }

				//ASESOR DE SERVICIOS
				if(!empty($seguimiento[0]['email_asesor']))
				{
					$mail->AddAddress($seguimiento[0]['email_asesor'], $seguimiento[0]['nro_asesor']);
				}
				//JEFE DE GRUPO
				$mail->AddCC($jefes_grupos[0]['email'], $jefes_grupos[0]['nombre_apellido']);
				//JEFE DE ASESORES
				$mail->AddCC('fredy.ramirez@perfecta.com.py', 'Fredy Ramirez');
				//TORRE DE CONTROL
				if( $id_estado == 18 || $id_estado == 20){

					if (substr( $seguimiento[0]['ot'], 0, 3 ) === "OTH") {
						$mail->AddCC('julio.orrego@perfecta.com.py', 'Julio Orrego');
					} elseif (substr( $seguimiento[0]['ot'], 0, 3 ) === "OTE") {
							$mail->AddCC('katherine.noble@perfecta.com.py', 'Katherine Noble');

					}else{
						$mail->AddCC('torredecontrol.asu@perfecta.com.py', 'Torre de Control');
					}
				}


				$mail->MsgHTML($cuerpo);
				if($mail->Send()){
					die(json_encode(array("success" => true, 'mensaje' => 'El mensaje ha sido enviado')));
				}

		 }
	}else{
		echo json_encode(array('success'=>true, 'mensaje' => 'La OT no fue modificada.'));
	}

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}
