<?php
include_once '../inc/config.inc.php';


header('Content-type: application/json');

$db = new DBManager();

$idsolicitud = TextHelper::cleanString($_POST['id_solicitud']);

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
//echo "solicitud: $idsolicitud";

//se guarda el archivo
foreach ($lista_archivos as $archivo) {

	$archivo_descripcion = $archivo[descripcion];
	$nom_archivo = (int) (microtime(true) * 1000);
  $nombre = $nom_archivo . substr($archivo[name], strrpos($archivo[name], '.'));
	$usuario_creacion = $_SESSION['s_id_usuario'];

	FileManager::subeArchivo( $archivo, 'archivos_solicitud',$nom_archivo);

	$qinsertarchivo = new DBQuery("INSERT INTO conquestool.archivos_solicitud (archivo, nombre, id_usuario, id_solicitud)
   VALUES('$nombre', '$archivo_descripcion', '$usuario_creacion', '$idsolicitud');");
	 $db->executeNonQuery($qinsertarchivo);
	 echo json_encode(array('success'=>true, 'mensaje' => 'Archivo cargado correctamente.'));

}


header("Location: {$_SERVER['HTTP_REFERER']}");
