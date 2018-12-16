<?php


require_once('../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');


/* only in member theme for calling functions.php
define( 'ABSPATH', dirname(__FILE__) . '/' );
$current_theme = get_current_theme();
$site_directory = ABSPATH . '/';
require_once($site_directory . 'wp-content/themes/' . $current_theme . '/functions.php');
*/

header("Content-type: text/css");



global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
// wp theme option
?>



body {
font-family: <?php echo $tn_buddyfun_body_font; ?>!important;
color: <?php echo $tn_buddyfun_body_text_color; ?>!important;
background: <?php if($tn_buddyfun_bg_color == ""){ ?><?php echo "#F5F6F5"; } else { ?><?php echo $tn_buddyfun_bg_color; ?><?php } ?><?php if($tn_buddyfun_bg_image == "") { ?><?php } else { ?> url(<?php echo $tn_buddyfun_bg_image; ?>)<?php } ?> <?php echo $tn_buddyfun_bg_image_repeat; ?> <?php echo $tn_buddyfun_bg_image_attachment; ?> <?php echo $tn_buddyfun_bg_image_horizontal; ?> <?php echo $tn_buddyfun_bg_image_vertical; ?>
!important;
}


h1, h2, h3, h4, h5, h6 {
font-family: <?php echo $tn_buddyfun_headline_font; ?>!important;
}


<?php if(($tn_buddyfun_font_size == "normal") || ($tn_buddyfun_font_size == "")) { ?>
#wrapper { font-size: 0.6875em!important; }
<?php } elseif ($tn_buddyfun_font_size == "medium") { ?>
#wrapper { font-size: 0.75em!important; }
<?php } elseif ($tn_buddyfun_font_size == "bigger") { ?>
#wrapper { font-size: 0.875em!important; }
<?php } elseif ($tn_buddyfun_font_size == "largest") { ?>
#wrapper { font-size: 1em!important; }
<?php } ?>



<?php if($tn_buddyfun_global_links == "") { ?>
<?php } else { ?>
.item-list .meta a {
color: <?php echo $tn_buddyfun_global_links; ?>!important;
}
#content a {
color: <?php echo $tn_buddyfun_global_links; ?>!important;
}
#content a:hover {
color: <?php echo $tn_buddyfun_global_hover_links; ?>!important;
}
<?php } ?>




<?php if($tn_buddyfun_content_line_bg_color == "") { ?>
<?php } else { ?>

.post-content blockquote {
	border-left: 4px solid <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}

#post-entry .item-list li, .message-box, .info-group, #post-entry h2.widgettitle, .alt-post ul li {
border-bottom: 1px solid <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}

#bottom-entry {
	border-top: 1px solid <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}
.wp-caption, ol.commentlist li, #cf {
	background: <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}
.post, .page, h2#post-header, #commentpost h4 {
	border-bottom: 1px solid <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}

div.crop-img, div.crop-preview img {
background: <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
border: 1px solid <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}


#content #post-navigator a, #setupform {
    background: <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}

ol.pinglist li {
    border-bottom: 1px solid <?php echo $tn_buddyfun_content_line_bg_color; ?>!important;
}
<?php } ?>





<?php if($tn_buddyfun_sidebar_header_text_color == "") { ?>
<?php } else { ?>
#content #post-navigator a {
	color: <?php echo $tn_buddyfun_sidebar_header_text_color; ?>!important;
}
<?php } ?>


<?php if($tn_buddyfun_post_title_links == "") { ?>
<?php } else { ?>
#container h1.post-title a {
	color: <?php echo $tn_buddyfun_post_title_links; ?>!important;
}
<?php } ?>



<?php if($tn_buddyfun_post_title_hover_links == "") { ?>
<?php } else { ?>
h1.post-title a:hover {
	color: <?php echo $tn_buddyfun_post_title_hover_links; ?>!important;
	text-decoration: underline;
}
<?php } ?>





<?php if($tn_buddyfun_sidebar_line_bg_color == "") { ?>
<?php } else { ?>
#sidebar-column .item-list li {
border-bottom: 1px solid <?php echo $tn_buddyfun_sidebar_line_bg_color; ?>!important;
}
<?php } ?>


<?php if($tn_buddyfun_sidebar_box_text_link_hover_color == "") { ?>
<?php } else { ?>
#content #sidebar-column a:hover {
color: <?php echo $tn_buddyfun_sidebar_box_text_link_hover_color; ?>!important;
}
<?php } ?>


<?php if($tn_buddyfun_sidebar_header_text_link_color == "") { ?>
<?php } else { ?>
#content #sidebar-column .widgettitle a {
	color: <?php echo $tn_buddyfun_sidebar_header_text_link_color; ?>!important;
}
<?php } ?>




#post-entry li blockquote, #sidebar-column li blockquote, .wire-post-content, .profile-fields .alt, .item-list .action .pending, .button-block .pending a, #commentpost blockquote  {
background: <?php if($tn_buddyfun_global_blockquote == ""){ ?><?php echo "#F5F6F5"; } else { ?><?php echo $tn_buddyfun_global_blockquote; ?><?php } ?>!important;
}

<?php if($tn_buddyfun_header_text_color == "") { ?>
<?php } else { ?>
.site-title, .site-title a {
color: <?php echo $tn_buddyfun_header_text_color; ?>!important;
}
<?php } ?>




<?php if($tn_buddyfun_sidebar_header_color == ""){ ?>
<?php } else { ?>
#container #call-action .call-button a {
    background: <?php echo $tn_buddyfun_sidebar_header_color; ?>!important;
	color: <?php echo $tn_buddyfun_sidebar_header_text_color; ?>!important;
}

#content ol.commentlist li div.reply a {
	background: <?php echo $tn_buddyfun_sidebar_header_color; ?>!important;
	color: <?php echo $tn_buddyfun_sidebar_header_text_color; ?>!important;
}

#content #post-navigator .current, #content .button-block a, #content .content-header li a, #content .content-header li.current a, #container .member-entry ul#letter-list li a, ul#letter-list li a:hover, #content .item-list .action a {
    background: <?php echo $tn_buddyfun_sidebar_header_color; ?>!important;
	color: <?php echo $tn_buddyfun_sidebar_header_text_color; ?>!important;
}
<?php } ?>


.time-since, .post-author, #container .alt-post small a, span.signup-description {
color: <?php if($tn_buddyfun_body_text_color == ""){ ?><?php echo "#666"; } else { ?><?php echo $tn_buddyfun_body_text_color; ?><?php } ?>!important;
}

<?php if($tn_buddyfun_topnav_block_link_color == ""){ ?>
<?php } else { ?>
ul.pagenav li a, ul.pagenav li.selected a {
    color: <?php echo $tn_buddyfun_topnav_block_link_color; ?>!important;
	background: <?php echo $tn_buddyfun_topnav_block_color; ?>!important;
}
<?php } ?>

#top-header .navigation {
	background: <?php if($tn_buddyfun_nav_bg_color == ""){ ?><?php echo "#204C6E"; } else { ?><?php echo $tn_buddyfun_nav_bg_color; ?><?php } ?> <?php if($tn_buddyfun_header_gloss_on == 'enable') { ?>url(images/gloss.png) repeat-x left -4px<?php } else { ?><?php } ?>!important;
}




<?php if($tn_buddyfun_nav_text_link_color == ""){ ?>
<?php } else { ?>
#top-header .navigation a {
	color: <?php echo $tn_buddyfun_nav_text_link_color; ?>!important;
}
#top-header .navigation a:hover {
	color: <?php echo $tn_buddyfun_nav_text_link_hover_color; ?>!important;
}
<?php } ?>



<?php if($tn_buddyfun_footer_text_color == ""){ ?>
<?php } else { ?>
#footer {
  color: <?php echo $tn_buddyfun_footer_text_color; ?>!important;
  background: <?php echo $tn_buddyfun_footer_color; ?>!important;
}
#footer a {
  color: <?php echo $tn_buddyfun_footer_text_link_color; ?>!important;
}
<?php } ?>








<?php if($tn_buddyfun_sidebar_box_color == ""){ ?>
<?php } else { ?>
#sidebar-column {
color: <?php echo $tn_buddyfun_sidebar_box_text_color; ?>!important;
background: <?php echo $tn_buddyfun_sidebar_box_color; ?>!important;
}
<?php } ?>





#sidebar-column .widgettitle {
background: <?php if($tn_buddyfun_sidebar_header_color == ""){ ?><?php echo "#204C6E"; } else { ?><?php echo $tn_buddyfun_sidebar_header_color; ?><?php } ?> <?php if($tn_buddyfun_header_gloss_on == 'enable') { ?>url(images/gloss.png) repeat-x left -8px<?php } else { ?><?php } ?>!important;
<?php if($tn_buddyfun_sidebar_header_text_color == "" ){ ?><?php } else { ?>
color: <?php echo $tn_buddyfun_sidebar_header_text_color; ?>!important;
<?php } ?>
}



<?php if( $tn_buddyfun_sidebar_box_text_link_color == ""){ ?>
<?php } else { ?>

#sidebar-column a {
  color: <?php echo $tn_buddyfun_sidebar_box_text_link_color; ?>!important;
}
<?php } ?>



<?php if( $tn_buddyfun_userbar_text_color == ""){ ?>
<?php } else { ?>
#userbar {
    color: <?php echo $tn_buddyfun_userbar_text_color; ?>!important;
	background: <?php echo $tn_buddyfun_userbar_bg_color; ?>!important;
}
#userbar a {
    color: <?php echo $tn_buddyfun_userbar_text_link_color; ?>!important;
}
<?php } ?>




<?php if($tn_buddyfun_content_bg_color == ""){ ?>
<?php } else { ?>
#post-entry {
background: <?php echo $tn_buddyfun_content_bg_color; ?>!important;
}

ul#options-nav li {
	background: <?php echo $tn_buddyfun_content_bg_color; ?> url(images/members/options.png) no-repeat 5px center!important;
}

#top-header .top-h, #call-action {
color: <?php echo $tn_buddyfun_body_text_color; ?>!important;
background: <?php echo $tn_buddyfun_content_bg_color; ?>!important;
}

<?php } ?>



<?php if($tn_buddyfun_body_text_color == ""){ ?>
<?php } else { ?>
#container #content #right-box #optionsbar #options-nav li.current a {
color: <?php echo $tn_buddyfun_body_text_color; ?>!important;
}
<?php } ?>



#header .custom-img-header {
height: <?php echo $tn_buddyfun_image_height; ?>px!important;
}
