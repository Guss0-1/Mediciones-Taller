<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

// VALIDACION UNIDAD DE MEDIDA POR PRODUCTO
$id_producto =($_POST['id_producto']);
$db = new DBManager();
$qproducto = new DBQuery("SELECT * FROM conquestool.producto p
                                   JOIN conquestool.unidad_medida um ON p.id_unidad_medida=um.id_unidad_medida
                                   JOIN conquestool.stock_insumo s ON p.id_producto=s.id_producto
                                   JOIN conquestool.proveedor pv ON pv.id_proveedor=p.id_proveedor
                                   WHERE s.cantidad_prod=0 and p.id_producto = '$id_producto'");
$m_producto = $db->executeQuery($qproducto);
echo json_encode($m_producto);

?>
