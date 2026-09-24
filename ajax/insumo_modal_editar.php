<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

 $db = new DBManager();

// ACTUALIZAR PRODUCTO
$id_producto = TextHelper::cleanString($_POST['m_id_producto']);
$codigo = TextHelper::cleanString($_POST['m_codigo']);
$descripcion_producto= TextHelper::cleanString($_POST['m_descripcion_producto']);
$id_unidad_medida = TextHelper::cleanString($_POST['m_unidad_medida']);
$tipo_producto= TextHelper::cleanString($_POST['m_tipo_producto']);
$cantidad_min = TextHelper::cleanNumber($_POST['m_cantidad_min']);
$cantidad_max = TextHelper::cleanNumber($_POST['m_cantidad_max']);
$id_proveedor = TextHelper::cleanString($_POST['m_id_proveedor']);

$qupdate_producto = new DBQuery("UPDATE conquestool.producto
                                    SET codigo = '$codigo',
                                    descripcion_producto = '$descripcion_producto',
                                    id_unidad_medida = '$id_unidad_medida',
                                    id_proveedor = '$id_proveedor',
                                    tipo_producto = '$tipo_producto'
                                    WHERE id_producto = '$id_producto';");
$db->executeNonQuery($qupdate_producto);

// ACTUALIZAR STOCK
 if ($cantidad_max > $cantidad_min) {
    $qupdate_stock_insumo = new DBQuery("UPDATE conquestool.stock_insumo
                                        SET cantidad_min = '$cantidad_min',
                                        cantidad_max = '$cantidad_max'
                                        WHERE id_producto = '$id_producto';");
    $db->executeNonQuery($qupdate_stock_insumo);
  }


header("Location: {$_SERVER['HTTP_REFERER']}");
?>
