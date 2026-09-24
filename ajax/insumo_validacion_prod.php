<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

// VALIDACION PRODUCTO
$tipo_producto = TextHelper::cleanString($_POST['p_tipo_producto']);
$db = new DBManager();
$qproducto = new DBQuery("SELECT id_producto, descripcion_producto FROM conquestool.producto WHERE tipo_producto = '$tipo_producto'");
$producto = $db->executeQuery($qproducto);
echo json_encode($producto);

?>
