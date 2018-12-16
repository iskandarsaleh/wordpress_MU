<?php
require_once('../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;

foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

body {
font-family: <?php echo $tn_wpmu_body_font; ?>!important;
color: <?php echo $tn_wpmu_body_font_colour; ?>!important;
background: <?php if($tn_wpmu_bg_colour == ""){ ?><?php echo "#E4E4E4"; } else { ?><?php echo $tn_wpmu_bg_colour; ?><?php } ?><?php if($tn_wpmu_bg_image == "") { ?><?php } else { ?> url(<?php echo $tn_wpmu_bg_image; ?>)<?php } ?> <?php echo $tn_wpmu_bg_image_repeat; ?> <?php echo $tn_wpmu_bg_image_attachment; ?> <?php echo $tn_wpmu_bg_image_horizontal; ?> <?php echo $tn_wpmu_bg_image_vertical; ?>!important;
}

h1, h2, h3, h4, h5, h6 {
font-family: <?php echo $tn_wpmu_headline_font; ?>!important;
}

<?php if(($tn_wpmu_font_size == "normal") || ($tn_wpmu_font_size == "")) { ?>
#wrapper { font-size: 0.785em; }
<?php } elseif ($tn_wpmu_font_size == "small") { ?>
#wrapper { font-size: 0.6875em; }
<?php } elseif ($tn_wpmu_font_size == "bigger") { ?>
#wrapper { font-size: 0.85em; }
<?php } elseif ($tn_wpmu_font_size == "largest") { ?>
#wrapper { font-size: 0.9125em; }
<?php } ?>

ol.pinglist li a, h1.post-title a, .post a, .page a, #sidebar a, #cf a, ol.commentlist a, .site-title h1 a, #post-navigator-single a, #top-right-widget a, #top-content a, #bottom-content a {
<?php if($tn_wpmu_content_link_colour == "") { ?>
<?php } else { ?>
color: <?php echo $tn_wpmu_content_link_colour; ?>!important;
<?php } ?>
}

ol.pinglist li a:hover, #container h1.post-title a:hover, .post a:hover, .page a:hover, #sidebar a:hover, #cf a:hover, #commentpost a:hover, .site-title h1 a:hover, #post-navigator-single a:hover, #top-right-widget a:hover, #top-content a:hover, #bottom-content a:hover {
<?php if($tn_wpmu_content_link_hover_colour == "") { ?>
<?php } else { ?>
color: <?php echo $tn_wpmu_content_link_hover_colour; ?>!important;
<?php } ?>
}



<?php if($tn_wpmu_content_line_colour == "") { ?>

<?php } else { ?>

.introbox {
	border-right: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

.post-content blockquote {
border-left: 5px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

.wp-caption {
background-color: <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

ul.list h3 {
	border-bottom: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

#box2 {
border-left: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
border-right: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

#commentpost h4, ol.pinglist li a {
border-bottom: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

#cf {
background: <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

ol.commentlist li {
	border:  1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
    background: <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

#post-entry {
border-right: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

.post, .page {
	border-bottom: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

#bottom-content {
	border-top: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

.com, .com-alt {
	border-bottom: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}

.com-avatar img {
	border: 1px solid <?php echo $tn_wpmu_content_line_colour; ?>!important;
}
<?php } ?>



#container {
<?php if($tn_wpmu_container_colour == "") { ?>
<?php } else { ?>
background: <?php echo $tn_wpmu_container_colour; ?>!important;
<?php } ?>
}

#container h1.post-title a {
color: <?php echo $tn_wpmu_post_title_link_colour; ?>!important;
}

#footer {
<?php if($tn_wpmu_nv_footer_colour == "") { ?>
<?php } else { ?>
background: <?php echo $tn_wpmu_nv_footer_colour; ?>!important;
<?php } ?>
}

#navigation {
<?php if($tn_wpmu_nv_footer_colour == "") { ?>
<?php } else { ?>
background: <?php echo $tn_wpmu_nv_footer_colour; ?>!important;
<?php } ?>
}



#custom-img-header {
<?php if($tn_wpmu_image_height == "") { ?>
<?php } else { ?>
height: <?php echo $tn_wpmu_image_height; ?>px!important;
<?php } ?>
}