<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');
// VALIDACION UNIDAD DE MEDIDA

if ($_POST['minimo'] > $_POST['maximo']) {
  $respuesta= 'si';
}else {
  $respuesta= 'no';
}
echo json_encode($respuesta);
?>
