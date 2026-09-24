<?php include_once("../inc/config.inc.php");  

header('Content-type: application/json');

$db = new DBManager();

$_id_estados = TextHelper::cleanString($_POST['id_estados']);

$qseguimiento = new DBQuery("SELECT ot,vehiculo_modelo,chasis,chapa,cliente,nro_asesor, eo.estado, id_estado_actual, t.tecnico, tot.fecha_comprometida, color,DATEDIFF(NOW(), fecha_ingreso) diasEstadiaTaller,DATEDIFF(NOW(), tot.fecha_creacion) diasEstadoActual
    FROM seguimiento_ordenes so
    LEFT OUTER JOIN estados_ordenes eo ON eo.id = so.`id_estado_actual`
    LEFT OUTER JOIN tiempos_ordenes tot ON so.id = tot.id_seguimiento AND tot.id_estado = so.`id_estado_actual`
    LEFT OUTER JOIN tecnicos t ON t.id = tot.tecnico
    WHERE so.`id_estado_actual` in ($_id_estados) and ot NOT LIKE '%OTH%'
    ORDER BY eo.estado desc,t.tecnico
    "); 
$seguimiento = $db->executeQuery($qseguimiento);

foreach($seguimiento as $row)
{

	$_respuesta[] = array(
		"total"				 => count($seguimiento),
		"modelo" 			 => substr($row['vehiculo_modelo'], 0,17),
		"color" 			 => $row['color'],
		"estado" 			 => substr(strtoupper($row['estado']), 0,30),
		"chapa" 			 => ((!empty($row['chapa'])) ? $row['chapa']  : '-'),
		"chasis" 			 => substr($row['chasis'], -7),
		"cliente" 			 => substr($row['cliente'], 0,25),
		"nro_ot" 			 => $row['ot'],
		"asesor" 			 => substr(strtoupper($row['nro_asesor']), 0,25),
		"tecnico" 			 => ((!empty($row['tecnico']) && $row['estado'] <> 'Nuevo') ?  substr($row['tecnico'], 0,25) : '-'),
		"diaseneltaller"	 => $row['diasEstadiaTaller'],
		"diasestadoactual"	 => $row['diasEstadoActual'],
		"fecha_comprometida" =>((!empty($row['fecha_comprometida'])) ?  date('d/m/Y H:i', strtotime($row['fecha_comprometida'])) : '-')
	);

}

echo json_encode($_respuesta);

?>