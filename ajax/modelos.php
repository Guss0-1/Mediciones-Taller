<?php include_once("../inc/config.inc.php");  

header('Content-type: application/json');

$_id_marca = TextHelper::cleanNumber($_POST['id_marca']);

$db = new DBManager();

$qmodelos = new DBQuery("SELECT id,modelo FROM modelos WHERE activo = 'SI' and id_marca_automovil = '$_id_marca' ORDER BY modelo ASC");
$modelos = $db->executeQuery($qmodelos);

echo json_encode($modelos);

?>