<?php
/**
 *  Objeto que gestiona la interfaz html de un control googlemaps
 */
class MapControl {
    
	private $_map_id = '';
	
	private $_map_width = 300;
	private $_map_height = 300;
	
	// -23.80951146578363 -57.49741718749999
	private $_lat = 0;
	private $_lng = 0;
	
	private $_lat_ctrl_id = 'lat';
	private $_lng_ctrl_id = 'lng';
	
	private $_zoom = 5;
	
	private $_readonly = false;
	
	public function get_id(){ return $this->_map_id; }
	
	public function get_lat_ctr_id(){ return $this->_lat_ctrl_id; }
	
	public function get_lng_ctrl_id(){ return $this->_lng_ctrl_id; }
	
	public function get_lng(){ return $this->_lng; }
	public function set_lng($p_lng){ $this->_lng = $p_lng; }
	
	public function get_lat(){ return $this->_lat; }
	public function set_lat($p_lat){ $this->_lat = $p_lat; }
	
	public function get_zoom(){ return $this->_zoom; }
	public function set_zoom($p_zoom){ $this->_zoom = $p_zoom; }
	
	public function is_readOnly($p_readonly){ $this->_readonly = $p_readonly; }
	
	public function __construct($p_map_id, $p_lat_ctrl_id = 'lat', $p_lng_ctrl_id = 'lng'){
		$this->_map_id = $p_map_id;
		$this->_lat_ctrl_id = $p_lat_ctrl_id;
		$this->_lng_ctrl_id = $p_lng_ctrl_id;
	}
	
	public function print_script($p_readOnly = false){
		
		$script = "";
		$script .= "var marcador_{$this->_map_id} = null; \r\n";
		$script .= "var map_{$this->_map_id} = null; \r\n";
		$script .= "var latlng_{$this->_map_id} = null; \r\n";
		
		$script .= "function initialize_{$this->_map_id}() { \r\n";
		$script .= "\t latlng_{$this->_map_id} = new google.maps.LatLng({$this->_lat}, {$this->_lng}); \r\n ";
		$script .= "\t var myOptions = { \r\n ";
		$script .= "\t\t zoom: {$this->_zoom}, \r\n ";
		$script .= "\t\t center: latlng_{$this->_map_id}, \r\n ";
		$script .= "\t\t mapTypeControl: false, \r\n ";
		$script .= "\t\t mapTypeId: google.maps.MapTypeId.ROADMAP \r\n ";
		$script .= "\t }; \r\n ";
		$script .= "\t map_{$this->_map_id} = new google.maps.Map(document.getElementById('{$this->_map_id}'), myOptions); \r\n ";
			
		// $script .= "\t google.maps.event.addListener(map, 'mousemove', function(event) { \r\n ";
		// $script .= "\t\t $('#map_info').html('Lat: ' + event.latLng.lat() + '&nbsp;-&nbsp;Lng:' + event.latLng.lng()); \r\n ";
		// $script .= "\t }); \r\n ";
		
		if(!$p_readOnly){
			$script .= "\t google.maps.event.addListener(map_{$this->_map_id}, 'click', function(event) { \r\n ";
			$script .= "\t\t if(marcador_{$this->_map_id} != null){ \r\n ";
			$script .= "\t\t\t marcador_{$this->_map_id}.setMap(null);  \r\n ";
			$script .= "\t\t } \r\n ";
			$script .= "\t\t marcador_{$this->_map_id} = new google.maps.Marker({ \r\n ";
			$script .= "\t\t\t position: event.latLng, \r\n ";
			$script .= "\t\t\t map: map_{$this->_map_id} \r\n ";
			$script .= "\t\t }); \r\n ";
			$script .= "\t\t $('#{$this->_lat_ctrl_id}').val(event.latLng.lat()); \r\n ";
			$script .= "\t\t $('#{$this->_lng_ctrl_id}').val(event.latLng.lng()) \r\n ";
			$script .= "\t }); \r\n ";
		}
		$script .= "\t } \r\n ";
		
		$script .= "\t initialize_{$this->_map_id}(); \r\n ";
		
		$script .= "\t function resize_{$this->_map_id}() { \r\n";
		$script .= "\t\t google.maps.event.trigger(map_{$this->_map_id}, 'resize'); \r\n";
		$script .= "\t\t map_{$this->_map_id}.setCenter(latlng_{$this->_map_id});  \r\n";
		$script .= "\t } \r\n";
		
		$script .= "\t function refreshMarkerPosition_{$this->_map_id}() { \r\n";
		
		$script .= "\t\t if(marcador_{$this->_map_id} != null){ \r\n ";
		$script .= "\t\t\t marcador_{$this->_map_id}.setMap(null);  \r\n ";
		$script .= "\t\t } \r\n ";

		$script .= "\t\t var re = new RegExp(/^(\-?\d*\.\d+|\d+)$/); \r\n ";
		$script .= "\t\t if(re.test($('#{$this->_lat_ctrl_id}').val()) && re.test($('#{$this->_lng_ctrl_id}').val())){ \r\n ";
		$script .= "\t\t\t latlng_{$this->_map_id} =  new google.maps.LatLng($('#{$this->_lat_ctrl_id}').val(), $('#{$this->_lng_ctrl_id}').val()); \r\n ";
		$script .= "\t\t\t marcador_{$this->_map_id} = new google.maps.Marker({ \r\n ";
		$script .= "\t\t\t\t position: latlng_{$this->_map_id}, \r\n ";
		$script .= "\t\t\t\t map: map_{$this->_map_id} \r\n ";
		$script .= "\t\t\t }); \r\n ";
		$script .= "\t\t }else{ \r\n";
		$script .= "\t\t\t latlng_{$this->_map_id} = new google.maps.LatLng({$this->_lat}, {$this->_lng}); \r\n ";
		$script .= "\t\t } \r\n";
		
		$script .= "\t\t $('#{$this->_lat_ctrl_id}').change(function(){ refreshMarkerPosition_{$this->_map_id}() }); \r\n";
		$script .= "\t\t $('#{$this->_lng_ctrl_id}').change(function(){ refreshMarkerPosition_{$this->_map_id}() }); \r\n";
		
		$script .= "\t\t\t map_{$this->_map_id}.setCenter(latlng_{$this->_map_id}); \r\n ";
		$script .= "\t } \r\n";
		
		echo $script;
	}

	public static function print_required_script(){
		$script = "<script type='text/javascript' src='http://maps.google.com/maps/api/js?sensor=false'></script>";
		echo $script;
	}
	
}

?>
