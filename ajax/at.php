<?php
include_once '../inc/config.inc.php';
header('Content-type: application/json');

$db = new DBManager();

$_parametros = $_POST['chasis'];

//str_replace(' ', '', strtolower(TextHelper::cleanString($_POST['chasis'])));

$qasistenciatecnica = new DBQuery("SELECT *
							 FROM asistencia_tecnica
							 WHERE LOWER(REPLACE(chasis,' ','')) LIKE '%$_parametros%'
							 OR LOWER(REPLACE(chapa,' ','')) LIKE '%$_parametros%'
							 OR LOWER(REPLACE(at,' ','')) LIKE '%$_parametros%'
							 order by id desc");

$asistencia_tecnica = $db->executeQuery($qasistenciatecnica);

if(!empty($asistencia_tecnica))
	echo json_encode(array('success'=>true));
else
	echo json_encode(array('success'=>false));
