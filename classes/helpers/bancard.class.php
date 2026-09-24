<?php

class Bancard {

    protected $_respuesta = array();
    
    public function __construct() { 
        $this->_dbmanager = new DBManager();
    } 
		
    /**
     * Inserta el pedido al sistema con los datos incluidos como parametros.
     * $p_id_usuario id de usuario encargado en realizar el pedido
     * $p_clave_comercio clave de comercio del sitio
     * $p_moneda Código de la moneda original de la operación: 840 Dolares - 600 Guaraníes
     * $p_redirect archivo de redireccionamiento en caso de error por defecto index.php del sitio
     * $p_productos es un vector de productos de la classe class.cart.php. $p_productos array debe contener como variables (quantity=>3,price=>150000,id=>78954 { id del producto} )
     */
    public static function pedido($p_id_usuario, $p_clave_comercio, $p_moneda = 840, $p_productos = array()) {

        /** ************ Controles ************************* */
        if (!isset($p_id_usuario)) {
            $_respuesta = array('success'=>false,'message'=>"Error - Falta Parametro de Codigo de Usuario.");
            return $_respuesta;
        }
        if (count($p_productos) == 0) {
            $_respuesta = array('success'=>false,'message'=>"Error - EL carrito esta Vacio.");
            return $_respuesta;
        }
        
        if ($p_clave_comercio) {
            $_respuesta = array('success'=>false,'message'=>"Error - Falta Parametro de Codigo de Comercio.");
            return $_respuesta;
        }
        
        /** **************************************************** */
        foreach ($p_productos as $i => $rs) {
            $p_total += $rs['quantity'] * (int) $rs['price'];
        }

        # Importe en guaranies de la operación - longitud fija de 10 caracteres. Se rellena de ceros a la izquierda
        $monto_input = str_pad($p_total, 10, "0", STR_PAD_LEFT); //En este caso todo es en guaraníes, no hace falta hacer ninguna conversión de dolar a guaraníes.
        # Importe en la moneda original de la operación (los 2 últimos digitos son los decimales) longitud fija de 12 caracteres. Se rellena de ceros a la izquierda
        $mto_orig_input = str_pad($p_total . "00", 12, "0", STR_PAD_LEFT); // Como es en guaraníes, es el mismo monto que monto_input, solo que con los 2 decimales reservados
        # Código de la moneda original de la operación: 840 Dolares - 600 Guaraníes
        $mone_orig_input = $p_moneda;
        # Número único por pedido de autorización
        $nro_pedido_input = date('ymdHis') * $p_id_usuario;
        # Codigo de ISP asignado por Bancard
        $isp_input = "0000601";
        # Tipo de operación: 0 Autorización - 1 Reversa
        $oper_input = 0;

        # Parametros a guardar
        $p['cliente_id'] = $p_id_usuario;
        $p['total'] = $total;
        $p['nro_pedido_input'] = $nro_pedido_input;
        $p['isp_input'] = $isp_input;
        $p['monto_input'] = $monto_input;
        $p['mto_orig_input'] = $mto_orig_input;
        $p['mone_orig_input'] = $mone_orig_input;
        $p['oper_input'] = $oper_input;
        
        ## INSERSION DE LA CABECERA DEL PÈDIDO
        $pedido_id = $this->_dbmanager->executeNonQuery("insert into `pedidos` (`cliente_id`, `total`, `nro_pedido_input`, `isp_input`,  `monto_input`, `mto_orig_input`, `mone_orig_input`,`oper_input`) 													
                                                            VALUES ('{$p['cliente_id']}',  '{$p['total']}',  '{$p['nro_pedido_input']}', '{$p['isp_input']}', '{$p['monto_input']}', '{$p['mto_orig_input']}','{$p['mone_orig_input']}','{$p['oper_input']}')");

        $pedido_id = $query->lastID();

        # INSERSION DE LOS DETALLES DEL PEDIDO
        foreach ($p_productos as $i => $rs) {

            $subtotal = $rs['quantity'] * (int) $rs['price'];

            $this->_dbmanager->executeNonQuery("INSERT INTO detalle_pedidos (`idpedido`, `idproducto`, `cantidad`, precio`,`subtotal`) 
                                                        VALUES ('{$pedido_id}', '{$rs['id']}', '{$rs['quantity']}','{$rs['price']}', '{$subtotal}')");
        }
        $_respuesta = array('success'=>true,'message'=>"https://www.bancard.com.py/cgi-bin/pagina_pagos?clavecomercio_input='{$p_clave_comercio}'&nro_pedido_input='{$nro_pedido_input}'");
        return $_respuesta;
    }

    /**
     * Lectura de datos desde bancard a nuestro sistema.
     * $nro_pedido_input es un valor que generalmente se recibe por $_GET.
     */
    public static function lecturaBancard($nro_pedido_input) {

        $nro_pedido_input = Helpers::cleanNumber($nro_pedido_input);

        if (empty($nro_pedido_input)) {
            $_respuesta = array('success'=>false,'message'=>"Error en parametros - Falta número de pedido.");
            return $_respuesta;     
        }
        
        $pedido_id = $this->_dbmanager->executeQuery("SELECT * FROM pedidos WHERE nro_pedido_input = '{$nro_pedido_input}'");

        if (count($pedido_id[0]) > 0) {
            $pedido = $pedido_id[0];
            $_respuesta = array('success'=>true,'message'=>($pedido['isp_input'] . ":" . $pedido['monto_input'] . ":" . $pedido['mto_orig_input'] . ":" . $pedido['mone_orig_input'] . ":" . $pedido['oper_input'] . "::"));
            return $_respuesta;     
        }
        
    }
    
    /**
     * Crea la lectura para que bancard lea los datos de nuestro sistema.
     * $p_clavecomercio_input clave de comercio del sitio.
     * $p_nro_pedido_input numero de pedido.
     * $_from $mail->From = $p_from;
     * $p_from_name $mail->FromName = $p_from_name;
     * $p_correo_destinatario $mail->AddAddress = $p_correo_destinatario;
     * $p_correo_copia $mail->AddBCC = $p_correo_copia;
     * $p_redirect redireccion del sitio en caso de exito de la transaccion que por defecto es index.php del sitio
     * $p_datos_usuario es un vector que contiene los datos del usuario que realizo la transaccion. $p_productos array debe contener como variables (titulo=>'nombre',dato=>'Juan Perez')
     */
    public static function respuestaBancard($p_clavecomercio_input, $p_nro_pedido_input, $_from, $_from_name, $p_correo_destinatario, $p_correo_copia, $p_redirect = 'index.php', $p_datos_usuario = array()) {
        
        if (empty($p_clavecomercio_input)) {
            $_respuesta = array('success'=>false,'message'=>"Error en parametros - No se especifición la clave de comercio.");
            return $_respuesta;     
        }

        if (empty($p_nro_pedido_input)) {
            $_respuesta = array('success'=>false,'message'=>"Error en parametros - No se especifición el número de pedido.");
            return $_respuesta;         
        }

        $datos_pedido = $this->_dbmanager->executeQuery("SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha_pedido FROM pedidos WHERE nro_pedido_input = '{$nro_pedido_input}'");

        if (count($datos_pedido) == 0) {
            $_respuesta = array('success'=>false,'message'=>"Error en parametros - No existe un número de pedido asociado.");
            return $_respuesta;     
        }

        $datos_respuesta = $this->_dbmanager->executeQuery("SELECT * FROM respuesta WHERE nro_pedido_input = '{$nro_pedido_input}'");

        if (count($datos_respuesta) > 0) {
            $_respuesta = array('success'=>false,'message'=>"Error en parametros - Este número de pedido ya fué procesado.");
            return $_respuesta;     
        }

        $cadena_devuelta = get_data("https://www.bancard.com.py/webbancard/?MIval=/ECOM/pasa_respuesta.html&clavecomercio_input='{$clavecomercio_input}'&nro_pedido_input='{$nro_pedido_input}'");
        $response = explode(":", $cadena_devuelta);

        $respuesta_output = $response[0];
        $msg_output = str_replace("_", "", $response[1]);
        $nro_autori_output = $response[2];
        $monto_input = $response[3];
        $nombre_output = str_replace("_", "", $response[4]);
        $servicio_output = $response[5];

        $pedido_id = $this->_dbmanager->executeNonQuery("INSERT INTO respuesta (nro_pedido_input,respuesta_output,msg_output,nro_autori_output,monto_input,nombre_output,servicio_output, cadena_devuelta) VALUES ('" . $nro_pedido_input . "','" . $respuesta_output . "','" . $msg_output . "','" . $nro_autori_output . "','" . $monto_input . "','" . $nombre_output . "','" . $servicio_output . "','" . $cadena_devuelta . "')");

        if ($respuesta_output == "00") {

            /** *******************************************
             * Envio de mail de confirmación al comprador
             * ******************************************** */
            $detalle_pedido = $this->_dbmanager->executeQuery("SELECT p.precio,p.nombre,dp.cantidad,dp.subtotal,p.idproducto FROM detalle_pedidos dp INNER JOIN productos p ON p.idproducto = dp.idproducto WHERE dp.idpedido = '{$datos_pedido[0]['id']}'");
            $datos_usuario = $this->_dbmanager->executeQuery("SELECT * FROM registro WHERE id_registro = '{$datos_pedido[0]['cliente_id']}'");

            ### DATOS DE PRODUCTOS
            foreach ($detalle_pedido as $rs) {
                $Sumatotal += $rs['subtotal'];
                $tr_productos.='		
		<tr>
                    <td><font face="Arial, Helvetica, sans-serif" size="2">' . $rs['idproducto'] . '</font></td>
                    <td><font face="Arial, Helvetica, sans-serif" size="2">' . utf8_decode($rs['titulo']) . '</font></td>
                    <td><font face="Arial, Helvetica, sans-serif" size="2">' . $rs['cantidad'] . '</font></td>
                    <td><font face="Arial, Helvetica, sans-serif" size="2">' . number_format($rs['precio'], 0, '', '.') . ' US$.</font></td>
                    <td><font face="Arial, Helvetica, sans-serif" size="2">' . number_format($rs['subtotal'], 0, '', '.') . ' US$.</font></td>
		</tr>'
                ;
            }

            ### DATOS DEL CLIENTE
            foreach ($p_datos_usuario as $rs) {
                $datos_cliente .= '<p>' . $rs['titulo'] . ' <strong> ' . $rs['dato'] . '</strong></p>';
            }

            $cuerpo = '
			<html>
			<head>
			<style type="text/css">
			body{ font-family:Arial, Helvetica, sans-serif; font-size:12px}
			h1{ margin:0; font-size:18px}
			h2{ margin:0; font-size:15px}
			table{ border:none;}
			table table{ border-style:solid; border-width:1px; border-color:#000;}
			table table td{border-style:solid; border-width:1px; border-color:#000;}
			</style>
			</head>
			<body>
				<table width="700px" align="center" cellspacing="7">
				<tr>
                                    <td colspan="5" align="left">
                                       <p>FECHA: <strong>' . date('d-m-Y h:i:s') . '</strong></p>
                                       ' . $datos_cliente . '
                                    </td>
                                    
				</tr>
				<td colspan="5">
					<table width="100%" cellpadding="5" cellspacing="0">
					  <tr>
					   <td width="10%"><strong>Codigo</strong></td>
						<td width="20%"><strong>Producto</strong></td>
						<td width="20%"><strong>Cantidad</strong></td>
						<td width="20%"><strong>Precio</strong></td>
						<td width="20%"><strong>Subtotal</strong></td>
					  </tr>
					  ' . $tr_productos . '
					   <tr>
						<td colspan="4"><h3>TOTAL:</h3></td>
						<td><h5>' . number_format($Sumatotal, 0, '', '.') . ' US$.</h5></td>
					  </tr>
					</table>
				</td>
			  </tr>
			  
			  <tr>
				<td colspan="4">
					<strong>Cordiales saludos, </strong><br>
					<strong>' . $_SERVER['SERVER_NAME'] . '/</strong><br />
					<strong>Todos los Derechos Reservados </strong><br>
				</td>
			  </tr>
			</table>
			</body>
			</html>'
            ;

            ####### ENVIA EMAIL CARRITO	
            $mail = new PHPMailer();
            $mail->SMTPAuth = false;
            $mail->AddAddress($p_correo_destinatario);
            if ($p_correo_copia) {
                $mail->AddBCC($p_correo_copia);
            }
            $mail->From = $p_from;
            $mail->FromName = $p_from_name;
            $mail->Subject = 'Carrito de Pedidos';
            $mail->IsHTML(true);
            $mail->Body = $cuerpo;
            $mail->Send();
            $mail->ClearAddresses();
            
            $_respuesta = array('success'=>true,'message'=>"Transacción completada con exito.");
            return $_respuesta;
            
        } else {
            $_respuesta = array('success'=>false,'message'=>"Ocurrio un error inesperado. Comuniquese con el Centro de Atención al cliente para verificar su compra (En Paraguay: 595 21 289-1000, En Argentina 54 11 4311-7666)");
            return $_respuesta;     
        }
    }
    
    /**
      Definimos la forma de lectura que daremos a los datos en bancard.
     */
    public static function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}

?>
