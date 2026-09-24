<?php include_once("../inc/config.inc.php");  

header('Content-type: application/json');

$_nro_documento = TextHelper::cleanNumber($_POST['nro_documento']);

$db = new DBManager();

$qconquistas = new DBQuery("SELECT count(*) cantidad FROM conquistas WHERE  nro_documento = '$_nro_documento'");
$conquistas = $db->executeQuery($qconquistas);

$_existe = false;

if($conquistas[0]['cantidad'] > 0)
{
	$_existe = true;
}

echo json_encode(array('existe'=>$_existe));

?>