<?php
require_once('../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;

foreach ($options as $value) {
	if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>

body {
font-family: <?php echo $tn_wpmu_tri_body_font; ?>!important;
color: <?php echo $tn_wpmu_tri_body_font_colour; ?>!important;
background: <?php if($tn_wpmu_tri_bg_colour == ""){ ?><?php echo "#E4E4E4"; } else { ?><?php echo $tn_wpmu_tri_bg_colour; ?><?php } ?><?php if($tn_wpmu_tri_bg_image == "") { ?><?php } else { ?> url(<?php echo $tn_wpmu_tri_bg_image; ?>)<?php } ?> <?php echo $tn_wpmu_tri_bg_image_repeat; ?> <?php echo $tn_wpmu_tri_bg_image_attachment; ?> <?php echo $tn_wpmu_tri_bg_image_horizontal; ?> <?php echo $tn_wpmu_tri_bg_image_vertical; ?>!important;
!important;
}

h1, h2, h3, h4, h5, h6 {
font-family: <?php echo $tn_wpmu_tri_headline_font; ?>!important;
}

<?php if(($tn_wpmu_tri_font_size == "normal") || ($tn_wpmu_tri_font_size == "")) { ?>
#wrapper { font-size: 0.785em; }
<?php } elseif ($tn_wpmu_tri_font_size == "small") { ?>
#wrapper { font-size: 0.6875em; }
<?php } elseif ($tn_wpmu_tri_font_size == "bigger") { ?>
#wrapper { font-size: 0.85em; }
<?php } elseif ($tn_wpmu_tri_font_size == "largest") { ?>
#wrapper { font-size: 0.9125em; }
<?php } ?>

#content a, #top-header a {
<?php if($tn_wpmu_tri_content_link_colour == "") { ?>
<?php } else { ?>
color: <?php echo $tn_wpmu_tri_content_link_colour; ?>!important;
<?php } ?>
}

#container h1.post-title a:hover, #content a:hover, #top-header a:hover {
<?php if($tn_wpmu_tri_content_link_hover_colour == "") { ?>
<?php } else { ?>
color: <?php echo $tn_wpmu_tri_content_link_hover_colour; ?>!important;
<?php } ?>
}

.post-content blockquote {
border-left: 5px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

<?php if($tn_wpmu_tri_content_line_colour == "") { ?>

<?php } else { ?>

.wp-caption {
background-color: <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

#center-box {
	border-right: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
	border-left: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}
#tab-content {
border-right: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

#post-entry {
border-right: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

.post, .page, ol.pinglist li a, ol.pinglist li a:hover, #commentpost h4 {
	border-bottom: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

ol.commentlist li div.reply a, ol.commentlist li div.reply a:hover {
background: <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
color: #FFF!important;
text-decoration: none!important;
}

#cf {
background: <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

#bottom-content {
	border-top: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

.com, .com-alt {
	border-bottom: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

.com-avatar img, ol.commentlist li {
	border: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

.list .textf {
	border-top: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
	border-right: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
	border-bottom: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
	border-left: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

#bottom-content .tabbertab .feed-pull {
	border: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}

#bottom-content .tabbertab .list {
	border: 1px solid <?php echo $tn_wpmu_tri_content_line_colour; ?>!important;
}
<?php } ?>



#container {
<?php if($tn_wpmu_tri_container_colour == "") { ?>
<?php } else { ?>
background: <?php echo $tn_wpmu_tri_container_colour; ?>!important;
<?php } ?>
}

#footer {
<?php if($tn_wpmu_tri_nv_footer_colour == "") { ?>
<?php } else { ?>
background: <?php echo $tn_wpmu_tri_nv_footer_colour; ?>!important;
<?php } ?>
}


<?php if($tn_wpmu_tri_nv_footer_colour == "") { ?>
<?php } else { ?>
#bottom-content .tabbernav li a:hover {
background: <?php echo $tn_wpmu_tri_nv_footer_colour; ?>!important;
}
<?php } ?>

<?php if($tn_wpmu_tri_nv_footer_colour == "") { ?>
<?php } else { ?>
#bottom-content .tabbernav li.tabberactive a {
background: <?php echo $tn_wpmu_tri_nv_footer_colour; ?>!important;
}
<?php } ?>



#navigation {
<?php if($tn_wpmu_tri_nv_footer_colour == "") { ?>
<?php } else { ?>
background: <?php echo $tn_wpmu_tri_nv_footer_colour; ?>!important;
<?php } ?>
}


#custom-img-header {
<?php if($tn_wpmu_tri_image_height == "") { ?>
<?php } else { ?>
height: <?php echo $tn_wpmu_tri_image_height; ?>px!important;
<?php } ?>
}

#container h1.post-title a {
color: <?php echo $tn_wpmu_tri_post_title_link_colour; ?>!important;
}