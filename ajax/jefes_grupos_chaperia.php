<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

//VALIDACION JEFE GRUPO
$_id_jefe = TextHelper::cleanString($_POST['jefe_grupo']);
$db = new DBManager();
$qtecnicos = new DBQuery("SELECT id, tecnico FROM conquestool.tecnicos WHERE id_jefe = '$_id_jefe'  ORDER BY tecnico ASC");
$tecnico = $db->executeQuery($qtecnicos);
echo json_encode($tecnico);
echo "tecnico:$qtecnicos";

?>
