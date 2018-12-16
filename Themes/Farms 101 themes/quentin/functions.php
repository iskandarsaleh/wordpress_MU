<?php

$themecolors = array(
	'bg' => 'f2e2c1',
	'border' => 'f2e2c1',
	'text' => '000000',
	'link' => '5b211a'
);

function quentin_widgets_init() {
	register_sidebars(1);
	register_sidebar_widget(__('Calendar'), 'widget_quentin_calendar', null, 'calendar');
	register_sidebar_widget(__('Search'), 'widget_quentin_search', null, 'search');
	unregister_widget_control('calendar');
	unregister_widget_control('search');
}
add_action('widgets_init', 'quentin_widgets_init');

function widget_quentin_calendar() {
?>
<li id="calendar">
	<?php get_calendar(); ?>
</li>
<?php
}

function widget_quentin_search() {
?>
<li id="search">
<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
<input type="text" name="s" id="s" size="8" /> <input type="submit" name="submit" value="<?php _e('Search'); ?>" id="sub" />
</form>
</li>
<?php
}

?>
