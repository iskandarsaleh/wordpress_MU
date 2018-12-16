<?php
require_once('../../../wp-config.php');
require_once( dirname(__FILE__) . '/functions.php');
header("Content-type: text/css");

global $options;
foreach ($options as $value) {
if (get_settings( $value['id'] ) === FALSE) { $$value['id'] = $value['std']; } else { $$value['id'] = get_settings( $value['id'] ); } }
?>


body {
font-family: <?php echo $tn_edus_body_font; ?>!important;
}

h1, h2, h3, h4, h5, h6 {
font-family: <?php echo $tn_edus_headline_font; ?>!important;
}


<?php if(($tn_edus_font_size == "normal") || ($tn_edus_font_size == "")) { ?>
#edubody { font-size: 0.75em; }
<?php } elseif ($tn_edus_font_size == "small") { ?>
#edubody { font-size: 0.6875em; }
<?php } elseif ($tn_edus_font_size == "bigger") { ?>
#edubody { font-size: 0.85em; }
<?php } elseif ($tn_edus_font_size == "largest") { ?>
#edubody { font-size: 1em; }
<?php } ?>


<?php if($tn_edus_link_colour == "") { ?>
<?php } else { ?>
#container a, #edublog-free p a {
color: <?php echo $tn_edus_link_colour; ?>!important;
}
<?php } ?>


<?php if($tn_edus_pri_bg_colour == "") { ?>
<?php } else { ?>
.pg-nav li a:hover, #home a, .pg-nav li.current_page_item a, .pg-nav li.current_page_item a:hover,
#main-header-content, #top-right-panel, #footer, ul.sidebar_list li h3, #post-navigator a {
background: <?php echo $tn_edus_pri_bg_colour; ?>!important;
color: <?php echo $tn_edus_pri_text_colour; ?>!important;
}
<?php } ?>


<?php if($tn_edus_pri_text_colour == "") { ?>
<?php } else { ?>
#footer a {
color: <?php echo $tn_edus_pri_text_colour; ?>!important;
}
<?php } ?>

<?php if($tn_edus_pri_bg_border_colour == "") { ?>
<?php } else { ?>

.pg-nav li a:hover, #home a, .pg-nav li.current_page_item a, .pg-nav li.current_page_item a:hover {
border-top: 1px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
border-left: 1px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
border-right: 1px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
}

#main-header-content {
border-top: 1px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
border-bottom: 5px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
}

#top-right-panel, ul.sidebar_list li h3 {
border: 1px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
}

#footer {
border-top: 1px solid <?php echo $tn_edus_pri_bg_border_colour; ?>!important;
}
<?php } ?>


#top-right-panel {
color: <?php echo $tn_edus_pri_text_colour; ?>!important;
}

#container #top-right-panel a, #container ul.sidebar_list h3 a {
color: <?php echo $tn_edus_pri_text_colour; ?>!important;
font-weight: bold!important;
}



<?php if($tn_edus_tab_bg_colour == "") { ?>
<?php } else { ?>

#container .rss-feeds {
    color: <?php echo $tn_edus_tab_text_colour; ?>!important;
	background: <?php echo $tn_edus_tab_bg_colour; ?>!important;
	border-right: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
	border-bottom: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
	border-left: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
}

#container .feed-pull {
border-bottom: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
}


#container .rss-feeds a {
color: <?php echo $tn_edus_tab_link_colour; ?>!important;
}

#container ul.tabbernav li.tabberactive a {
    color: <?php echo $tn_edus_tab_link_colour; ?>!important;
   	background: <?php echo $tn_edus_tab_bg_colour; ?>!important;
	border-top: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
	border-right: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
	border-left: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
}

#container ul.tabbernav li a {
    color: #292929!important;
	background: #fff;
	border-top: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
	border-right: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
	border-left: 1px solid <?php echo $tn_edus_tab_border_colour; ?>!important;
}
<?php } ?>
