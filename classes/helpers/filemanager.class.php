<?php

class FileManager {

    protected static $_ultimo_error = '';

    /**
     * Recupera el ultimo mensaje de error capturado en la clase.
     * El texto no contiene información técnica del error, su finalidad es informar al usuario la causa por la cual no se pudo subir su archivo.
     */
    public function get_ultimo_error() {
        return self::$_ultimo_error;
    }

    public static function copiaImagenDesdeURL($p_url, $p_carpeta = '', $p_nombre_archivo = '', $p_opciones = array()) {

        $acrhivo_guardado = false;

        if ($p_url != '') {
            
            $ext = substr($p_url, strrpos($p_url, '.'));
            $directorio_upload = CONF_ABS_UPLOAD_PATH . '/' . $p_carpeta;
            
            $lfile = fopen($directorio_upload . '/' . $p_nombre_archivo . $ext, "w");

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $p_url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)');
            curl_setopt($ch, CURLOPT_FILE, $lfile);
            
            curl_exec($ch);

            fclose($lfile);
            
            curl_close($ch);
           
            $handle = new upload($directorio_upload . '/' . $p_nombre_archivo . $ext);

            $size = getimagesize($directorio_upload . '/' . $p_nombre_archivo . $ext);

            foreach ($p_opciones as $key => $rs) {

                if ($handle->uploaded) {
                    if($key != '')
                        $handle->file_new_name_body = $key . '_' . $p_nombre_archivo;
                    else
                        $handle->file_new_name_body = $p_nombre_archivo;
                    
                    $handle->file_overwrite = true;
                    $handle->file_new_name_ext = "jpg";
                    $handle->image_ratio = true;
                    $handle->image_resize = true;

                    if (!empty($rs['w'])) {
                        $x = $rs['w'] > $size[0] ? $size[0] : $rs['w'];
                        $handle->image_x = $x;
                    } else {
                        $handle->image_ratio_x = true;
                    }

                    if (!empty($rs['h'])) {
                        $y = $rs['h'] > $size[1] ? $size[1] : $rs['h'];
                        $handle->image_y = $y;
                    } else {
                        $handle->image_ratio_y = true;
                    }

                    if (!empty($rs['crop'])) {
                        $handle->image_ratio_crop = true;
                    } else {
                        if (!empty($rs['fill'])) {
                            $handle->image_background_color = $rs['fill'];
                            $handle->image_ratio_fill = true;
                        }
                    }

                    $handle->process($directorio_upload);

                    if ($handle->processed) {
                        $acrhivo_guardado = true;
                    } else {
                        self::$_ultimo_error = $handle->error;
                    }
                }
            }
        } else {
            self::$_ultimo_error = 'No se recibió ningun archivo.';
        }

        return $acrhivo_guardado;
    }
    
    
    /**
     * Copia imagenes en el servidor. Se genera una imagen por cada grupo de opciones existentes en el parametro "$p_opciones", anteponiendo el key como nombre de archivo
     * @param posted_file $p_archivo Archivo adjunto.
     * @param string $p_caperta Carpeta donde se van a guardar los archivos.
     * @param string $p_nombre_archivo Nombre con el cual se va a guardar el archivo.
     * @param array $p_opciones Opciones que indican si la imagen tiene que modificarse al momento de guardar.<br />
     * Lista de opciones que se pueden utilizar:
     * <ul>
     * <li>w: (int) Ancho de la imagen. Por defecto se utiliza el tamaño original.</li>
     * <li>h: (int) Alto de la imagen. Por defecto se utiliza el tamaño original.</li>
     * <li>crop: (boolean) Cortar la imagen si sobrepasa las dimensiones.</li>
     * <li>fill: (string) Color con el cual se rellena la imagen en caso de se que la imagen sea de menores dimensiones que el "w" y "h".</li>
     * </ul>
     * @return boolean True cuando el archivo se guardó con éxito. Si la respuesa es False, el motivo se puede recuperar mediante la propiedad "get_ultimo_error()"
     */
    public static function subeImagen($p_archivo, $p_carpeta = '', $p_nombre_archivo = '', $p_opciones = array()) {

        $acrhivo_guardado = false;
		
        if ((!empty($p_archivo['name'])) && is_uploaded_file($p_archivo['tmp_name'])) {

			if(!preg_match('/' . CONF_UPLOAD_ALLOWED_IMAGES . '/', $p_archivo['type'])){
				self::$_ultimo_error = 'Tipo de imagen no permitido ' . $p_archivo['type'];
				return false;
			}
		
            $directorio_upload = CONF_ABS_UPLOAD_PATH . '/' . $p_carpeta;

            $handle = new upload($p_archivo);

            $size = getimagesize($p_archivo['tmp_name']);

            foreach ($p_opciones as $key => $rs) {

                if ($handle->uploaded) {
                    if($key != '')
                        $handle->file_new_name_body = $key . '_' . $p_nombre_archivo;
                    else
                        $handle->file_new_name_body = $p_nombre_archivo;
                    
                    $handle->image_ratio = true;
                    $handle->image_resize = true;

                    if (!empty($rs['w'])) {
                        $x = $rs['w'] > $size[0] ? $size[0] : $rs['w'];
                        $handle->image_x = $x;
                    } else {
                        $handle->image_ratio_x = true;
                    }

                    if (!empty($rs['h'])) {
                        $y = $rs['h'] > $size[1] ? $size[1] : $rs['h'];
                        $handle->image_y = $y;
                    } else {
                        $handle->image_ratio_y = true;
                    }

                    if (!empty($rs['crop'])) {
                        $handle->image_ratio_crop = true;
                    } else {
                        if (!empty($rs['fill'])) {
                            $handle->image_background_color = $rs['fill'];
                            $handle->image_ratio_fill = true;
                        }
                    }

                    $handle->process($directorio_upload);

                    if ($handle->processed) {
                        $acrhivo_guardado = true;
                    } else {
                        self::$_ultimo_error = $handle->error;
                    }
                }
            }
        } else {
            self::$_ultimo_error = 'No se recibió ningun archivo.';
        }
		
        return $acrhivo_guardado;
    }

    /**
     * Copia archivos al servidor.
     * @param string $p_archivo Archivo adjunto que se va a copiar.
     * @param posted_file $p_carpeta Nombre de la carpeta donde se va a guardar el arvchivo
     * @param string $p_nombre Nombre del archivo. Por defecto se utiliza la fecha y hora como nombre de archivo. 
     * @return boolean True cuando el archivo se guardó con éxito. Si la respuesa es False, el motivo se puede recuperar mediante la propiedad "get_ultimo_error()"
     */
    public static function subeArchivo($p_archivo, $p_carpeta = '', $p_nombre = '') {
        
		$acrhivo_guardado = false;
		
        if (!empty($p_archivo['name'])) {
		
			if(!preg_match('/' . CONF_UPLOAD_ALLOWED_FILES . '/', $p_archivo['type'])){
				self::$_ultimo_error = 'Tipo de archivo no permitido ' . $p_archivo['type'];
				return false;
			}
			
            $directorio_upload = CONF_ABS_UPLOAD_PATH . '/' . $p_carpeta;
            $handle = new upload($p_archivo);
            if ($handle->uploaded) {
                $handle->file_new_name_body = $p_nombre;
                $handle->process($directorio_upload);
                if ($handle->processed)
                    $acrhivo_guardado = true;
                else
                    self::$_ultimo_error = $handle->error;
            }
        }
        return $acrhivo_guardado;
    }

}

?>
