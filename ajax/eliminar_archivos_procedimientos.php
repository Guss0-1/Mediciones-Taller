<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();
$id = TextHelper::cleanNumber($_POST['id']);

//eliminar el archivo
$qeliminar = new DBQuery("DELETE FROM `conquestool`.`archivo_procedimiento` WHERE `id` = '$id' ;");
$db->executeQuery($qeliminar);
echo json_encode(array('success'=>true, 'mensaje' => 'Archivo eliminado correctamente.'));
