<?php include_once("../inc/config.inc.php");

header('Content-type: application/json');

$busqueda = str_replace(' ', '', strtolower(TextHelper::cleanString($_POST['busqueda'])));

$db = new DBManager();
$qvehiculo = new DBQuery("SELECT id_vehiculo, chapa, chasis, modelo, anio
            FROM vehiculo
            WHERE LOWER(REPLACE(chasis,' ','')) LIKE '%$busqueda%'
            OR LOWER(REPLACE(chapa,' ','')) LIKE '%$busqueda%'
            ");

$vehiculo = $db->executeQuery($qvehiculo);

echo json_encode($vehiculo);

?>
