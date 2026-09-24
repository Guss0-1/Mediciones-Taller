<?php include_once("inc/config.inc.php");

$usuario_logueado = new usuarios();

$codigo_seccion_administrable = 'ot';
/* Chequeo de permisos de usuario */
$usuario_logueado->carga($_SESSION['s_id_usuario']);
$nivel_acceso = $usuario_logueado->recupera_permisos($codigo_seccion_administrable);

if( ($nivel_acceso['alta']!='S') && ($nivel_acceso['baja']!='S') && ($nivel_acceso['modificacion'] != 'S') && ($nivel_acceso['consulta']!='S') )
  header('location: admin/index.php');

$db = new DBManager();

// SEGUIMIENTO DE ORDENES
$_parametros = str_replace(' ', '', strtolower(TextHelper::cleanString($_GET['chasis'])));
$qseguimiento = new DBQuery("SELECT *, so.id seguimiento_ordenes_id, IFNULL(no_conformidad, 0) as no_conformidad_
                FROM seguimiento_ordenes so
               WHERE LOWER(REPLACE(chasis,' ','')) LIKE '%$_parametros%'
               OR LOWER(REPLACE(chapa,' ','')) LIKE '%$_parametros%'
               OR LOWER(REPLACE(ot,' ','')) LIKE '%$_parametros%'
							 order by so.id desc
               LIMIT 1");
$seguimiento = $db->executeQuery($qseguimiento);

// DETALLE DE ORDENES
$id_seguimiento = $seguimiento[0]['seguimiento_ordenes_id'];
$qdetalle_ordenes = new DBQuery("SELECT *
                                  FROM detalle_ordenes do
                                  WHERE id_seguimiento = '$id_seguimiento'");
$detalle_ordenes = $db->executeQuery($qdetalle_ordenes);

// ULTIMO ESTADO ORDEN
$qultimo_estado = new DBQuery("SELECT id tiempos_ordenes_id, id_estado, fecha_comprometida, tecnico, id_jefe
                                FROM tiempos_ordenes WHERE id_seguimiento = '$id_seguimiento' and id_estado != 19
                                ORDER BY id desc limit 1 ");
$ultimo_estado = $db->executeQuery($qultimo_estado);

// ESTADOS DE ORDENES
$qestados = new DBQuery("SELECT * FROM estados_ordenes where uso = 'activo' and id != 19 order by orden asc");
$estados = $db->executeQuery($qestados);

//TECNICOS
$sql_filtro_jefe_grupo = !empty($ultimo_estado[0]['id_jefe']) ? "and id_jefe = '" .$ultimo_estado[0]['id_jefe']. "'" : "";

if($ultimo_estado[0]['id_jefe'] == 10 || $ultimo_estado[0]['id_jefe'] ==8){
  //si el jefe es de chaperia, sumarle los preparadores
  $sql_filtro_jefe_grupo = $sql_filtro_jefe_grupo. " or nro_tecnico in ('26') ";
}
$qtecnicos = new DBQuery("SELECT * FROM tecnicos where estado = 'activo' $sql_filtro_jefe_grupo order by tecnico asc");
//echo "tecnicos ".$qtecnicos;
$tecnicos = $db->executeQuery($qtecnicos);

//TECNICOS NO CONFORMIDADES
$sql_filtro_jefe_grupo = "";
$sql_filtro_jefe_grupo = !empty($seguimiento[0]['id_jefe_grupo_no_conformidad']) ? "and id_jefe = '" .$seguimiento[0]['id_jefe_grupo_no_conformidad']. "'" : "";

if($seguimiento[0]['id_jefe_grupo_no_conformidad'] == 10 || $seguimiento[0]['id_jefe_grupo_no_conformidad'] ==8){
  //si el jefe es de chaperia, sumarle los preparadores
  $sql_filtro_jefe_grupo = $sql_filtro_jefe_grupo. " or nro_tecnico in ('26') ";
}
$qtecnicos_no_conf = new DBQuery("SELECT * FROM tecnicos where estado = 'activo' $sql_filtro_jefe_grupo order by tecnico asc");
$tecnicos_no_conf = $db->executeQuery($qtecnicos_no_conf);

//JEFES DE GRUPO
$qjefes_grupos = new DBQuery("SELECT * FROM jefes_grupos order by nombre_apellido asc");
$jefes_grupos = $db->executeQuery($qjefes_grupos);

// HISTORIAL DE ESTADOS
$qtiempos_ordenes = new DBQuery("SELECT tot.id, t.tecnico, jg.nombre_apellido, nombre, apellido, eo.estado, id_estado, fecha_comprometida, observaciones, tot.fecha_creacion
                 FROM tiempos_ordenes tot
                 LEFT OUTER JOIN usuarios u ON u.id_usuario = tot.id_usuario
                 LEFT OUTER JOIN estados_ordenes eo ON eo.id = tot.id_estado
                 LEFT OUTER JOIN tecnicos t ON t.id = tot.tecnico
                 LEFT OUTER JOIN jefes_grupos jg on tot.id_jefe = jg.id
                 WHERE id_seguimiento = '$id_seguimiento'
                 order by tot.id DESC");
$tiempos_ordenes = $db->executeQuery($qtiempos_ordenes);

$qarchivos_ordenes = new DBQuery("SELECT ar.id, CONCAT(u.nombre, ' ',u.apellido) AS usuario, ar.fecha_creacion, ar.nombre,
ar.archivo FROM archivos_ordenes ar JOIN usuarios u ON ar.id_usuario = u.`id_usuario`
WHERE id_seguimiento = '$id_seguimiento' order by ar.id desc");
$archivos_ordenes = $db->executeQuery($qarchivos_ordenes);

//TIPOS DE ATENCION
$qtipos_atencion = new DBQuery("SELECT id_tipo_de_atencion, descripcion FROM tipo_de_atencion ORDER BY descripcion ASC");
$tipos_de_atencion = $db->executeQuery($qtipos_atencion);


if(empty($seguimiento))
  header("location: ./ot.php");

?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <?php include_once("admin/inc/sidemenu.tpl.php"); ?>
  <title>Modificar Estado del trabajo - Perfecta automotores S.A.</title>
  <link rel='stylesheet prefetch' href='<?php echo CONF_SITE_URL; ?>css/bootstrap.min.css'>
  <link rel='stylesheet prefetch' href='<?php echo CONF_SITE_URL; ?>css/bootstrap-theme.min.css'>
  <link rel='stylesheet prefetch' href='<?php echo CONF_SITE_URL; ?>css/bootstrapValidator.min.css'>
  <link  rel="stylesheet" href="<?php echo CONF_SITE_URL; ?>js/datepicker/bootstrap-datetimepicker.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="<?php echo CONF_SITE_URL; ?>css/style.css">

  <!-- jquery ui -->
<link rel="stylesheet" href="<?php echo CONF_ADMIN_URL; ?>css/jquery-ui-1.8.16.custom.css" type="text/css" media="screen" title="no title" charset="utf-8" />

</head>

<body>
  <div class="container">

    <div class="row">
      <div class="col-md-6">
        <div class="col-md-3">
          <a href="./admin/index.php"><img width="80px" src="images/logo-bmw.png"> </a>
        </div>
        <div class="col-md-6">
          <h3>Estados de Trabajos</h3>
        </div>
      </div>
      <div class="col-md-6">
        <h3>PERFECTA AUTOMOTORES S.A.</h3>
      </div>
    </div>

<form class="form-horizontal" action="ajax/modificar_ot.php" method="post"  id="contact_form">
<fieldset>

<!-- Form Name -->
<legend>Modificar Estado</legend>

<div class="row">

  <input name="seguimiento_ordenes_id" value="<?php echo $seguimiento[0]['seguimiento_ordenes_id'] ?>" id="seguimiento_ordenes_id" type="hidden">
  <input name="tiempos_ordenes_id" value="<?php echo $ultimo_estado[0]['tiempos_ordenes_id'] ?>" id="tiempos_ordenes_id" type="hidden">

  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Nro. OT:</strong> <?php echo $seguimiento[0]['ot'] ?></p>
  </div>

  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Cliente:</strong> <?php echo $seguimiento[0]['cliente'] ?></p>
  </div>

  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Modelo Vehiculo:</strong> <?php echo $seguimiento[0]['vehiculo_modelo'] ?></p>
  </div>

  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Chasis:</strong> <?php echo $seguimiento[0]['chasis'] ?></p>
  </div>

  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Chapa:</strong> <?php echo $seguimiento[0]['chapa'] ?></p>
  </div>

  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Fecha de ingreso:</strong> <?php echo date('d/m/Y', strtotime($seguimiento[0]['fecha_ingreso'])) ?></p>
  </div>
  <!-- habilitar solo a los usuarios 12 y 31 para modificar OT cerrada o Terminada -->
    <?php
      $Disabled= "";
      $usuario = $_SESSION['s_id_usuario'] ;
      if ($usuario == 12 || $usuario == 31 ) {
        $Disabled= "";
      }else {
        if(($ultimo_estado[0]['id_estado'])==10 || ($ultimo_estado[0]['id_estado'])==9)
        {
        $Disabled= "disabled";
        }
      }
    ?>
  <div class="form-group col-md-6">
      <p class="col-md-6"><strong>Asesor de Servicio:</strong> <?php echo $seguimiento[0]['nro_asesor'] ?></p>
  </div>

    <div class="form-group col-md-12">
      <p class="col-md-2 ">Jefe de Grupo</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <select name="jefe_grupo" id="jefe_grupo" class="form-control selectpicker" <?php echo ($Disabled);?>>
          <option value=""></option>
          <?php foreach($jefes_grupos as $rs){ ?>
            <option <?php if($ultimo_estado[0]['id_jefe'] == $rs['id']){echo "selected='selected'";} ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['nombre_apellido'] ?></option>
          <?php }?>

        </select>
       </div>
      </div>
    </div>

    <div class="form-group col-md-12">
      <p class="col-md-2 ">Tecnico Actual</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <select name="tecnico" id="tecnico" class="form-control selectpicker" <?php echo ($Disabled);?>>
          <option value=""></option>
          <?php foreach($tecnicos as $rs){ ?>
            <option <?php if($ultimo_estado[0]['tecnico'] == $rs['id']){echo "selected='selected'";} ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['tecnico'] ?></option>
          <?php }?>

        </select>
       </div>
      </div>
    </div>

    <div class="form-group col-md-12">
      <p class="col-md-2">Estado</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
          <select name="estados_ordenes" id="estados_ordenes" class="form-control selectpicker" <?php echo ($Disabled);?>>
            <option value=""></option>
          <?php foreach($estados as $rs){ ?>
            <option <?php if($ultimo_estado[0]['id_estado'] == $rs['id']){echo "selected='selected'";} ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['estado'] ?></option>
          <?php }?>

        </select>
        </div>
      </div>
    </div>

    <div class="form-group col-md-12">
      <p class="col-md-2">Fecha Comprometida</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
        <input name="fecha_comprometida" value="<?php echo (($ultimo_estado[0]['fecha_comprometida'] != '') ? date('d/m/Y H:i', strtotime($ultimo_estado[0]['fecha_comprometida'])) : '') ?>" id="datetimepicker" placeholder="Fecha Comprometida" class="form-control"  type="text" <?php echo ($Disabled);?>>
      </div>
      </div>
    </div>

   <div class="form-group col-md-12">
    <p class="col-md-2">Observaciones</p>
      <div class="col-md-10 inputGroupContainer">
      <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
            <textarea class="form-control" name="observaciones" placeholder="Observaciones" <?php echo ($Disabled);?>></textarea>
    </div>
    </div>
  </div>

  <div class="form-group col-md-12">
    <p class="col-md-2">Servicio</p>

    <div class="col-md-10 inputGroupContainer">
      <div class="input-group">
        <input type="checkbox" id="preparacion_servicio" name="preparacion_servicio" value="0" style='margin-right: 10px;top: 0; left: 0; height: 20px; width: 20px; background-color: #eee;'  <?php if($_SESSION['s_id_rol']  != 3){echo "disabled";} ?>>
        <div id="mensaje_warning"></div>
      </div>

    </div>
  </div>

  <div class="form-group col-md-12">
    <p class="col-md-2">Presupuesto Aprobado</p>

    <div class="col-md-10 inputGroupContainer">
      <div class="input-group">
        <input type="checkbox" id="preparacion_presupuesto" name="preparacion_presupuesto" value="0" style='margin-right: 10px;top: 0; left: 0; height: 20px; width: 20px; background-color: #eee;'  <?php if($_SESSION['s_id_rol']  != 3){echo "disabled";} ?>>
        <div id="mensaje_warning"></div>
      </div>

    </div>
  </div>

  <div class="form-group col-md-12">
    <p class="col-md-2">Enviar a BPS</p>

    <div class="col-md-10 inputGroupContainer">
      <div class="input-group">
        <input type="checkbox" id="enviar_bps" name="enviar_bps" value="0" style='margin-right: 10px;top: 0; left: 0; height: 20px; width: 20px; background-color: #eee;'
         <?php if($_SESSION['s_id_rol']  != 3 && $_SESSION['s_id_rol'] != 1){echo "disabled";} ?><?php echo ($Disabled);?>>
        <div id="mensaje_warning"></div>
      </div>

    </div>
  </div>


  <div class="form-group col-md-12">
    <p class="col-md-2"></p>
    <div class="col-md-10 inputGroupContainer">
      <div class="input-group">

      </div>

    </div>
  </div>

   <div class="form-group col-md-12 seccion_estados">
      <h4>Ordenes por Reingreso</h4>

      <table class="table historial_estados table-hover table-responsive">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Descripción</th>
            <th scope="col">Reingreso</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($detalle_ordenes as $rs){ ?>
          <tr>
               <td>  <?php echo $rs['descripcion'] ?> </td>
               <td>  <input type="hidden" name="reingreso[<?php echo $rs['id'] ?>]" value="0" />
                     <input type="checkbox" <?php echo (($rs['reingreso'] == 1) ? 'checked="checked"' : '') ?> name="reingreso[<?php echo $rs['id'] ?>]" value="1" <?php echo ($Disabled);?>>

               </td>
          </tr>
           <?php }?>
        </tbody>
      </table>
  </div>
</div>
<!-- Success message -->
<div class="alert alert-success" role="alert" id="success_message">
<i class="glyphicon glyphicon-thumbs-up"></i> Los datos ingresados han sido guardados con exito :)
</div>

<!-- error message -->
<div class="alert alert-warning" role="alert" id="warning_message">
<i class="glyphicon glyphicon-thumbs-down"></i> Ocurrio un error al registrar los datos. Intente nuevamente en unos momentos :(
</div>

<!-- Button -->
<div class="form-group">
  <p class="col-md-4 control-label"></p>
  <div class="col-md-4">
    <?php //if(!in_array($ultimo_estado[0]['id_estado'], array(10,12) )){ ?>
      <button type="submit" class="btn btn-warning" id="enviar_form" <?php echo ($Disabled);?>>Guardar <span class="glyphicon glyphicon-saved"></span></button>
    <?php //} ?>
    <button type="button" onclick="location.replace('ot'); return false;" class="btn btn-primary">Volver <span class="glyphicon glyphicon-chevron-left"></span></button>
  </div>
</div>

</fieldset>
</form>

<form class="form-horizontal" action="ajax/guardar_tipo_atencion.php" method="post"  id="tipo_form" >
  <fieldset>
  <legend>Tipo de atención</legend>
  <div class="form-group col-md-12 seccion_estados">
    <input name="seguimiento_ordenes_id" value="<?php echo $seguimiento[0]['seguimiento_ordenes_id'] ?>" id="seguimiento_ordenes_id" type="hidden">
    <input name="no_conformidad" value="<?php echo $seguimiento[0]['no_conformidad_'] ?>" id="no_conformidad" type="hidden">
    <!-- habilitar solo a los usuarios 12 y 31 para modificar OT cerrada o Terminada -->
      <?php
        $Disabled= "";
        $usuario = $_SESSION['s_id_usuario'] ;
        if ($usuario == 12 || $usuario == 31 ) {
          $Disabled= "";
        }else {
          if(($ultimo_estado[0]['id_estado'])==10 || ($ultimo_estado[0]['id_estado'])==9)
          {
          $Disabled= "disabled";
          }
        }
      ?>
    <div class="form-group col-md-12">
      <p class="col-md-2">Tipo de atención</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
          <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
          <select name="id_tipo_de_atencion" id="id_tipo_de_atencion" class="form-control selectpicker" <?php echo ($Disabled);?>>
            <option value=""></option>
          <?php foreach($tipos_de_atencion as $rs){ ?>
            <option <?php if($seguimiento[0]['id_tipo_de_atencion'] == $rs['id_tipo_de_atencion']){echo "selected='selected'";} ?> value="<?php echo $rs['id_tipo_de_atencion'] ?>"><?php echo $rs['descripcion'] ?></option>
          <?php }?>

        </select>
        </div>
      </div>
    </div>
  </div>
  <!-- Success message -->
  <div class="alert alert-success" role="alert" id="success_message" >
  <i class="glyphicon glyphicon-thumbs-up"></i> El datos ingresados han sido guardados con exito :)
  </div>

  <!-- error message -->
  <div class="alert alert-warning" role="alert" id="warning_message">
  <i class="glyphicon glyphicon-thumbs-down"></i> Ocurrio un error al registrar los datos. Intente nuevamente en unos momentos :(
  </div>

  <div class="form-group">
    <p class="col-md-4 control-label"></p>
    <div class="col-md-4">
        <button type="submit" class="btn btn-warning" id="enviar_tipo" <?php if($_SESSION['s_id_rol']  != 3 && $_SESSION['s_id_rol'] != 8 && $_SESSION['s_id_rol'] != 1){echo "disabled";} ?><?php echo ($Disabled);?>>Guardar tipo <span class="glyphicon glyphicon-saved"></span></button>
    </div>
  </div>

  </fieldset>
  </form>


<form class="form-horizontal" action="ajax/guardar_no_conformidad.php" method="post"  id="noconformidad_form" >
  <fieldset>
  <legend>No conformidad</legend>
  <div class="form-group col-md-12 seccion_estados">
    <input name="seguimiento_ordenes_id" value="<?php echo $seguimiento[0]['seguimiento_ordenes_id'] ?>" id="seguimiento_ordenes_id" type="hidden">
    <input name="no_conformidad" value="<?php echo $seguimiento[0]['no_conformidad_'] ?>" id="no_conformidad" type="hidden">
    <!-- habilitar solo a los usuarios 12 y 31 para modificar OT cerrada o Terminada -->
      <?php
        $Disabled= "";
        $usuario = $_SESSION['s_id_usuario'] ;
        if ($usuario == 12 || $usuario == 31 ) {
          $Disabled= "";
        }else {
          if(($ultimo_estado[0]['id_estado'])==10 || ($ultimo_estado[0]['id_estado'])==9)
          {
          $Disabled= "disabled";
          }
        }
      ?>
    <div class="form-group col-md-12">
      <p class="col-md-2 ">Jefe de Grupo</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>


        <select name="jefe_grupo_no_conf" id="jefe_grupo_no_conf" class="form-control selectpicker" <?php if($_SESSION['s_id_rol']  != 3 && $_SESSION['s_id_rol'] != 8 && $_SESSION['s_id_rol'] != 1){echo "disabled";} ?><?php echo ($Disabled);?>>
          <option value=""></option>
          <?php foreach($jefes_grupos as $rs){ ?>
            <option <?php if($seguimiento[0]['id_jefe_grupo_no_conformidad'] == $rs['id']){echo "selected='selected'";} ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['nombre_apellido'] ?></option>
          <?php }?>

        </select>
       </div>
      </div>
    </div>
    <div class="form-group col-md-12">
      <p class="col-md-2 ">Tecnico</p>
      <div class="col-md-10 inputGroupContainer">
        <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
        <select name="tecnico_no_conf" id="tecnico_no_conf" class="form-control selectpicker" <?php if($_SESSION['s_id_rol']  != 3 && $_SESSION['s_id_rol'] != 8 && $_SESSION['s_id_rol'] != 1){echo "disabled";} ?><?php echo ($Disabled);?>>
          <option value=""></option>

          <?php foreach($tecnicos_no_conf as $rs){ ?>
            <option <?php if($seguimiento[0]['id_tecnico_no_conformidad'] == $rs['id']){echo "selected='selected'";} ?> value="<?php echo $rs['id'] ?>"><?php echo $rs['tecnico'] ?></option>
          <?php }?>

        </select>
       </div>
      </div>
    </div>

    <div class="form-group col-md-12">
     <p class="col-md-2">Comentarios</p>
       <div class="col-md-10 inputGroupContainer">
       <div class="input-group">
           <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
           <textarea class="form-control" name="comentarios" placeholder="Comentarios"
            <?php if($_SESSION['s_id_rol']  != 3 && $_SESSION['s_id_rol'] != 8 && $_SESSION['s_id_rol'] != 1){echo "disabled";} ?><?php echo ($Disabled);?>
           ><?php echo $seguimiento[0]['comentario_no_conformidad'] ?></textarea>
     </div>
     </div>
    </div>
  </div>
  <!-- Success message -->
  <div class="alert alert-success" role="alert" id="success_message" >
  <i class="glyphicon glyphicon-thumbs-up"></i> El datos ingresados han sido guardados con exito :)
  </div>

  <!-- error message -->
  <div class="alert alert-warning" role="alert" id="warning_message">
  <i class="glyphicon glyphicon-thumbs-down"></i> Ocurrio un error al registrar los datos. Intente nuevamente en unos momentos :(
  </div>

  <div class="form-group">
    <p class="col-md-4 control-label"></p>
    <div class="col-md-4">
        <button type="submit" class="btn btn-warning" id="enviar_no_conf" <?php if($_SESSION['s_id_rol']  != 3 && $_SESSION['s_id_rol'] != 8 && $_SESSION['s_id_rol'] != 1){echo "disabled";} ?><?php echo ($Disabled);?>>Guardar no conformidad <span class="glyphicon glyphicon-saved"></span></button>
    </div>
  </div>

  </fieldset>
  </form>

<form class="form-horizontal" action="ajax/guardar_archivos_ordenes.php" method="post"  id="archivos_form" enctype="multipart/form-data" >
<fieldset>
<!-- Form Name -->
<legend>Cargar Archivos</legend>

<div class="row">
  <input name="seguimiento_ordenes_id" value="<?php echo $seguimiento[0]['seguimiento_ordenes_id'] ?>" id="seguimiento_ordenes_id" type="hidden">
    <div id="archivos_grupo">
      <div id="archivos_caja">
        <div class="form-group col-md-6">
          <p class="col-md-2">Archivo</p>
          <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
            <input type="file" name="archivo[]" class="form-control-file" id="archivo">
           </div>
          </div>
        </div>

        <div class="col-md-4">
          <p class="col-md-5"> Nombre de ref. de documento</p>
          <div class="col-md-7 inputGroupContainer">
            <div class="input-group">
            <input type="text" name="descripcion[]" class="form-control" id="descripcion" maxlength="100" required>
           </div>
          </div>
        </div>

        <div class="form-group col-md-1">
          <div class="col-md-1 inputGroupContainer">
            <div class="input-group">
            <p><button id="mas" type="button" class="btn btn-info">+</button></p>
           </div>
          </div>
        </div>

        <div class="form-group col-md-1">
          <div class="col-md-1 inputGroupContainer">
            <div class="input-group">
            <p><button id="menos" type="button" class="btn btn-danger" onclick="remove(this)">-</button></p>
           </div>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Success message -->
<div class="alert alert-success" role="alert" id="success_message">
<i class="glyphicon glyphicon-thumbs-up"></i> Los datos ingresados han sido guardados con exito :)
</div>

<!-- error message -->
<div class="alert alert-warning" role="alert" id="warning_message">
<i class="glyphicon glyphicon-thumbs-down"></i> Ocurrio un error al registrar los datos. Intente nuevamente en unos momentos :(
</div>
<!-- habilitar solo a los usuarios 12 y 31 para modificar OT cerrada o Terminada -->
  <?php
    $Disabled= "";
    $usuario = $_SESSION['s_id_usuario'] ;
    if ($usuario == 12 || $usuario == 31 ) {
      $Disabled= "";
    }else {
      if(($ultimo_estado[0]['id_estado'])==10 || ($ultimo_estado[0]['id_estado'])==9)
      {
      $Disabled= "disabled";
      }
    }
  ?>
<!-- Button -->
<div class="form-group">
  <p class="col-md-4 control-label"></p>
  <div class="col-md-4">
    <?php //if(!in_array($ultimo_estado[0]['id_estado'], array(10,12) )){ ?>
      <button type="submit" class="btn btn-warning" id="enviar" <?php echo ($Disabled);?>>Guardar <span class="glyphicon glyphicon-saved"></span></button>
    <?php //} ?>
    <button type="button" onclick="location.replace('ot'); return false;" class="btn btn-primary">Volver <span class="glyphicon glyphicon-chevron-left"></span></button>
  </div>
</div>

</fieldset>

</form>

<div id="dialog-confirm" title="Confirmación" style="display:none">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
  Esta acción creará un solicitud de preparación de piezas, está seguro que desea continuar?</p>
</div>

<div class="form-group col-md-12 seccion_estados">
      <h4>Archivos</h4>

      <table class="table archivos_ordenes table-hover table-responsive">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Fecha de Creación</th>
            <th scope="col">Usuario</th>
            <th scope="col">Nombre</th>
            <th scope="col">Archivo</th>

          </tr>
        </thead>
        <tbody>
          <?php foreach($archivos_ordenes as $rs){ ?>
            <tr>
                <td>  <?php echo $rs['id'] ?> </td>
                <td>  <?php echo date('d/m/Y H:i', strtotime($rs['fecha_creacion'])) ?> </td>
                <td>  <?php echo $rs['usuario']?> </td>
                <td>  <?php echo $rs['nombre'] ?>  </td>
                <td>
                  <a href="<?php echo 'upload/archivos_ordenes/'.$rs['archivo']; ?>" download="<?php echo $rs['archivo'] ?>">
                    <?php echo $rs['archivo'] ?>
                  </a>
                </td>

            </tr>
          <?php }?>
        </tbody>
      </table>
  </div>

<div class="form-group col-md-12 seccion_estados">
      <h4>Historial de estados</h4>

      <table class="table historial_estados table-hover table-responsive">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Id</th>
            <th scope="col">Fecha de Creación</th>
            <th scope="col">Creado por</th>
            <th scope="col">Estado</th>
            <th scope="col">Jefe de Grupo</th>
            <th scope="col">Tecnico Asignado</th>
            <th scope="col">Observaciones</th>
            <th scope="col">Fecha Comprometida</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($tiempos_ordenes as $rs){ ?>
          <tr>
              <td>  <?php echo $rs['id'] ?> </td>
               <td>  <?php echo date('d/m/Y H:i', strtotime($rs['fecha_creacion'])) ?> </td>

               <td>  <?php echo $rs['nombre'] ." ".$rs['apellido'] ?> </td>
               <td>  <?php echo $rs['estado'] ?>  </td>
               <td>  <?php echo $rs['nombre_apellido'] ?>  </td>
               <td>  <?php echo ((!empty($rs['tecnico'])) ? $rs['tecnico'] : '-') ?>  </td>
               <td>  <?php echo $rs['observaciones'] ?>  </td>
               <td>  <?php echo (($rs['fecha_comprometida'] != '' && $rs['id_estado'] <> 10) ? date('d/m/Y H:i', strtotime($rs['fecha_comprometida'])) : '-') ?>  </td>
          </tr>
           <?php }?>
        </tbody>
      </table>
  </div>

    </div><!-- /.container -->

<script src="<?php echo CONF_SITE_URL; ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo CONF_SITE_URL; ?>js/jquery-ui.min.js"></script>
<script src='<?php echo CONF_SITE_URL; ?>js/bootstrap.min.js'></script>
<script src='<?php echo CONF_SITE_URL; ?>js/bootstrapvalidator.min.js'></script>
<script src="<?php echo CONF_SITE_URL; ?>js/datepicker/moment.min.js"></script>
<script src="<?php echo CONF_SITE_URL; ?>js/datepicker/bootstrap-datetimepicker.js"></script>
<script src="<?php echo CONF_SITE_URL; ?>js/modificar_ot.js"></script>
</body>
</html>
