<?php
include_once '../inc/config.inc.php';
header('Content-type: application/json');

//$pdo = new PDO("sqlsrv:Server=192.168.10.2;Database=Perfecta Automotores", "sa", "perfecta01");
$pdo = new PDO("dblib:host=mssql;dbname=Perfecta Automotores", "sa", "perfecta01");


$_parametros = str_replace(' ', '', strtolower(TextHelper::cleanString($_POST['nro_tecnico'])));

$qtecnicos = "SELECT * FROM [dbo].[Productividad_tecnico] where nro_tecnico =".$_parametros;

$tecnicos = $pdo->query($qtecnicos)->fetchAll();

if(!empty($tecnicos))
	echo json_encode(array('success'=>true));
else
	echo json_encode(array('success'=>false));
