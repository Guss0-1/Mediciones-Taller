<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

// VALIDACION UNIDAD DE MEDIDA
$id_tipo_producto = TextHelper::cleanString($_POST['m_tipo_producto']);
$db = new DBManager();
$qunidad_me = new DBQuery("SELECT * FROM conquestool.unidad_medida WHERE prod = '$id_tipo_producto'");
$m_unidad_medida = $db->executeQuery($qunidad_me);
echo json_encode($m_unidad_medida);

?>
