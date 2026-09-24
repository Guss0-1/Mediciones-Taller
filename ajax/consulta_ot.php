<?php
include_once '../inc/config.inc.php';

header('Content-type: application/json');

$db = new DBManager();

//SEGUIMIENTO ORDENES
$_parametros = TextHelper::cleanString(str_replace(' ', '', strtolower($_POST['chasis'])));
$qseguimiento = new DBQuery("SELECT vehiculo_modelo,chasis,chapa,cliente,nro_asesor,id, fecha_ingreso, ta.descripcion
								FROM seguimiento_ordenes so
								LEFT OUTER JOIN tipo_de_atencion ta on ta.id_tipo_de_atencion = so.id_tipo_de_atencion
							 WHERE LOWER(REPLACE(chasis,' ','')) LIKE '%$_parametros%'
							 OR LOWER(REPLACE(chapa,' ','')) LIKE '%$_parametros%'
							 OR LOWER(REPLACE(ot,' ','')) LIKE '%$_parametros%'
							 order by so.id desc
							 limit 1");

$seguimiento = $db->executeQuery($qseguimiento);

$id_seguimiento = $seguimiento[0]['id'];

// ULTIMO TIEMPO ORDEN
$qutiempo = new DBQuery("SELECT t.tecnico,eo.estado, eo.color, tot.fecha_comprometida, eo.id
	FROM tiempos_ordenes tot
	 LEFT OUTER JOIN estados_ordenes eo ON eo.id = tot.id_estado
	 LEFT OUTER JOIN tecnicos t ON t.id = tot.tecnico
     where tot.id_seguimiento = '$id_seguimiento'
     order by tot.id DESC
     LIMIT 1");
$utiempo = $db->executeQuery($qutiempo);

// TIEMPOS ORDENES DETALLE
$qtiempos_ordenes = new DBQuery("SELECT t.tecnico, nombre, apellido, eo.estado, id_estado, fecha_comprometida, observaciones, tot.fecha_creacion, jg.nombre_apellido
								 FROM tiempos_ordenes tot
								 LEFT OUTER JOIN usuarios u ON u.id_usuario = tot.id_usuario
								 LEFT OUTER JOIN jefes_grupos jg ON jg.id = tot.id_jefe
								 LEFT OUTER JOIN estados_ordenes eo ON eo.id = tot.id_estado
								 LEFT OUTER JOIN tecnicos t ON t.id = tot.tecnico
								 WHERE id_seguimiento = '$id_seguimiento'
								 order by tot.id DESC");
$tiempos_ordenes = $db->executeQuery($qtiempos_ordenes);

foreach($tiempos_ordenes as $rs)
{
	$to[] = array(
	    "tecnico" => ((!empty($rs['tecnico'])) ? $rs['tecnico'] : '-'),
	    "modificado_por" => $rs['nombre']." ".$rs['apellido'],
	    "estado" => ((!empty($rs['estado'])) ? $rs['estado'] : 'Nuevo'),
	    "id_estado" => $rs['id_estado'],
	    "observaciones" => (($rs['observaciones'] != '') ? $rs['observaciones'] : ' '),
	    "fecha_comprometida" => (($rs['fecha_comprometida'] != '' && $rs['id_estado'] <> 10) ? date('d/m/Y H:i', strtotime($rs['fecha_comprometida'])) : '-'),
	    "fecha_creacion" => (($rs['fecha_creacion'] != '') ? date('d/m/Y H:i', strtotime($rs['fecha_creacion'])) : '-'),
			"jefe_grupo" => ((!empty($rs['nombre_apellido'])) ? $rs['nombre_apellido'] : '-'),
	);
}

//DETALLE DE REINGRESO
$qdetalle_ordenes = new DBQuery("SELECT *
                                  FROM detalle_ordenes do
                                  WHERE id_seguimiento = '$id_seguimiento' and reingreso = 1");
$detalle_ordenes = $db->executeQuery($qdetalle_ordenes);
foreach($detalle_ordenes as $rs)
{

	$det[] = array(
		"nro_linea" => $rs['nro_linea'],
	    "descripcion" => $rs['descripcion'],

	);

}

if(!empty($seguimiento))
	echo json_encode(array(
							'success'=>true,
							"fecha_creacion"=>date('d/m/Y', strtotime($seguimiento[0]['fecha_ingreso'])) ,
							"vehiculo_modelo"=>$seguimiento[0]['vehiculo_modelo'],
							"chasis"=>$seguimiento[0]['chasis'],
							"chapa"=>(($seguimiento[0]['chapa'] != '') ? $seguimiento[0]['chapa'] : '-'),
							"cliente"=>$seguimiento[0]['cliente'],
							"nro_asesor"=>$seguimiento[0]['nro_asesor'],
							"tecnico"=>((!empty($utiempo[0]['tecnico'])) ? $utiempo[0]['tecnico'] : '-'),
							"estado"=>((!empty($utiempo[0]['estado'])) ? $utiempo[0]['estado'] : 'Nuevo'),
							"color"=>$utiempo[0]['color'],
							"fecha_comprometida"=>((!empty($utiempo[0]['fecha_comprometida'])) ? date('d/m/Y H:i', strtotime($utiempo[0]['fecha_comprometida'])) : '-'),
							"tipo_atencion"=>$seguimiento[0]['descripcion'],
							"tiempos_ordenes" => $to,
							"detalle_ordenes" => $det
						));
else
	echo json_encode(array('success'=>false));
