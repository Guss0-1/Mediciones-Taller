<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

$id_solicitud_pieza_cab = TextHelper::cleanString($_POST['id_solicitud_agregar']);
$cantidad_detalles= TextHelper::cleanNumber($_POST['cantidad_detalles']);
$usuario_logueado = new usuarios();
$usuario_logueado->carga($_SESSION['s_id_usuario']);
$id_usuario = $_SESSION['s_id_usuario'];

//insertar $detalles
$id_estado = 1;
//inserta la primera linea
$nro_pieza= TextHelper::cleanString($_POST['nro_pieza']);
$descripcion = TextHelper::cleanString($_POST['descripcion']);
$cantidad = TextHelper::cleanNumber($_POST['cantidad']);
$id_tipo_transporte = TextHelper::cleanNumber($_POST['id_tipo_transporte']);

$qinsertar_detalle = new DBQuery("INSERT INTO conquestool.solicitud_pieza_det (
    id_solicitud_pieza_cab,numero_pieza,descripcion,cantidad,id_estado,id_usuario_creacion, id_tipo_transporte
    )
    VALUES
    (
      '$id_solicitud_pieza_cab',
      '$nro_pieza',
      '$descripcion',
       $cantidad,
       $id_estado,
       $id_usuario,
       $id_tipo_transporte
    ) ;");
$result = $db->executeNonQuery($qinsertar_detalle);
//inserta el resto de las lineas
for ($i = 0; $i < $cantidad_detalles; $i++) {

  $nro_pieza= TextHelper::cleanString($_POST['nro_pieza'.$i]);
  $descripcion = TextHelper::cleanString($_POST['descripcion'.$i]);
  $cantidad = TextHelper::cleanNumber($_POST['cantidad'.$i]);

  $qinsertar_detalle = new DBQuery("INSERT INTO conquestool.solicitud_pieza_det (
      id_solicitud_pieza_cab,numero_pieza,descripcion,cantidad,id_estado,id_usuario_creacion, id_tipo_transporte
      )
      VALUES
      (
        '$id_solicitud_pieza_cab',
        '$nro_pieza',
        '$descripcion',
        $cantidad,
        $id_estado,
        $id_usuario,
        $id_tipo_transporte
      ) ;");
  $result = $db->executeNonQuery($qinsertar_detalle);

}
    header("Location: {$_SERVER['HTTP_REFERER']}");
	//echo json_encode(array('success'=>true, 'mensaje' => 'La solicitud fue creada exitosamente'));

?>
