<?php

/*
Adapted from Ryan Boren's skin switcher.
http://boren.nu/
*/

function skinner_set_skin_cookie() {
	$expire = time() + 30000000;
	if (!empty($_GET["wpskin"])) {
		setcookie("wpskin" . COOKIEHASH,
							stripslashes($_GET["wpskin"]),
							$expire,
							COOKIEPATH
							);

		wp_redirect( $_SERVER[ 'HTTP_REFERER'] );
		exit;
	}
}

function skinner_get_selected_skin() {
	if (!empty($_COOKIE["wpskin" . COOKIEHASH])) {
		$skin = $_COOKIE["wpskin" . COOKIEHASH];
	}	else {
		return null;
	}
	$skins = get_skins();
	if( isset( $skins[ $skin ] ) ) {
		return $skins[ $skin ]['Stylesheet'];
	}
	return null;
}


function skinner_skin_switcher($style = "text") {
	$skins = get_skins();

	$default_skin = get_current_skin();

	if (count($skins) > 1) {
		$skin_names = array_keys($skins);
		natcasesort($skin_names);

		$ts = '<ul id="skinswitcher">'."\n";		

		if ($style == 'dropdown') {
			$ts .= '<li>'."\n"
				. '	<select name="skinswitcher" onchange="location.href=\''.get_settings('home').'/index.php?wpskin=\' + this.options[this.selectedIndex].value;">'."\n"	;

			foreach ($skin_names as $skin_name) {
				// Skip unpublished skins.
				if (isset($skins[$skin_name]['Status']) && $skins[$skin_name]['Status'] != 'publish')
					continue;
					
				if ((!empty($_COOKIE["wpskin" . COOKIEHASH]) && $_COOKIE["wpskin" . COOKIEHASH] == $skin_name)
						|| (empty($_COOKIE["wpskin" . COOKIEHASH]) && ($skin_name == $default_skin))) {
					$ts .= '		<option value="'.$skin_name.'" selected="selected">'
						. htmlspecialchars($skin_name)
						. '</option>'."\n"
						;
				}	else {
					$ts .= '		<option value="'.$skin_name.'">'
						. htmlspecialchars($skin_name)
						. '</option>'."\n"
						;
				}				
			}
			$ts .= '	</select>'."\n"
				. '</li>'."\n"
				;
		}	else {
			foreach ($skin_names as $skin_name) {
				// Skip unpublished skins.
				if (isset($skins[$skin_name]['Status']) && $skins[$skin_name]['Status'] != 'publish')
					continue;

				$display = htmlspecialchars($skin_name);
				
				if ((!empty($_COOKIE["wpskin" . COOKIEHASH]) && $_COOKIE["wpskin" . COOKIEHASH] == $skin_name)
						|| (empty($_COOKIE["wpskin" . COOKIEHASH]) && ($skin_name == $default_skin))) {
					$ts .= '	<li>'.$display.'</li>'."\n";
				}	else {
					$ts .= '	<li><a href="'
						.get_settings('home').'/'. 'index.php'
						.'?wpskin='.urlencode($skin_name).'">'
						.$display.'</a></li>'."\n";
				}
			}
		}
		$ts .= '</ul>';
	}

	echo $ts;
}

add_action('init', 'skinner_set_skin_cookie');

function skinner_widget_skin_switcher($args) {
	extract($args);
	echo $before_widget;
	echo $before_title;
	echo "Skins";
	echo $after_title;
	skinner_skin_switcher();
	echo $after_widget;
}

function skinner_register_widget() {
	if ( function_exists('register_sidebar_widget') ) {
		register_sidebar_widget('Skin Switcher', 'skinner_widget_skin_switcher');
	}
}	

add_action('widgets_init', 'skinner_register_widget');

