<div id="top-content">

<?php include (TEMPLATEPATH . '/options.php'); ?>

<div class="introbox">

<?php if($tn_wpmu_latest_post == "recent post") { ?>

<?php $my_query = new WP_Query('category_name=&showposts=5');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
$latest_post == 0;
?>

<?php if ($latest_post < 1) { ?>

<a href="<?php echo stripslashes($tn_wpmu_intro_header_imgurl); ?>">
<?php
if(file_exists($upload_path . 'intro_crop.jpg')) {?>
<img src="<?php echo "$ttpl_path/intro_crop.jpg"; ?>" alt="" width="350" height="250" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/cimage-intro.gif" alt="" width="350" height="250" />
<?php } ?>
</a>
<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
<p><?php the_excerpt_feature(); ?></p>

<div class="post-content">
<h3><?php _e('Other News &raquo;'); ?></h3>
<br />
<ul class="list">

<?php } else { ?>

<li>
<p style="font-size: 18px;"><strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></strong></p>
<p><?php the_excerpt(); ?></p>
</li>

<?php } ?>

<?php $latest_post++; ?>

<?php endwhile;?>

</ul>
</div>

<?php } elseif ($tn_wpmu_latest_post == "custom post") { ?>

<a href="<?php echo stripslashes($tn_wpmu_intro_header_imgurl); ?>">
<?php
if(file_exists($upload_path . 'intro_crop.jpg')) {?>
<img src="<?php echo "$ttpl_path/intro_crop.jpg"; ?>" alt="" width="350" height="250" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/cimage-intro.gif" alt="" width="350" height="250" />
<?php } ?>
</a>
<h2>
<?php if($tn_wpmu_intro_header == '') { ?>
This is intro header
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_intro_header); ?>
<?php } ?>
</h2>
<?php if($tn_wpmu_intro_text == '') { ?>
<?php _e('You can replace ever area on this page with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> or <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the ones you can see here already.'); ?>
<?php } else { ?>
<p><?php echo stripslashes($tn_wpmu_intro_text); ?></p>
<?php } ?>


<?php } elseif ($tn_wpmu_latest_post == "custom post with recent post") { ?>


<a href="<?php echo stripslashes($tn_wpmu_intro_header_imgurl); ?>">
<?php
if(file_exists($upload_path . 'intro_crop.jpg')) {?>
<img src="<?php echo "$ttpl_path/intro_crop.jpg"; ?>" alt="" width="350" height="250" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/cimage-intro.gif" alt="" width="350" height="250" />
<?php } ?>
</a>
<h2>
<?php if($tn_wpmu_intro_header == '') { ?>
This is intro header
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_intro_header); ?>
<?php } ?>
</h2>
<?php if($tn_wpmu_intro_text == '') { ?>
<?php _e('You can replace ever area on this page with a new text in <a href="wp-admin/themes.php?page=custom-homepage.php">your theme options</a> or <a href="wp-admin/themes.php?page=custom-homepage.php">upload and crop new images</a> to replace the ones you can see here already.'); ?>
<?php } else { ?>
<p><?php echo stripslashes($tn_wpmu_intro_text); ?></p>



<div class="post-content">
<h3><?php _e('Latest News &raquo;'); ?></h3>
<br />
<ul class="list">

<?php $my_query = new WP_Query('category_name=&showposts=5');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
?>

<li>
<p style="font-size: 18px;"><strong><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></strong></p>
<p><?php the_excerpt(); ?></p>
</li>

<?php endwhile;?>

</ul>
</div>


<?php } ?>

<?php } ?>
</div>









<div id="top-right-widget">

<?php if($tn_wpmu_show_profile == "yes"){ ?>
<?php include (TEMPLATEPATH . '/profiles.php'); ?>
<?php } ?>



<!-- video feat -->

<?php
$tn_wpmu_featured_vid = get_option('tn_wpmu_featured_vid');
if($tn_wpmu_featured_vid == ''){ ?>
<?php } else { ?>
<h3><?php _e('Featured Videos'); ?></h3>
<ul class="list">
<li><?php $tn_wpmu_featured_vid = stripcslashes($tn_wpmu_featured_vid); echo $tn_wpmu_featured_vid; ?> </li>
</ul>
<?php } ?>

<!-- end -->


<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Home Top Right') ) : ?>

<li>
<h3><?php _e('Top Right Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>

<?php endif; ?>

</ul>


</div>

</div>