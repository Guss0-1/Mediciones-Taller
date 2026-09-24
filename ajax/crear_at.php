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

$_parametros['chasis_in'] = ($_POST['chasis_in']);
$_parametros['chapa_in'] = ($_POST['chapa_in']);
$_parametros['modelo_in'] = ($_POST['modelo_in']);
$_parametros['anio_in'] = ($_POST['anio_in']);
$_parametros['cliente'] = ($_POST['cliente']);
$_parametros['numero_ot'] = ($_POST['numero_ot']);
$_parametros['solicitud'] = ($_POST['solicitud']);
$_parametros['tecnico'] = ($_POST['tecnico']);
$_parametros['estado_a'] = ($_POST['estado_a']);
$_parametros['observaciones'] = ($_POST['observaciones']);


//ASISTENCIA TECNICA
$chasisParam = $_parametros['chasis_in'];
$qasistencia_tecnica = new DBQuery("SELECT *  FROM asistencia_tecnica WHERE chasis = '$chasisParam'");
$asistencia_tecnica = $db->executeQuery($qasistencia_tecnica);

try{

		// PREPARAR CORREO PARA ASISTENCIA TECNICA

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
			$mail->Subject = 'Asistencia técnica generada: '.trim($_parametros['cliente']) . " - " . trim($_parametros['chasis_in']) . " - " . trim($_parametros['modelo_in']);

			/*if($asistencia_tecnica){
			}*/
						$asistencia_tecnica  = new asistencia_tecnica();
						$asistencia_tecnica->set_id(null);
						$asistencia_tecnica->set_ot($_parametros['numero_ot']);
						$asistencia_tecnica->set_vehiculo_modelo($_parametros['modelo_in']);
						$asistencia_tecnica->set_cliente($_parametros['cliente']);
						$asistencia_tecnica->set_chasis($_parametros['chasis_in']);
						$asistencia_tecnica->set_chapa($_parametros['chapa_in']);
						$asistencia_tecnica->set_solicitud( $_parametros['solicitud']);
						$asistencia_tecnica->set_id_usuario_creacion($_SESSION['s_id_usuario']);
						$asistencia_tecnica->set_observacion($_parametros['observaciones']);
						$asistencia_tecnica->set_id_tecnico(391);
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


							 $cuerpo = "<p>Se ha creado la asistenia tecnica numero $at : $link </p>";


							$mail->AddAddress("marcelo.llanes@perfecta.com.py");
							$mail->MsgHTML($cuerpo);
								if($mail->Send()){
									die(json_encode(array("success" => true, 'mensaje' => 'El mensaje ha sido enviado')));
								}

				     }

} catch (Exception $e) {
    echo json_encode(array('success'=>false));
}
