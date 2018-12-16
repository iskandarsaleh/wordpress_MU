<div id="front-content">

<?php include (TEMPLATEPATH . '/options.php'); ?>

<ul class="list">

<li>
<h3>
<?php if($tn_wpmu_dixi_intro_header == '') { ?>
This is intro header
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_dixi_intro_header); ?>
<?php } ?>
</h3>
<ul>
<li>
<?php if($tn_wpmu_dixi_intro_header_text == '') { ?>
<?php _e('You can replace area on this page with a new text in <a href="wp-admin/themes.php?page=site-intro.php">your theme options'); ?></a>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_dixi_intro_header_text); ?>
<?php } ?>
</li>
</ul>
</li>


<?php
$tn_wpmu_dixi_featured_vid = get_option('tn_wpmu_dixi_featured_vid');
if($tn_wpmu_dixi_featured_vid == ''){ ?>
<?php } else { ?>
<li>
<h3><?php _e('Featured Videos'); ?></h3><ul>
<li><?php $tn_wpmu_dixi_featured_vid = stripcslashes($tn_wpmu_dixi_featured_vid); echo $tn_wpmu_dixi_featured_vid; ?> </li>
</ul></li>
<?php } ?>



<!-- custom -->
<li>
<h3><?php _e('Recent Site Articles'); ?></h3>
<ul>
<?php
//insert your category name
$my_query = new WP_Query('category=&showposts=5');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
?>

<li class="feat-img">
<strong class="feat-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></strong><br />
<?php _e('by'); ?> <?php the_author_posts_link(); ?> <?php _e('on'); ?> <?php the_time('jS F Y') ?>
</li>

<?php endwhile;?>

</ul>

</li>
<!-- end custom -->


<?php
if (function_exists("is_site_admin")) {
$mu = true;
} else {
$mu = false;
}
?>


</ul>



<?php if($tn_wpmu_dixi_show_rss == "yes"){ ?>
<?php include (TEMPLATEPATH . '/tab-content.php'); ?>
<?php } ?>



<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Frontpage') ) : ?>


<?php endif; ?>

</ul>


</div>