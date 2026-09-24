<?php
/**
 * Maneja los videos
 */
class VideoManager {
    
    public static function getThumbFromYoutube($id_video){
        $json_data_url = "http://gdata.youtube.com/feeds/api/videos/{$id_video}?v=2&alt=jsonc";
        $json_data = json_decode(self::getFileContent($json_data_url));
        if(isset($json_data->data->thumbnail->hqDefault)){
            return $json_data->data->thumbnail->hqDefault;
        }
        return '';
    }
    
    public static function extractIdFromURL($p_url){
        $id_video = "";
        if(preg_match('/youtube+/', $p_url)){
            $qs = substr($p_url, strpos($p_url, '?') + 1);
            $propiedades = preg_split('/&/', $qs);
            foreach($propiedades as $propiedad):
                $array = preg_split('/=/',$propiedad); 
                if($array[0] == 'v'){
                    $id_video = $array[1];
                }
            endforeach;
        }
        return $id_video;
    }
    
    protected static function getFileContent($p_url){
        $archivo = fopen ($p_url, "r");
        $contenido = '';
        while (! feof ($archivo)) {
            $contenido .= fgets ($archivo);
        }
        fclose ($archivo);
        return $contenido;
    }
    
}

?>
