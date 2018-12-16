<?php
require_once( dirname(__FILE__) . '../../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;

foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

body {
	font-family: <?php echo $oc_ow_body_font; ?>!important;
    font-size: <?php echo $oc_ow_global_body_font_size; ?>;
}

h1, h2, h3, h4, h5, h6 {
   font-family: <?php echo $oc_ow_headline_font; ?>!important;
}


#header-sitename {
	position: absolute;
	left: 0px;
	top: 0px;
	color: <?php echo $oc_ow_titlename_text_colour; ?>;
	padding: 10px 5px 10px 5px;
	margin: 0px;
	width: 960px;
	background: <?php echo $oc_ow_title_background_trans_colour; ?>;
	filter: Alpha(Opacity=50);
	-moz-opacity:.50;
	opacity:.50;
}

#header-sitename h1 {
	font-size: <?php echo $oc_ow_titlename_size; ?>;
	line-height: 100.01%;
	color: #FFFFFF;
	margin: 0px;
	padding: 0px 0px 0px 10px;
	float: left;
    letter-spacing: -1px;
}

<?php
$p_padding_set = $oc_ow_titlename_size/3;
?>

#header-sitename p {
	font-size: 11px;
	line-height: 16px;
	margin: 0px;
	padding: <?php echo $p_padding_set; ?>px 0px 0px 10px;
	float: left;
}
#header-sitename h1 a {
	color: <?php echo $oc_ow_titlename_sitename_colour; ?>;
	text-decoration: none;
}
