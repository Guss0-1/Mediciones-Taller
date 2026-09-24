<?php include_once("inc/config.inc.php");

  $db = new DBManager();

  $usuario_logueado = new usuarios();
  $codigo_seccion_administrable = 'solicitud_pieza_detalle';

  $usuario_logueado->carga($_SESSION['s_id_usuario']);
  $nivel_acceso = $usuario_logueado->recupera_permisos($codigo_seccion_administrable);
  if( ($nivel_acceso['alta']!='S') && ($nivel_acceso['baja']!='S') && ($nivel_acceso['modificacion'] != 'S') && ($nivel_acceso['consulta']!='S') )
    header('location: /admin/index.php');
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Solicitudes de piezas</title>
    <link rel="shortcut icon" type="" href="images/favicon.png" />
    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="dist/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">



</head>
<body>

    <div id="wrapper">
        <div id="page-wrapper25">
        <?php //include "admin/inc/sidemenu.tpl.php"; ?>
        </div>
        <div id="page-wrapper">

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Solicitudes de pieza</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Solicitudes de pieza
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Nro. de oferta</th>
                                        <th>Cliente</th>
                                        <th>Chasis</th>
                                        <th>Transporte</th>
                                        <th>Creado por</th>
                                        <th>Fecha de creación</th>
                                        <th>Nro. de pieza</th>
                                        <th>Cant.</th>
                                        <th>Estado</th>
                                        <th>Nro. de factura</th>
                                        <th>Nro. de guía</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $solicitudes = new DBQuery("SELECT
id_solicitud,
fecha_solicitud,
cliente,
chasis,
modelo,
u.usuario,
tp.tipo,
motivo,
nro_oferta,
fecha_solicitud,
det.numero_pieza,
det.cantidad,
est.estado,
det.nro_factura,
det.nro_guia
FROM
conquestool.solicitud_pieza_cab cab
JOIN conquestool.solicitud_pieza_det det ON det.id_solicitud_pieza_cab = cab.id_solicitud
JOIN usuarios u ON cab.id_usuario = u.id_usuario
JOIN tipo_transporte tp ON tp.id_tipo_transporte = cab.id_tipo_transporte
JOIN estado_pedido_pieza est ON est.id_estado_pedido_pieza = det.id_estado");
                                        $datas = $db->executeQuery($solicitudes);
                                        foreach($datas as $data){

                                    ?>
                                              <tr class="odd gradeX">
                                                  <td><?=$data['id_solicitud']; ?></td>
                                                  <td><?=$data['nro_oferta']; ?></td>
                                                  <td><?=$data['cliente']; ?></td>
                                                  <td><?=$data['chasis']; ?></td>
                                                  <td><?=$data['tipo']; ?></td>
                                                  <td><?=$data['usuario']; ?></td>
                                                  <td><?=$data['fecha_solicitud']; ?></td>
                                                  <td><?=$data['numero_pieza']; ?></td>
                                                  <td><?=$data['cantidad']; ?></td>
                                                  <td><?=$data['estado']; ?></td>
                                                  <td><?=$data['nro_factura']; ?></td>
                                                  <td><?=$data['nro_guia']; ?></td>
                                                  <td class="text-center">
                                                    <a class="glyphicon glyphicon-pencil" href="solicitud_pieza_editar.php?id=<?=$data['id_solicitud']?>"></a>
                                                  </td>
                                              </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
            <tr>
                <th>Solicitud</th>
                <th>Numero de oferta</th>
                <th>Cliente</th>
                <th>chasis</th>
                <th>Tipo</th>
                <th>Usuario</th>
                <th>FEcha de solicitud</th>
                <th>Numero de pieza</th>
                <th>Camtidad</th>
                <th>Estado</th>
                <th>Nro factura</th>
                <th>Nro guia</th>

            </tr>
        </tfoot>
                            </table>
                            <!-- /.table-responsive -->
                             <a href="solicitud_pieza_crear.php"><button type="button" class="btn btn-primary">Crear Solicitud</button></a>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="vendor/metisMenu/metisMenu.min.js"></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>
    <script src="dist/js/sb-admin-2.js"></script>
    <script src="<?php echo CONF_SITE_URL; ?>js/solicitud_pieza_detalle.js"></script>
    <script>
    $(document).ready(function() {

    });
    </script>

</body>

</html>
