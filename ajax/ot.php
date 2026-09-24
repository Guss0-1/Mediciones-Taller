<?php 
include_once '../inc/config.inc.php'; 
header('Content-type: application/json');

$db = new DBManager();

$_parametros = str_replace(' ', '', strtolower(TextHelper::cleanString($_POST['chasis'])));

$qseguimiento = new DBQuery("SELECT * 
							 FROM seguimiento_ordenes 
							 WHERE LOWER(REPLACE(chasis,' ','')) LIKE '%$_parametros%'
							 OR LOWER(REPLACE(chapa,' ','')) LIKE '%$_parametros%'
							 OR LOWER(REPLACE(ot,' ','')) LIKE '%$_parametros%'
							 ");
			
$seguimiento = $db->executeQuery($qseguimiento);

if(!empty($seguimiento))
	echo json_encode(array('success'=>true));
else
	echo json_encode(array('success'=>false));