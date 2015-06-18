<?php

/**
 * Scripts
 */
 
function shortcode_gmap( $atts ) {
	
	global $add_the_googlemap;
	$add_the_googlemap = true;
	
	extract( shortcode_atts( array(
		'maptype' 	=> 'roadmap',  	// hybrid, satellite, roadmap, terrain
		'zoom'		=> 14,			// 1-19
		'address'	=> '',			// Ex: 6921 Brayton Drive, Anchorage, Alaska
		'html'		=> '',			// Will default to Address if left empty
		'popup'		=> 'true',		// true/false
		'width'		=> '',			// Leave blank for 100%, need to use 'px' or '%'
		'height'	=> '250px'		// Need to use 'px' or '%'
	), $atts ) );
	
	// Map type
	$maptype = strtoupper( $maptype );
	
	// HTML
	if( !$html )
	 $html = $address;
		
	// Width/Height
	if( $height=="" ) { 
		$height="250px";
	}
		
		$styles = 'height:'.$height;
	
	if( $width )
		$styles .= ';width:'.$width;
	
	// Unique ID
	$id = rand();
	
	// Start output
	//ob_start();
	
	return '<script type="text/javascript" data-me="gmap">
		jQuery(document).ready(function($) {
			setTimeout(function(){
				jQuery("#tb_gmap_'. $id .'").gMap({
					maptype: "'. $maptype .'",
					zoom: '. $zoom .',
					markers: [
						{
							address: "'. $address .'",
							popup: '. $popup .',
							html: "'. $html .'"
						}
					],
					controls: {
						panControl: true,
						zoomControl: true,
						mapTypeControl: true,
						scaleControl: true,
						streetViewControl: false,
						overviewMapControl: false
					}
				});
			},100);
		});
	</script>
	
	<div id="tb_gmap_'. $id .'" class="get-gmap" style="'.$styles.'"></div>';
	
	//return ob_get_clean();
}

add_shortcode( 'md_google_map', 'shortcode_gmap' );