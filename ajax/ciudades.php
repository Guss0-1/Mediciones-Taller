<?php include_once("../inc/config.inc.php");  

header('Content-type: application/json');

$_id_pais = TextHelper::cleanNumber($_POST['id_pais']);

$db = new DBManager();

$qciudades = new DBQuery("SELECT id,ciudad FROM ciudades WHERE id_pais = '$_id_pais' ORDER BY ciudad ASC");
$ciudades = $db->executeQuery($qciudades);

echo json_encode($ciudades);

?>