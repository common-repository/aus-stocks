<?php
/* The function that creates the HTML on the front-end, based on the parameters */

//Basic - Price only shortcode
if ( ! function_exists( 'asx_basic' ) ) {

	function asx_basic($atts) {
		global $wpdb, $asx_code;		
		$asx_code =  get_option('asx_code');
		$market =  get_option('asx_market');
		$ASX_result = asx_xml_display_free($asx_code,$market);
		return $ASX_result['last_price'];
	
	}
	
	add_shortcode("asx_basic", "asx_basic");
}
?>