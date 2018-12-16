<?php

$themecolors = array(
	'bg' => 'ffffff',
	'text' => '333333',
	'link' => '59708c'
);

function ocadia_widgets_init() {
	register_sidebars(1);
	register_sidebar_widget(__('Search'), 'ocadia_search', null, 'search');
	unregister_widget_control('search');
}
add_action('widgets_init', 'ocadia_widgets_init');

function ocadia_search() {
?>
<li>
	<form id="searchform" method="get" action="<?php bloginfo('url'); ?>">
	<h2>Search:</h2>
	<p style="margin-left:15px;"><input type="text" class="input" name="s" id="search" size="15" />
	<input name="submit" type="submit" tabindex="5" value="<?php _e('GO'); ?>" /></p>
	</form>
</li>
<?php
}

?>
