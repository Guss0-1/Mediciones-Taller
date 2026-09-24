<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

 $db = new DBManager();

$formulario = TextHelper::cleanString($_POST['form_prod']);

// INSERTAR PRODUCTO
if ($formulario== 1) {

$codigo = TextHelper::cleanString($_POST['codigo']);
$descripcion_producto= TextHelper::cleanString($_POST['m_descripcion_producto']);
$id_proveedor = TextHelper::cleanNumber($_POST['m_id_proveedor']);
$id_unidad_medida = TextHelper::cleanNumber($_POST['m_unidad_medida']);
$tipo_producto= TextHelper::cleanString($_POST['m_tipo_producto']);
$cantidad_prod= 0;
$cantidad_min = TextHelper::cleanNumber($_POST['cantidad_min']);
$cantidad_max = TextHelper::cleanNumber($_POST['cantidad_max']);

if ($cantidad_max > $cantidad_min) {

  $qinsertar_producto = new DBQuery("INSERT INTO conquestool.producto (
      codigo,descripcion_producto,id_proveedor,id_unidad_medida,tipo_producto
      )
      VALUES
      (
        '$codigo',
        '$descripcion_producto',
        '$id_proveedor',
        '$id_unidad_medida',
        '$tipo_producto'
      ) ;");
  $result_producto = $db->executeNonQuery($qinsertar_producto);

  $qid_producto= new DBQuery("SELECT max(id_producto)as producto FROM producto");
  $id_productost = $db->executeQuery($qid_producto);
  $productost= $id_productost[0]['producto'];
  $tipo_movimiento= insercion;
  $factura=null;
  $id_usuario= TextHelper::cleanNumber($_SESSION['s_id_usuario']);
  $jefe_grupo=null;
  $nro_orden=null;
  $motivo_movim=null;
  $tecnico=null;

  $qinsertar_movimiento = new DBQuery("INSERT INTO conquestool.movimiento (
      tipo_movimiento,factura,id_usuario,jefe_grupo,nro_orden,motivo_movim,tecnico
      )
      VALUES
      (
        '$tipo_movimiento',
        '$factura',
        '$id_usuario',
        '$jefe_grupo',
        '$nro_orden',
        '$motivo_movim',
        '$tecnico'
      ) ;");
  $result_movim = $db->executeNonQuery($qinsertar_movimiento);

  $qid_movimiento= new DBQuery("SELECT max(id_movimiento)as movim FROM movimiento");
  $id_movimientost = $db->executeQuery($qid_movimiento);
  $movimientost= TextHelper::cleanNumber ($id_movimientost[0]['movim']);
  $moneda= null;
  $precio_unitario= null;
  $cantidad= null;
  $descuento= null;

  $qinsertar_detalle_movimiento = new DBQuery("INSERT INTO conquestool.detalle_movimiento (
      id_movimiento,id_producto,id_unidad_medida,moneda,precio_unitario,cantidad,descuento
      )
      VALUES
      (
        '$movimientost',
        '$productost',
        '$id_unidad_medida',
        '$moneda',
        '$precio_unitario',
        '$cantidad',
        '$descuento'
      ) ;");
  $result_detalle_movim = $db->executeNonQuery($qinsertar_detalle_movimiento);


      $qinsertar_stock_insumo = new DBQuery("INSERT INTO conquestool.stock_insumo (
          id_movimiento,id_producto,cantidad_prod,cantidad_min,cantidad_max
          )
          VALUES
          (
            '$movimientost',
            '$productost',
            '$cantidad_prod',
            '$cantidad_min',
            '$cantidad_max'
          ) ;");
      $result_stock = $db->executeNonQuery($qinsertar_stock_insumo);
      // echo "string:$result_producto" ;
      // echo "string:$result_movim" ;
      // echo "string:$result_detalle_movim" ;
      // echo "string:$result_stock" ;
 }
}

$formulario = TextHelper::cleanString($_POST['form_prov']);

// INSERTAR PROVEEDOR
if ($formulario== 2) {

$descripcion_proveedor = TextHelper::cleanString($_POST['descripcion_proveedor']);
$direccion= TextHelper::cleanString($_POST['direccion']);
$telefono = TextHelper::cleanString($_POST['telefono']);
$email = TextHelper::cleanString($_POST['email']);

$qinsertar_proveedor = new DBQuery("INSERT INTO conquestool.proveedor (
    descripcion_proveedor,direccion,telefono,email
    )
    VALUES
    (
      '$descripcion_proveedor',
      '$direccion',
      '$telefono',
      '$email'
    ) ;");
$result_proveedor = $db->executeNonQuery($qinsertar_proveedor);
// echo "$formulario";
// echo "$result_proveedor";
}
header("Location: {$_SERVER['HTTP_REFERER']}");
?>
