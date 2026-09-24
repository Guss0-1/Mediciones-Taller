<?php

class TextHelper {

	public static function roundUp($num, $divisor) {
		$diff = $num % $divisor;
		if ($diff == 0)
		return $num;
		else
		return $num - $diff + $divisor;
	}
	
	
	public static function HoraHace($fecha_unix){
        
        $curr = time();
		$date = strtotime($fecha_unix);
		$diff = $curr - $date;
		$diff_dd = floor($diff / 86400);
		$diff %= 86400;
		$diff_hh = floor($diff / 3600);
		$diff %= 3600;
		$diff_mm = floor($diff / 60);
		$diff %= 60;
		$diff_ss = $diff;
		
		if($diff_dd>0){
			$diferencia .= abs($diff_dd)." dias ";
		}
		
		if($diff_hh>0){
			$diferencia .= abs($diff_hh)." hs ";
		}
		
		$diferencia .= abs($diff_mm)." Min ";
		$diferencia .= abs($diff_ss)." Seg ";
        
        return $diferencia;
	}

    public static function truncate($p_texto, $p_longitud, $p_corta_en_espacio = true, $p_agregar_puntos = true) {
		$p_texto = strip_tags($p_texto);
        if (strlen($p_texto) < $p_longitud) {
            return $p_texto;
        }
        $texto = trim(substr($p_texto, 0, $p_longitud));
        if ($p_corta_en_espacio) {
            $posicion_espacio = strrpos($texto, ' ');
            if ($posicion_espacio !== false) {
                $texto = substr($texto, 0, $posicion_espacio);
            }
        }       
        if($p_agregar_puntos){
            $texto .= "...";
        }
        return $texto;
    }
	
	public static function getip(){
		
		if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' )
	   {
		  $client_ip = 
			 ( !empty($_SERVER['REMOTE_ADDR']) ) ? 
				$_SERVER['REMOTE_ADDR'] 
				: 
				( ( !empty($_ENV['REMOTE_ADDR']) ) ? 
				   $_ENV['REMOTE_ADDR'] 
				   : 
				   "unknown" );
	 
		  $entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);
	 
		  reset($entries);
		  while (list(, $entry) = each($entries)) 
		  {
			 $entry = trim($entry);
			 if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
			 {

				$private_ip = array(
					  '/^0\./', 
					  '/^127\.0\.0\.1/', 
					  '/^192\.168\..*/', 
					  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', 
					  '/^10\..*/');
	 
				$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
	 
				if ($client_ip != $found_ip)
				{
				   $client_ip = $found_ip;
				   break;
				}
			 }
		  }
	   }
	   else
	   {
		  $client_ip = 
			 ( !empty($_SERVER['REMOTE_ADDR']) ) ? 
				$_SERVER['REMOTE_ADDR'] 
				: 
				( ( !empty($_ENV['REMOTE_ADDR']) ) ? 
				   $_ENV['REMOTE_ADDR'] 
				   : 
				   "unknown" );
	   }
	 
	   return $client_ip;
	}
	
	public static function urlString($p_texto) {
		$originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
    $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$p_texto = utf8_decode($p_texto);
		$p_texto = strtr($p_texto, utf8_decode($originales), $modificadas);
		$p_texto = utf8_encode($p_texto);
		$p_texto = str_replace(array(" ","/","\\"),"-",$p_texto);
		$p_texto = strtolower($p_texto);
        return $p_texto; 
    }
	
	public static function cleanNumber($p_texto) {
		
		$filtrar = array("alert","onclick","ondblclick","onmousedown","onmouseup","onmouseover","onmousemove","onmouseout","onkeypress","onkeydown","onkeyup","onload","class","id","src","style","prompt");
		
		$p_texto = str_replace($filtrar,"",$p_texto);
		$p_texto = addslashes($p_texto);
		$p_texto = htmlentities($p_texto);
		$p_texto = strip_tags($p_texto);
		$p_texto = number_format($p_texto,0,"","");
        return $p_texto; 
    }
	
	public static function cleanString($p_texto) {
		
		$filtrar = array("alert","onclick","ondblclick","onmousedown","onmouseup","onmouseover","onmousemove","onmouseout","onkeypress","onkeydown","onkeyup","onload","class","id","src","style","prompt");
		
		$p_texto = str_replace($filtrar,"",$p_texto);
		//$p_texto = addslashes($p_texto);
		$p_texto = htmlentities($p_texto);
		$p_texto = strip_tags($p_texto);
        return $p_texto; 
    }
    
    public static function convertToHtmlParragraphs($p_texto){
        $texto = '';
        $parrafos = preg_split('/\r\n/', $p_texto);
        foreach ($parrafos as $parrafo):
            if(strlen(trim($parrafo)) > 0){
                $texto .= '<p>' . $parrafo . '</p>';
            }
        endforeach;
        return $texto;
    }
    
    public static $dias_semana = array('1'=>'Lunes', '2'=>'Martes', '3'=>'Miercoles', '4'=>'Jueves', '5'=>'Viernes', '6' => 'Sabado', '0'=>'Domingo');
    public static $meses = array('1'=>'Enero','2'=>'Febrero','3'=>'Marzo','4'=>'Abril','5'=>'Mayo','6' => 'Junio', '7'=>'Julio', '8'=>'Agosto', '9'=>'Setiembre', '10'=>'Octubre', '11'=>'Noviembre', '12'=>'Diciembre');
    
    public static function convertToLongDate($p_fecha){
        $str_fecha = '';
        
        $fecha = strtotime($p_fecha);
        $str_fecha = self::$dias_semana[date('w', $fecha)];
        $str_fecha.= ', ';
        $str_fecha.= date('d',$fecha);
        $str_fecha.= ' de ';
        $str_fecha.= strtolower(self::$meses[intval(date('m',$fecha))]);
        $str_fecha.= ' del ' . date('Y', $fecha);
        
        return $str_fecha;
    }

}

?>
