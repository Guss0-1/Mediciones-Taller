<?php include_once("../inc/config.inc.php");

header('Content-type: application/json');

$_id_jefe = TextHelper::cleanNumber($_POST['jefe_grupo']);

$sql_filtro_jefe_grupo = "";

if($_id_jefe == 10 || $_id_jefe ==8){
  //si el jefe es de chaperia, sumarle los preparadores
  $sql_filtro_jefe_grupo = " or nro_tecnico in ('26') ";
}

$db = new DBManager();
$qtecnicos = new DBQuery("SELECT id, tecnico FROM tecnicos WHERE estado = 'activo' and id_jefe = '$_id_jefe' $sql_filtro_jefe_grupo ORDER BY tecnico ASC");
$tecnicos = $db->executeQuery($qtecnicos);

echo json_encode($tecnicos);

?>
