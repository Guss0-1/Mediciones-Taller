<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

$tipo_movimiento = TextHelper::cleanString($_POST['tipo_movimiento']);
$factura= TextHelper::cleanString($_POST['factura']);
$id_usuario= TextHelper::cleanNumber($_SESSION['s_id_usuario']);
$jefe_grupo = TextHelper::cleanString($_POST['jefe_grupo']);
$tecnico = TextHelper::cleanString($_POST['tecnico']);
$nro_orden = TextHelper::cleanNumber($_POST['nro_orden']);
$motivo_movim= TextHelper::cleanString($_POST['motivo']);
$tipo_producto = TextHelper::cleanString($_POST['tipo_producto']);


// TM RECEPCION
 if($tipo_movimiento == recepcion){

   // INSERTAR CABECERA MOVIMIENTO
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
         '$tecnico'  ) ;");
   $result = $db->executeNonQuery($qinsertar_movimiento);

   $qid_movimiento= new DBQuery("SELECT max(id_movimiento)as movim FROM conquestool.movimiento");
   $id_movimientost = $db->executeQuery($qid_movimiento);
   $id_movimiento= TextHelper::cleanNumber ($id_movimientost[0]['movim']);
   $cantidad_detalles= TextHelper::cleanNumber($_POST['cantidad_detalles']);
   $e_cantidad_detalles= TextHelper::cleanNumber($_POST['e_cantidad_detalles']);
   // echo "fecha_movim cabecera:$fecha_movim";

  //INSERTAR DETALLE MOVIMIENTO LINEA 1
  $id_producto = TextHelper::cleanString($_POST['producto']);
  $fcantidad = TextHelper::cleanNumber($_POST['cantidad']);
  $unidad = TextHelper::cleanNumber($_POST['unidad']);
  $qid_unidad= new DBQuery("SELECT id_unidad_medida FROM conquestool.producto WHERE id_producto='$id_producto'");
  $qid_unidad_medida = $db->executeQuery($qid_unidad);
  $id_unidad_medida= TextHelper::cleanNumber ($qid_unidad_medida[0]['id_unidad_medida']);
  $fprecio_unitario = TextHelper::cleanString($_POST['precio_unitario']);
  $moneda = TextHelper::cleanString($_POST['moneda']);
  $descuento = TextHelper::cleanNumber($_POST['descuento']);
  $totalprecio_unitario = ($fprecio_unitario * $descuento)/100;
    if (!empty($unidad)) {
        $cantidad = $fcantidad * $unidad;
    } else {
        $cantidad = $fcantidad;
    }

    if ($descuento <> 1) {
         $precio_unitario = $fprecio_unitario - $totalprecio_unitario;
    } else {
            $precio_unitario = $fprecio_unitario;

    }
    // echo "fprecio_unitario cabecera:$fprecio_unitario";
    // echo "totalprecio_unitario cabecera:$totalprecio_unitario";
    // echo "precio_unitario cabecera:$precio_unitario";
  $qinsertar_detalle_movimiento = new DBQuery("INSERT INTO conquestool.detalle_movimiento (
      id_movimiento,id_producto,id_unidad_medida,moneda,precio_unitario,cantidad,descuento
      )
      VALUES
      (
        '$id_movimiento',
        '$id_producto',
        '$id_unidad_medida',
        '$moneda',
        '$precio_unitario',
        '$cantidad',
        '$descuento'
      ) ;");
  $result = $db->executeNonQuery($qinsertar_detalle_movimiento);

  $qid_proveedor= new DBQuery("SELECT id_proveedor FROM conquestool.producto WHERE id_producto='$id_producto'");
  $id_proveedorst = $db->executeQuery($qid_proveedor);
  $id_proveedor= TextHelper::cleanNumber ($id_proveedorst[0]['id_proveedor']);

  // INSERTAR LISTA PRECIO
  $qinsertar_lista_precio = new DBQuery("INSERT INTO conquestool.lista_precio (
        id_proveedor,id_producto,precio_unitario,moneda, id_unidad_medida
        )
        VALUES
        (
          '$id_proveedor',
          '$id_producto',
          '$precio_unitario',
          '$moneda',
          '$id_unidad_medida'
        ) ;");
    $result = $db->executeNonQuery($qinsertar_lista_precio);

  //ACTUALIZAR STOCK LINEA 1
  $cantidad_min = null;
  $cantidad_max = null;
  $qinsertar_stock_insumo = new DBQuery("INSERT INTO conquestool.stock_insumo (
      id_movimiento,id_producto,cantidad_prod,cantidad_min,cantidad_max
      )
      VALUES
      (
        '$id_movimiento',
        '$id_producto',
        '$cantidad',
        '$cantidad_min',
        '$cantidad_max'
      ) ;");
  $result = $db->executeNonQuery($qinsertar_stock_insumo);
  // echo "id_movimiento linea1:$id_movimiento";
  // echo "id_producto linea1:$id_producto";

  for ( $i = 0; $i < $cantidad_detalles; $i++) {

    //INSERTAR DETALLE MOVIMIENTO DESDE LINEA 2
    $id_producto = TextHelper::cleanString($_POST['producto'.$i]);
    $fcantidad = TextHelper::cleanNumber($_POST['cantidad'.$i]);
    $unidad = TextHelper::cleanNumber($_POST['unidad'.$i]);
    $qid_unidad= new DBQuery("SELECT id_unidad_medida FROM conquestool.producto WHERE id_producto='$id_producto'");
    $qid_unidad_medida = $db->executeQuery($qid_unidad);
    $id_unidad_medida= TextHelper::cleanNumber ($qid_unidad_medida[0]['id_unidad_medida']);
    $fprecio_unitario = TextHelper::cleanString($_POST['precio_unitario'.$i]);
    $moneda = TextHelper::cleanString($_POST['moneda'.$i]);
    $descuento = TextHelper::cleanNumber($_POST['descuento'.$i]);
    $totalprecio_unitario = ($fprecio_unitario * $descuento)/100;
      if (!empty($unidad)) {
          $cantidad = $fcantidad * $unidad;
      } else {
          $cantidad = $fcantidad;
      }

      if ($descuento <> 1) {
           $precio_unitario = $fprecio_unitario - $totalprecio_unitario;
      } else {
              $precio_unitario = $fprecio_unitario;

      }
      // echo "fprecio_unitario linea:$fprecio_unitario";
      // echo "totalprecio_unitario linea:$totalprecio_unitario";
      // echo "precio_unitario linea:$precio_unitario";
    $qinsertar_detalle_movimiento = new DBQuery("INSERT INTO conquestool.detalle_movimiento (
          id_movimiento,id_producto,id_unidad_medida,moneda,precio_unitario,cantidad,descuento
          )
          VALUES
          (
            '$id_movimiento',
            '$id_producto',
            '$id_unidad_medida',
            '$moneda',
            '$precio_unitario',
            '$cantidad',
            '$descuento'
          ) ;");
      $result = $db->executeNonQuery($qinsertar_detalle_movimiento);

      $qid_proveedor= new DBQuery("SELECT id_proveedor FROM conquestool.producto WHERE id_producto='$id_producto'");
      $id_proveedorst = $db->executeQuery($qid_proveedor);
      $id_proveedor= TextHelper::cleanNumber ($id_proveedorst[0]['id_proveedor']);

      // INSERTAR LISTA PRECIO
      $qinsertar_lista_precio = new DBQuery("INSERT INTO conquestool.lista_precio (
            id_proveedor,id_producto,precio_unitario,moneda,id_unidad_medida
            )
            VALUES
            (
              '$id_proveedor',
              '$id_producto',
              '$fprecio_unitario',
              '$moneda',
              '$id_unidad_medida'
            ) ;");
        $result = $db->executeNonQuery($qinsertar_lista_precio);

    //ACTUALIZAR STOCK DESDE LINEA 2
      $cantidad_min = null;
      $cantidad_max = null;
      $qinsertar_stock_insumo = new DBQuery("INSERT INTO conquestool.stock_insumo (
          id_movimiento,id_producto,cantidad_prod,cantidad_min,cantidad_max
          )
          VALUES
          (
            '$id_movimiento',
            '$id_producto',
            '$cantidad',
            '$cantidad_min',
            '$cantidad_max'
          ) ;");
      $result = $db->executeNonQuery($qinsertar_stock_insumo);
    }
  }


//TM ENTREGA, BAJA, ANULACION
if($tipo_movimiento == entrega || $tipo_movimiento == baja || $tipo_movimiento == anulacion){

  $id_producto = TextHelper::cleanString($_POST['e_producto']);
  $qcant= new DBQuery("SELECT DISTINCT si.id_producto, SUM( si.cantidad_prod * CASE when m.tipo_movimiento in ('insercion','recepcion') then 1 else  -1 end) as cantidad_prod
                      FROM conquestool.stock_insumo si
                      LEFT JOIN conquestool.movimiento m ON si.id_movimiento=m.id_movimiento
                      WHERE si.id_producto='$id_producto'");
  $cant = $db->executeQuery($qcant);
  $cantidadprod= TextHelper::cleanNumber ($cant[0]['cantidad_prod']);
  $cantidad = TextHelper::cleanNumber($_POST['e_cantidad']);
  // echo "id_producto:$id_producto";
  // echo "cantidadprod:$cantidadprod";
  // echo "cantidad:$cantidad";

  // INSERTAR CABECERA MOVIMIENTO
if ($cantidadprod >= $cantidad) {
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
        '$tecnico'  ) ;");
  $result = $db->executeNonQuery($qinsertar_movimiento);

  $qid_movimiento= new DBQuery("SELECT max(id_movimiento)as movim FROM conquestool.movimiento");
  $id_movimientost = $db->executeQuery($qid_movimiento);
  $id_movimiento= TextHelper::cleanNumber ($id_movimientost[0]['movim']);
  $cantidad_detalles= TextHelper::cleanNumber($_POST['cantidad_detalles']);
  $e_cantidad_detalles= TextHelper::cleanNumber($_POST['e_cantidad_detalles']);
  // echo "fecha_movim cabecera:$fecha_movim";

 //INSERTAR DETALLE MOVIMIENTO LINEA 1.
  $qid_unidad= new DBQuery("SELECT id_unidad_medida FROM conquestool.producto WHERE id_producto='$id_producto'");
  $qid_unidad_medida = $db->executeQuery($qid_unidad);
  $id_unidad_medida= TextHelper::cleanNumber ($qid_unidad_medida[0]['id_unidad_medida']);
  $cantidad = TextHelper::cleanNumber($_POST['e_cantidad']);
  $moneda = null;
  $precio_unitario = null;
  $descuento = null;

  $qinsertar_detalle_movimiento = new DBQuery("INSERT INTO conquestool.detalle_movimiento (
      id_movimiento,id_producto,id_unidad_medida,moneda,precio_unitario,cantidad,descuento
      )
      VALUES
      (
        '$id_movimiento',
        '$id_producto',
        '$id_unidad_medida',
        '$moneda',
        '$precio_unitario',
        '$cantidad',
        '$descuento'
      ) ;");
  $result = $db->executeNonQuery($qinsertar_detalle_movimiento);

  //ACTUALIZAR STOCK LINEA 1
  $cantidad_min = null;
  $cantidad_max = null;

  $qinsertar_stock_insumo = new DBQuery("INSERT INTO conquestool.stock_insumo (
      id_movimiento,id_producto,cantidad_prod,cantidad_min,cantidad_max
      )
      VALUES
      (
        '$id_movimiento',
        '$id_producto',
        '$cantidad',
        '$cantidad_min',
        '$cantidad_max'
      ) ;");
  $result = $db->executeNonQuery($qinsertar_stock_insumo);
  // echo "id_movim detalle linea 1:$id_movimiento";
}

  for ( $i = 0; $i < $e_cantidad_detalles; $i++) {

     //INSERTAR DETALLE MOVIMIENTO DESDE LINEA 2
      $id_producto = TextHelper::cleanString($_POST['e_producto'.$i]);
      $qcant= new DBQuery("SELECT DISTINCT si.id_producto, SUM( si.cantidad_prod * CASE when m.tipo_movimiento in ('insercion','recepcion') then 1 else  -1 end) as cantidad_prod
                          FROM conquestool.stock_insumo si
                          LEFT JOIN conquestool.movimiento m ON si.id_movimiento=m.id_movimiento
                          WHERE si.id_producto='$id_producto'");
      $cant = $db->executeQuery($qcant);
      $cantidadprod= TextHelper::cleanNumber ($cant[0]['cantidad_prod']);
      $cantidad = TextHelper::cleanNumber($_POST['e_cantidad'.$i]);
      $qid_unidad= new DBQuery("SELECT id_unidad_medida FROM conquestool.producto WHERE id_producto='$id_producto'");
      $qid_unidad_medida = $db->executeQuery($qid_unidad);
      $id_unidad_medida= TextHelper::cleanNumber ($qid_unidad_medida[0]['id_unidad_medida']);
      $moneda = null;
      $precio_unitario = null;
      $descuento = null;

     if ($cantidadprod >= $cantidad) {
      $qinsertar_detalle_movimiento = new DBQuery("INSERT INTO conquestool.detalle_movimiento (
          id_movimiento,id_producto,id_unidad_medida,moneda,precio_unitario,cantidad,descuento
          )
          VALUES
          (
            '$id_movimiento',
            '$id_producto',
            '$id_unidad_medida',
            '$moneda',
            '$precio_unitario',
            '$cantidad',
            '$descuento'
          ) ;");
      $result = $db->executeNonQuery($qinsertar_detalle_movimiento);

     //ACTUALIZAR STOCK DESDE LINEA 2
      $cantidad_min = null;
      $cantidad_max = null;
      $qinsertar_stock_insumo = new DBQuery("INSERT INTO conquestool.stock_insumo (
          id_movimiento,id_producto,cantidad_prod,cantidad_min,cantidad_max
          )
          VALUES
          (
            '$id_movimiento',
            '$id_producto',
            '$cantidad',
            '$cantidad_min',
            '$cantidad_max'
          ) ;");
      $result = $db->executeNonQuery($qinsertar_stock_insumo);
    }
   }
  }

 header("Location: {$_SERVER['HTTP_REFERER']}");
?>
