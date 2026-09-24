<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

// VALIDACION UNIDAD MEDIDA
$producto = TextHelper::cleanString($_POST['producto']);
$db = new DBManager();

$qunidad_medida = new DBQuery("SELECT  p.id_unidad_medida, um.descripcion_unidad FROM conquestool.producto p JOIN conquestool.unidad_medida um ON p.id_unidad_medida=um.id_unidad_medida WHERE p.id_producto = '$producto'");
$unidad_medida = $db->executeQuery($qunidad_medida);
echo json_encode($unidad_medida);

?>
