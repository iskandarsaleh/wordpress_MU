<?php
/*
Plugin Name: Ad widget lite
Plugin URI: http://incsub.com
Description: This plugin adds a simple advertisement widget with customisable display options.
Author: Barry at Clearskys.net
Version: 0.2
Author URI: http://clearskys.net
*/

// Set this to yes, to allow PHP to be entered in the code box - on your own head be it
define( 'MY_WIDGET_ADLITE_IAMAPRO', 'no');

function my_widget_adlite_is_fromsearchengine() {
	$ref = $_SERVER['HTTP_REFERER'];
	
	$SE = array('/search?', 'images.google.', 'web.info.com', 'search.', 'del.icio.us/search', 'soso.com', '/search/', '.yahoo.' );
	
	foreach ($SE as $url) {
		if (strpos($ref,$url)!==false) return true;
	}
	return false;	
}

function my_widget_adlite_is_ie()
{
    if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
        return true;
    else
        return false;
}

function my_widget_adlite_hit_selective($selectives = array()) {
	
	/*
	var $selections = array(
							"loggedin"	=>	"User isn't logged in",
							"commented"	=>	"User hasn't commented before",
							"searched"	=>	"User arrived via a search engine",
							"external"	=>	"User arrived via a link",
							"ie"		=>	"User is using Internet Explorer"
							);
	*/
	
	if(!empty($selectives)) {
		foreach($selectives as $key => $value) {
			switch($key) {
				
				case 'loggedin':	if(!is_user_logged_in()) {
										return true;
									}
									break;
				case 'commented':	if ( !isset($_COOKIE['comment_author_'.COOKIEHASH]) ) {
										return true;
									}
									break;
				case 'searched':	if(my_widget_adlite_is_fromsearchengine()) {
										return true;
									}
									break;
				case 'external':	if(!empty($_SERVER['HTTP_REFERER'])) {
										$internal = str_replace('http://','',get_option('siteurl'));
										if(!preg_match( '/' . addcslashes($internal,"/") . '/i', $_SERVER['HTTP_REFERER'] )) {
												return true;
										}
									}
									break;
				case 'ie':			if(my_widget_adlite_is_ie()) {
										return true;
									}
									break;
				case 'none':		break;
				default:
									return true;
			}
		}
		// Passed everything without a true so return false
		return false;
	} else {
		return true;
	}
	
}



function my_widget_adlite($args, $widget_args = 1) {
	
	global $my_widget_adlite_iamapro;
	
	extract( $args, EXTR_SKIP );
	if ( is_numeric($widget_args) )
		$widget_args = array( 'number' => $widget_args );
	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	extract( $widget_args, EXTR_SKIP );

	$options = get_option('widget_adlite');
	if ( !isset($options[$number]) )
		return;

	$sels = $options[$number]['adselectives'];
	$adcode = $options[$number]['adcode'];
	
	
	if(my_widget_adlite_hit_selective($sels)) {
		// Show the widget
		echo $before_widget;
 		if ( !empty( $adcode ) ) {
			if(defined('MY_WIDGET_ADLITE_IAMAPRO') && MY_WIDGET_ADLITE_IAMAPRO == 'yes') {
				eval(" ?> " . stripslashes($adcode) . " <?php ");
			} else {
				echo stripslashes($adcode);
			}
		}
		echo $after_widget;
		
	}	// End show the widget
}


function my_widget_adlite_control($widget_args) {
	global $wp_registered_widgets;
	static $updated = false;
	
	$selections = array(
							"loggedin"	=>	"User isn't logged in",
							"commented"	=>	"User hasn't commented before",
							"searched"	=>	"User arrived via a search engine",
							"external"	=>	"User arrived via a link",
							"ie"		=>	"User is using Internet Explorer"
							);

	if ( is_numeric($widget_args) )
		$widget_args = array( 'number' => $widget_args );
	$widget_args = wp_parse_args( $widget_args, array( 'number' => -1 ) );
	extract( $widget_args, EXTR_SKIP );

	$options = get_option('widget_adlite');
	if ( !is_array($options) )
		$options = array();

	if ( !$updated && !empty($_POST['sidebar']) ) {
		$sidebar = (string) $_POST['sidebar'];

		$sidebars_widgets = wp_get_sidebars_widgets();
		if ( isset($sidebars_widgets[$sidebar]) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();

		foreach ( (array) $this_sidebar as $_widget_id ) {
			if ( 'my_widget_adlite' == $wp_registered_widgets[$_widget_id]['callback'] && isset($wp_registered_widgets[$_widget_id]['params'][0]['number']) ) {
				$widget_number = $wp_registered_widgets[$_widget_id]['params'][0]['number'];
				if ( !in_array( "adlite-$widget_number", $_POST['widget-id'] ) ) // the widget has been removed.
					unset($options[$widget_number]);
			}
		}
		
		foreach ( (array) $_POST['adselectives'] as $ad_number => $ad_sels ) {
			$options[$ad_number]['adselectives'] =  $ad_sels;
		}
		
		
		foreach ( (array) $_POST['adcode'] as $ad_number => $ad_code ) {
			$options[$ad_number]['adcode'] = $ad_code;
		}

		update_option('widget_adlite', $options);
		$updated = true;
	}

	if ( -1 == $number ) {
		$ad = array();
		$number = '%i%';
	} else {
		$ad = $options[$number];
	}
?>
		<p>
			<?php _e('Show the content below if one of the checked items is true (or no items are checked):','adlite'); ?>
		</p>
		<p>
				<?php
					echo "<input type='hidden' value='1' name='adselectives[$number][none]' id='adselectives-". $number . "[none]' />";
					foreach($selections as $key => $value) {
						echo "<input type='checkbox' value='1' name='adselectives[$number][$key]' id='adselectives-". $number . "[$key]' ";
						if($ad['adselectives'][$key] == '1') echo "checked='checked' ";
						echo "/>&nbsp;" . $value . "<br/>";	
					}
				?>
		</p>
		<p>
				<?php _e('Content to display','supporter'); ?><br/>
				<textarea name='adcode[<?php echo $number; ?>]' id='adcode-<?php echo $number; ?>' rows='5' cols='40'><?php echo stripslashes($ad['adcode']); ?></textarea>
			<input type="hidden" name="widget-adlite[<?php echo $number; ?>][submit]" value="1" />
		</p>
<?php
}


function my_widget_adlite_register() {
	if ( !$options = get_option('widget_adlite') )
		$options = array();
	$widget_ops = array('classname' => 'adlite', 'description' => __('Display HTML selectively based on simple rules'));
	$control_ops = array('width' => 400, 'height' => 350, 'id_base' => 'adlite');
	$name = __('Ad lite');

	$id = false;
	foreach ( (array) array_keys($options) as $o ) {
		// Old widgets can have null values for some reason
		if ( !isset($options[$o]['adcode']))
			continue;
		$id = "adlite-$o"; // Never never never translate an id
		wp_register_sidebar_widget($id, $name, 'my_widget_adlite', $widget_ops, array( 'number' => $o ));
		wp_register_widget_control($id, $name, 'my_widget_adlite_control', $control_ops, array( 'number' => $o ));
	}

	// If there are none, we register the widget's existance with a generic template
	if ( !$id ) {
		wp_register_sidebar_widget( 'adlite-1', $name, 'my_widget_adlite', $widget_ops, array( 'number' => -1 ) );
		wp_register_widget_control( 'adlite-1', $name, 'my_widget_adlite_control', $control_ops, array( 'number' => -1 ) );
	}
}

add_action( 'widgets_init', 'my_widget_adlite_register' );


?>