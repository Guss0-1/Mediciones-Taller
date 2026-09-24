<?php

class ImageManager {
    /*     * **********************************
     * Procesa y redimensiona imagenes   *
     * Luis Portillo - Noviembre de 2010 *
     * *********************************** */

    private $_Width = 0;
    private $_Height = 0;
    private $_SourcePath;
    private $_SourceFile;
    private $_TargetPath;
    private $_TargetFile;
    private $_Quality;
    private $_Canvas;
    private $_Center;
    private $_Align;
    private $_OutputFormat;
    private $_Transparency = false;
    private $_TransparentColor = array(0, 0, 0);
    private $_BackgorundColor = array(0, 0, 0);

    function __Constructor() {
        
    }

    //-- convierte a numero un valor
    private function toNumber($n) {
        return is_numeric($n) ? $n : number_format($n, 0, "", "");
    }

    //-- establece el nuevo tama?o de la imagen
    public function setSize($w, $h) {

        /*
          if($this->toNumber($w) == 0 and $this->toNumber($h) == 0){
          trigger_error("SetSize :: No se acepta el valor 0 (cero) en las dimensiones", E_USER_ERROR);
          }else{
         */
        $this->_Width = $w;
        $this->_Height = $h;


        /* } */
    }

    //-- establece calidad de la imagen
    public function setQuality($q) {
        $this->_Quality = $this->toNumber($q);
    }

    //-- establece directorio de origen
    public function setSource($s) {
        $this->_SourcePath = $s;
    }

    //-- directorio de destino de la imagen
    public function setTarget($t) {
        $this->_TargetPath = $t;
    }

    //-- devuelve el nombre del archivo de salida
    public function getOutputFileName() {
        return $this->_TargetFile . "." . strtolower($this->_OutputFormat);
    }

    //-- formato del archivo final JPG|PNG|GIF

    public function setOutputFormat($f) {
        $formats = array("JPEG", "JPG", "PNG", "GIF");
        if (!array_search(strtoupper($f), $formats) || strtoupper($f) == "JPEG") {
            $this->_OutputFormat = "JPG";
        } else {
            $this->_OutputFormat = strtoupper($f);
        }
    }

    //-- nombre del archivo de salida de la imagen
    public function setOutputFile($f) {
        $this->_TargetFile = $f;
    }

    function setTransparency($c, $t = true) {
        if (!is_array($c)) {
            trigger_error("SetTransparency :: El parametro de color debe ser un array :: array(R,G,B)", E_USER_ERROR);
            return false;
        } else {
            if (count($c) < 3) {
                trigger_error("SetTransparency :: Debe especificar todos los colores en el orden RGB :: array(R,G,B)", E_USER_ERROR);
                return false;
            } else {
                $this->_Transparency = true;
                $this->_TransparentColor = $c;
            }
        }
    }

    //-- fondo de la imagen
    public function setBackgroundColor($c) {
        if (!is_array($this->_BackgorundColor)) {
            trigger_error("setBackgorundColor :: El parametro de color debe ser un array :: array(R,G,B)", E_USER_ERROR);
            return false;
        } else {
            if (count($c) < 3) {
                trigger_error("SetTransparency :: Debe especificar todos los colores en el orden RGB :: array(R,G,B)", E_USER_ERROR);
                return false;
            } else {
                $this->_BackgorundColor = $c;
            }
        }
    }

    //-- establece alineamiento de la imagen
    private function Alignment($m) {

        $m = strtolower($m);
        $a = array(
            "top",
            "top_left",
            "top_middle",
            "top_center",
            "top_right",
            "middle_left",
            "middle",
            "center",
            "middle_right",
            "bottom",
            "bottom_left",
            "bottom_middle",
            "bottom_right"
        );

        if (!in_array($m, $a)) {
            trigger_error("AlignToCanvas :: Parametro de alineacion incorrecto $m", E_USER_ERROR);
            return false;
        } else {
            $this->_Align = $m;
        }
    }

    public function setAlignment($a) {
        $this->Alignment($a);
    }

    //-- crea el recurso de imagen a partir de un archivo
    private function ImageFromFile($f) {


        $ImageInfo = getimagesize($this->_SourcePath . $this->_SourceFile);

        switch ($ImageInfo['mime']) {
            case "image/bmp":
                $image = imagecreatefromwbmp($f);
                break;
            case "image/jpeg":
            case "image/pjpeg":
                $image = imagecreatefromjpeg($f);
                break;
            case "image/gif":
                $image = imagecreatefromgif($f);
                if ($this->_Transparency) {
                    $transparentColor = imagecolorallocate($image, $this->_TransparentColor[0], $this->_TransparentColor[1], $this->_TransparentColor[2]);
                    imagecolortransparent($image, $transparentColor);
                }
                break;
            case "image/png":
            case "image/x-png":
                $image = imagecreatefrompng($f);
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
            default:
                echo $this->_SourcePath . $this->_SourceFile;
                var_dump($ImageInfo);
                trigger_error("ImageFromFile :: Formato incorrecto", E_USER_ERROR);
        }

        return $image;
    }

    //-- nombre del archivo a redimensionar

    public function fileToResize($f) {
        $this->_SourceFile = $f;
    }

    //-- redimensiona la imagen
    public function Resize() {

        //if(!$this->_Width || !$this->_Height){
        //trigger_error("Resize [1] :: Debe establecer el tama�o destino", E_USER_ERROR);
        //return false;
        //}else{

        list($ImageWidth, $ImageHeight, $ImageType, $ImageAttributes) = getimagesize($this->_SourcePath . $this->_SourceFile);

        if (!$this->_SourceFile) {

            trigger_error("Resize [2] :: No se especific? el archivo a redimensionar", E_USER_ERROR);
            return false;
        } else {

            if (!$this->_Canvas) {

                //Esto es para calcular el alto si se pasa solo el parametro ancho.-
                //die("newW = ". $this->$_Width ." | newH = " . $this->_Height);

                if ($this->_Height == 0 || empty($this->_Height) || is_null($this->_Height)):
                    if ($ImageWidth < $this->_Width):
                        $this->_Height = $ImageHeight;
						
                    else:
                        $scaleheight = ($this->_Width * $ImageHeight) / $ImageWidth;
                        $this->_Height = ceil($scaleheight);
                    endif;

                endif;


                //Esto es para calcular el ancho si se pasa solo el parametro alto.-
                if ($this->_Width == 0 || empty($this->_Width) || is_null($this->_Width)):
                    if ($ImageHeight < $this->_Height):
                        $this->_Width = $ImageWidth;
                    else:
                        $scalewidth = ($this->_Height * $ImageWidth) / $ImageHeight;
                        $this->_Width = ceil($scalewidth);
                    endif;

                endif;

                //die("W=" . $this->_Width . " | H=" . $this->_Height);
				
                $NewCanvas = imagecreatetruecolor($this->_Width, $this->_Height);
                if ($this->_Transparency) {
                    /*
                      imagecolortransparent($NewCanvas, $this->_TransparentColor);
                      imagealphablending($NewCanvas, false);
                      imagesavealpha($NewCanvas, true);
                     */
                    $transparency = imagecolorallocatealpha($NewCanvas, $this->_TransparentColor[0], $this->_TransparentColor[1], $this->_TransparentColor[2], 127);
                    imagefill($NewCanvas, 0, 0, $transparency);
                    imagealphablending($NewCanvas, false);
                    imagesavealpha($NewCanvas, true);
                }
            } else {
                $NewCanvas = $this->ImageFromFile($this->_Canvas);
            }

            //--color de fondo
            if (!$this->_Transparency) {
                if ($this->_BackgorundColor[0] != 0 && $this->_BackgorundColor[1] != 1 && $this->_BackgorundColor[2] != 0) {
                    $BgColor = imagecolorallocate($NewCanvas, $this->_BackgorundColor[0], $this->_BackgorundColor[1], $this->_BackgorundColor[2]);
                    imagefilledrectangle($NewCanvas, 0, 0, $this->_Width, $this->_Height, $BgColor);
                }
            }



            $Image = $this->ImageFromFile($this->_SourcePath . $this->_SourceFile);

            /* calcula las medidas de la imagen para escalar al nuevo tama�o de forma proporcional */
            //list($ImageWidth, $ImageHeight, $ImageType, $ImageAttributes) = getimagesize($this->_SourcePath . $this->_SourceFile);


            $Scale = ($ImageWidth < $ImageHeight) ? ($this->_Height / $ImageHeight) : ($this->_Width / $ImageWidth);

            $NewWidth = ceil($ImageWidth * $Scale);
            $NewHeight = ceil($ImageHeight * $Scale);

            /* calcula nuevamente la escala cuando las nuevas proporciones exceden el tama�o final _Width o _Height */
            if ($NewWidth > $this->_Width):
                $Scale = ($this->_Width / $ImageWidth);
                $NewWidth = ceil($ImageWidth * $Scale);
                $NewHeight = ceil($ImageHeight * $Scale);
            endif;

            if ($NewHeight > $this->_Height):
                $Scale = ($this->_Height / $ImageHeight);
                $NewWidth = ceil($ImageWidth * $Scale);
                $NewHeight = ceil($ImageHeight * $Scale);
            endif;


            // -- calcula coordenadas XY segun tipo de alineacion
            switch ($this->_Align) {
                case "top":
                case "top_left":
                    $destX = 0;
                    $destY = 0;
                    break;
                case "top_center":
                case "top_middle":
                    $destX = ceil(($this->_Width / 2) - ($NewWidth / 2));
                    $destY = 0;
                    break;
                case "top_right":
                    $destX = ceil($this->_Width - $NewWidth);
                    $destY = 0;
                    break;
                case "center_left":
                case "middle_left":
                    $destX = 0;
                    $destY = ceil(($this->_Height / 2) - ($NewHeight / 2));
                    break;
                case "middle":
                case "center":
                    $destX = ceil(($this->_Width / 2) - ($NewWidth / 2));
                    $destY = ceil(($this->_Height / 2) - ($NewHeight / 2));
                    break;
                case "center_right":
                case "middle_right":
                    $destX = ceil($this->_Height - $NewWidth);
                    $destY = ceil(($this->_Height / 2) - ($NewHeight / 2));
                    break;
                case "bottom":
                case "bottom_left":
                    $destX = 0;
                    $destY = $this->_Height - $NewHeight;
                    break;
                case "bottom_center":
                case "bottom_middle":
                    $destX = ceil(($this->_Width / 2) - ($NewWidth / 2));
                    $destY = $this->_Height - $NewHeight;
                    break;
                case "bottom_right":
                    $destX = ceil($this->_Width - $NewWidth);
                    $destY = $this->_Height - $NewHeight;
                    break;
                default:
                    $destX = 0;
                    $destY = 0;
            }

            imagecopyresampled($NewCanvas, $Image, $destX, $destY, 0, 0, $NewWidth, $NewHeight, $ImageWidth, $ImageHeight);

            $this->_TargetFile = !$this->_TargetFile ? $this->_SourceFile : $this->_TargetFile;
            $this->_Quality = !$this->_Quality ? 80 : $this->_Quality;

            switch ($this->_OutputFormat) {
                case "JPG":
                case "JPEG":
                    imagejpeg($NewCanvas, $this->_TargetPath . $this->_TargetFile . "." . strtolower($this->_OutputFormat), $this->_Quality);
                    break;
                case "PNG":
                    $calidad = ceil($this->_Quality / 10);
                    imagepng($NewCanvas, $this->_TargetPath . $this->_TargetFile . "." . strtolower($this->_OutputFormat), $calidad);
                    break;
                case "GIF":
                    imagegif($NewCanvas, $this->_TargetFile . $this->_TargetFile . "." . strtolower($this->_OutputFormat));
                    break;
            }

            imagedestroy($NewCanvas);
            imagedestroy($Image);
        }
    }

    //}
}

?>