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


$_id_solicitud_pieza_c = TextHelper::cleanString($_POST['id_solicitud_pieza_c']);

$qdetalles = new DBQuery("SELECT
  id_solicitud_pieza_det,
  id_solicitud_pieza_cab,
  numero_pieza,
  descripcion,
  cantidad,
  id_estado,
  nro_factura,
  nro_guia,
  nro_pedido,
  fecha_pedido,
  comentario
FROM
  conquestool.solicitud_pieza_det
WHERE id_solicitud_pieza_cab = '$_id_solicitud_pieza_c'");
$detalles = $db->executeQuery($qdetalles);

$qcabecera = new DBQuery("SELECT u.email
	FROM
	solicitud_pieza_cab cab INNER JOIN usuarios u ON u.id_usuario = cab.id_usuario
	WHERE id_solicitud = '$_id_solicitud_pieza_c'");
$cabecera = $db->executeQuery($qcabecera);
$notificar = $cabecera[0][email];

try {
 $hasta = count($detalles);
 $actualizacion = 0;
 for ($i=0; $i < $hasta; $i++) {
	 $indice = $detalles[$i]['id_solicitud_pieza_det'];

	 //obtiene los detalles guardados
	 $estado_old =  $detalles[$i]['id_estado'];
   $transporte_old =  $detalles[$i]['id_tipo_transporte'];
	 $nro_guia_old =  $detalles[$i]['nro_guia'];
	 $nro_factura_old =  $detalles[$i]['nro_factura'];
   $nro_pedido_old =  $detalles[$i]['nro_pedido'];
	 $comentarios_old =  $detalles[$i]['comentario'];

	 //obtiene los detalles modificados
	 $estado = $_POST['estado-'.$indice];
   $transporte = $_POST['transporte-'.$indice];
	 $nro_guia = trim($_POST['nro_guia-'.$indice]);
	 $nro_factura = trim($_POST['nro_factura-'.$indice]);
   $nro_pedido = trim($_POST['nro_pedido-'.$indice]);
	 $comentarios = trim($_POST['observaciones-'.$indice]);
   //si hubo un cambio, actualiza el registro
	     if(($estado_old != $estado) ||
       (trim($transporte_old) != trim($transporte)) ||
			 (trim($nro_guia_old) != trim($nro_guia)) ||
			 (trim($nro_factura_old) != trim($nro_factura)) ||
       (trim($nro_pedido_old) != trim($nro_pedido)) ||
			 (trim($comentarios_old) != trim($comentarios))
		    ){
				 $actualizacion = 1;
				 $qupdate_detalle = new DBQuery("UPDATE
						  conquestool.solicitud_pieza_det
						SET
						  id_estado = '$estado',
              id_tipo_transporte = '$transporte',
						  nro_factura = '$nro_factura',
						  nro_guia = '$nro_guia',
              nro_pedido = '$nro_pedido',
						  comentario = '$comentarios'
						WHERE id_solicitud_pieza_det = $indice");
						$db->executeNonQuery($qupdate_detalle);

	     }

  }
	if($actualizacion == 1){
		//enviar correo de notificación
		$link = '<![if !mso]><a style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;
		text-decoration: none !important;transition: opacity 0.1s ease-in;color: #ffffff !important;background-color: #4eaacc;font-family: PT Serif, Georgia, serif;"
		href="http://mediciones.perfecta.lan/solicitud_pieza_editar.php?id='.$_id_solicitud_pieza_c.'">VER DETALLES</a><![endif]>';

    //http://mediciones.perfecta.lan/consulta_ot.php?ot=%link_ot%

		$cuerpoAT = "<p>Se ha actualizado un pedido de piezas $at : $link </p>";

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
		$mail->AddEmbeddedImage(CONF_ABS_ROOT_PATH . 'mail_template/images/logo-bmw.png', 'logo_perfecta');
		$mail->CharSet = 'UTF-8';
		$mail->Subject = "Actualización de Pedido de pieza $_id_solicitud_pieza_c";

   //$notificar
	 	$mail->AddCC($notificar);
		$mail->AddCC('oscar.marecos@perfecta.com.py', 'Oscar Marecos');
		$mail->MsgHTML($cuerpoAT);
    $mail->Send();
      //	echo json_encode(array("success" => true, 'mensaje' => 'Solicitud editada correctamente'));
    //}

	}
  echo json_encode(array('success'=>true, 'mensaje' => 'Solicitud de pieza editada correctamente 2'));

//header("Location: {$_SERVER['HTTP_REFERER']}");
} catch (Exception $e) {
	    echo json_encode(array('success'=>false));
}
