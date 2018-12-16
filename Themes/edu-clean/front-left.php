<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="front-left">
<div id="services">

<h4><?php _e('How'); ?> <?php bloginfo('name'); ?> <?php _e('Can Help You?'); ?></h4>



<div class="service-block">
<?php if(file_exists($upload_path . 'edu1_thumb.jpg')) { ?>
<img src="<?php echo "$ttpl_path/edu1_thumb.jpg"; ?>" width="200" height="100" alt="<?php echo stripslashes($tn_edus_headline1); ?>" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/default.jpg" width="200" height="100" alt="img" />
<?php } ?>
<h3><?php echo stripslashes($tn_edus_headline1); ?></h3>
<p>
<?php if($tn_edus_text1 == ""){ ?>
<?php _e('You can replace this area with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> and <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the image you can see here already.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_edus_text1); ?>
<?php }  ?>
</p>
</div>



<div class="service-block">
<?php if(file_exists($upload_path . 'edu2_thumb.jpg')) { ?>
<img src="<?php echo "$ttpl_path/edu2_thumb.jpg"; ?>" width="200" height="100" alt="<?php echo stripslashes($tn_edus_headline2); ?>" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/default.jpg" width="200" height="100" alt="img" />
<?php } ?>
<h3><?php echo stripslashes($tn_edus_headline2); ?></h3>
<p>
<?php if($tn_edus_text2 == ""){ ?>
<?php _e('You can replace this area with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> and <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the image you can see here already.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_edus_text2); ?>
<?php }  ?>
</p>
</div>


<div class="service-block">
<?php if(file_exists($upload_path . 'edu3_thumb.jpg')) { ?>
<img src="<?php echo "$ttpl_path/edu3_thumb.jpg"; ?>" width="200" height="100" alt="<?php echo stripslashes($tn_edus_headline3); ?>" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/default.jpg" width="200" height="100" alt="img" />
<?php } ?>
<h3><?php echo stripslashes($tn_edus_headline3); ?></h3>
<p>
<?php if($tn_edus_text3 == ""){ ?>
<?php _e('You can replace this area with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> and <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the image you can see here already.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_edus_text3); ?>
<?php }  ?>
</p>
</div>



<div class="service-block">
<?php if(file_exists($upload_path . 'edu4_thumb.jpg')) { ?>
<img src="<?php echo "$ttpl_path/edu4_thumb.jpg"; ?>" width="200" height="100" alt="<?php echo stripslashes($tn_edus_headline4); ?>" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/default.jpg" width="200" height="100" alt="img" />
<?php } ?>
<h3><?php echo stripslashes($tn_edus_headline4); ?></h3>
<p>
<?php if($tn_edus_text4 == ""){ ?>
<?php _e('You can replace this area with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> and <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the image you can see here already.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_edus_text4); ?>
<?php }  ?>
</p>
</div>



<div class="service-block">
<?php if(file_exists($upload_path . 'edu5_thumb.jpg')) { ?>
<img src="<?php echo "$ttpl_path/edu5_thumb.jpg"; ?>" width="200" height="100" alt="<?php echo stripslashes($tn_edus_headline5); ?>" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/default.jpg" width="200" height="100" alt="img" />
<?php } ?>
<h3><?php echo stripslashes($tn_edus_headline5); ?></h3>
<p>
<?php if($tn_edus_text5 == ""){ ?>
<?php _e('You can replace this area with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> and <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the image you can see here already.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_edus_text5); ?>
<?php }  ?>
</p>
</div>



<div class="service-block">
<?php if(file_exists($upload_path . 'edu6_thumb.jpg')) { ?>
<img src="<?php echo "$ttpl_path/edu6_thumb.jpg"; ?>" width="200" height="100" alt="<?php echo stripslashes($tn_edus_headline6); ?>" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/default.jpg" width="200" height="100" alt="img" />
<?php } ?>
<h3><?php echo stripslashes($tn_edus_headline6); ?></h3>
<p>
<?php if($tn_edus_text6 == ""){ ?>
<?php _e('You can replace this area with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> and <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the image you can see here already.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_edus_text6); ?>
<?php }  ?>
</p>
</div>




<div id="more-features"><a href="<?php bloginfo('url'); ?>/features/"><?php _e('Browse more features &raquo;'); ?></a></div>

</div>



<ul class="sidebar_list">

<li id="gravatar_comments" class="widget_gravatar_comments">
<h3><?php _e('Recent Comments'); ?></h3>
<ul>
<?php get_avatar_recent_comment(); ?>
</ul>
</li>


<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(1)) : ?>
 <!-- widgets -->
<?php endif; ?>

</ul>




<?php include (TEMPLATEPATH . '/rss-network.php'); ?>

</div>