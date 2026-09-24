<?php include_once("../inc/config.inc.php");

header('Content-type: application/json');

$busqueda = str_replace(' ', '', strtolower(TextHelper::cleanString($_POST['nro_oferta'])));
//echo "busca este numero de oferta: ".$busqueda;
//exit;

$db = new DBManager();

$qsolicitud_pieza = new DBQuery("SELECT
                id_solicitud,
                fecha_solicitud,
                cliente,
                chasis,
                modelo,
                u.usuario,
                tp.tipo,
                motivo,
                archivo,
                nro_oferta
              FROM
                conquestool.solicitud_pieza_cab cab
                JOIN usuarios u ON cab.id_usuario = u.id_usuario
                JOIN tipo_transporte tp ON tp.id_tipo_transporte = cab.id_tipo_transporte
                WHERE lower(nro_oferta) = lower('$busqueda') ");
$solicitud_pieza = $db->executeQuery($qsolicitud_pieza);
$solicitud_pieza = $solicitud_pieza[0];
$id_solicitud =  $solicitud_pieza['id_solicitud'];
if($solicitud_pieza){
  	echo json_encode(array('idsolicitud'=>$id_solicitud, 'mensaje' => '1'));
}else{

  //buscar oferta con esos datos
  $pdo = new PDO("dblib:host=mssql;dbname=Perfecta Automotores", "sa", "perfecta01");//producción
  //$pdo = new PDO("sqlsrv:Server=192.168.10.2;Database=Perfecta Automotores", "sa", "perfecta01"); //desarrollo

  $qoferta_incadea = "select oferta, cliente, chasis, modelo
                      from VW_Ofertas_Servicio
                      where lower(oferta) = lower('$busqueda')";
  $oferta_incadea = $pdo->query($qoferta_incadea)->fetchAll();

  $oferta = $oferta_incadea[0];
  $cliente = utf8_encode($oferta['cliente']);
  $chasis = $oferta['chasis'];
  $modelo = $oferta['modelo'];

  //echo "oferta incadea $cliente - $chasis - $modelo";
  //exit;

  echo json_encode(array('mensaje' => '2','cliente'=>$cliente, 'chasis' => $chasis, 'modelo' => $modelo));

}


?>
