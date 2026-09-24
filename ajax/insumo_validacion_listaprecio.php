<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

// LECTURA LISTA PRECIO
$tipo_producto = TextHelper::cleanString($_POST['p_tipo_producto']);
$db = new DBManager();
$qpresupuesto = new DBQuery("SELECT DISTINCT  MAX(DATE_FORMAT(lp.fecha_sistema, '%d/%m/%Y'))as fecha_lista,
                                               concat(upper(left(p.tipo_producto,1)),lower(substring(p.tipo_producto,2))) as tipo_producto,
                                               p.codigo, concat(upper(left(p.descripcion_producto,1)),lower(substring(p.descripcion_producto,2))) as descripcion_producto,
                                               concat(upper(left(pv.descripcion_proveedor,1)),lower(substring(pv.descripcion_proveedor,2))) as descripcion_proveedor,
                                               concat(upper(left(lp.precio_unitario, 1)),lower(substring(lp.precio_unitario,2))) as precio
                          FROM conquestool.lista_precio lp
                          LEFT JOIN conquestool.producto p ON lp.id_producto=p.id_producto
                          LEFT JOIN conquestool.proveedor pv ON lp.id_proveedor=pv.id_proveedor
                          WHERE p.tipo_producto='$tipo_producto'
                          GROUP by descripcion_producto");
$presupuesto = $db->executeQuery($qpresupuesto);
echo json_encode($presupuesto);
?>
