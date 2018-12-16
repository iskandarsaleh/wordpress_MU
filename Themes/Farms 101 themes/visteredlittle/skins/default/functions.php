<?php

if( function_exists( 'presentationtoolkit' ) ) {
	$options = array();
	$options['width'] = __('Width', VL_DOMAIN ) 
		. ' {radio|narrow|' 
		. __('Narrow', VL_DOMAIN ) 
		. '|wide|' 
		. __('Wide', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN ) 
		. ')|flex|' 
		. __('Flex', VL_DOMAIN ) 
		. '} ## ' 
		. __('Select the page width.', VL_DOMAIN );
	$options['tone'] = __('Tone', VL_DOMAIN ) 
		. ' {radio|dark|' 
		. __('Dark', VL_DOMAIN ) 
		. ' (' 
		. __('default', VL_DOMAIN ) 
		. ')|light|' 
		. __('Light', VL_DOMAIN ) 
		. '} ## ' 
		. __('Select the tone.', VL_DOMAIN );
	presentationtoolkit( $options, __FILE__ );
}

?>