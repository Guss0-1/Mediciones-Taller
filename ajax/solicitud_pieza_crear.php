<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

$nro_oferta = TextHelper::cleanString($_POST['nro_oferta']);
$cliente = TextHelper::cleanString($_POST['cliente']);
$chasis = TextHelper::cleanString($_POST['chasis']);
$modelo_vehiculo = TextHelper::cleanString($_POST['modelo_vehiculo']);
$motivo = TextHelper::cleanString($_POST['motivo']);
$cantidad_detalles= TextHelper::cleanNumber($_POST['cantidad_detalles']);
$id_usuario = $_SESSION['s_id_usuario'];

//insertar cabeccera
//generar un id unico para crear la solicitud
$date=date_create();
$tiempo = date_timestamp_get($date);
$aleatorio = rand(10,15000);
$id_solicitud_pieza_cab = 'SP-'.$tiempo.'-'.$aleatorio;

$qinsertar_cabecera = new DBQuery("INSERT INTO conquestool.solicitud_pieza_cab (
  id_solicitud,cliente,chasis,modelo,id_usuario,motivo,nro_oferta
  )
  VALUES
  ( '$id_solicitud_pieza_cab','$cliente','$chasis','$modelo_vehiculo','$id_usuario','$motivo','$nro_oferta') ;");

$result = $db->executeNonQuery($qinsertar_cabecera);

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
  $id_tipo_transporte = TextHelper::cleanNumber($_POST['id_tipo_transporte'.$i]);

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

echo json_encode(array('success'=>true, 'cabecera' => $id_solicitud_pieza_cab));

?>
