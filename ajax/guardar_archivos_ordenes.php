<?php 
include_once '../inc/config.inc.php'; 


header('Content-type: application/json');

$db = new DBManager();

$_parametros['seguimiento_ordenes_id'] = TextHelper::cleanNumber($_POST['seguimiento_ordenes_id']);

$lista_archivos =array();

$i = 0;

foreach ($_FILES['archivo'][name] as $value) {
		
			$archivo = array(
		    'name'  =>$_FILES['archivo'][name][$i],
		    'type'  =>  $_FILES['archivo'][type][$i],
		    'tmp_name'  =>  $_FILES['archivo'][tmp_name][$i],
		    'error' =>  $_FILES['archivo'][error][$i],
		    'size' =>  $_FILES['archivo'][size][$i],
		    'descripcion' =>  $_POST['descripcion'][$i],

			);
			$i++;
		array_push($lista_archivos, $archivo);
		
}

//se guarda el archivo
foreach ($lista_archivos as $archivo) {
	$nom_archivo = (int) (microtime(true) * 1000); 
	$archivos_ordenes = new archivos_ordenes();
	$archivos_ordenes->set_id(null); 
	$archivos_ordenes->set_nombre($archivo[descripcion]); 
	$archivos_ordenes->set_id_usuario($_SESSION['s_id_usuario']); 
	$archivos_ordenes->set_id_seguimiento($_parametros['seguimiento_ordenes_id']);
	$archivos_ordenes->set_fecha_creacion(date('Y-m-d H:i:s'));

    $nombre = $nom_archivo . substr($archivo[name], strrpos($archivo[name], '.')); 

	FileManager::subeArchivo( $archivo, 'archivos_ordenes',$nom_archivo);
	$archivos_ordenes->set_archivo($nombre); 		
 	$archivos_ordenes->guarda();
			 
}


header("Location: {$_SERVER['HTTP_REFERER']}");
