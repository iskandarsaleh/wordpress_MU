<div id="front-right">

<div id="top-right-front">


<div id="latest-news">

<?php include (TEMPLATEPATH . '/profile.php'); ?>


<h3><?php _e('Latest News &raquo;'); ?></h3>
<?php $my_query = new WP_Query('category_name=&showposts=5');
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; ?>

<div class="news">
<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
<p class="date-in"><?php the_time('F jS') ?></p>
<p><?php the_excerpt_feature(); ?>...(<?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?>)</p>
</div>

<?php endwhile;?>
</div>
</div>

<div id="bottom-right-front">

<ul class="sidebar_list">



<?php
if (function_exists("is_site_admin")) {
$mu = true;
} else {
$mu = false;
}
?>




<?php $the_cat_sidebar = get_option('tn_edus_sidebar_featured'); ?>
<?php if(($the_cat_sidebar == '') || ($the_cat_sidebar == 'Choose a category:')){ ?>
<?php } else { ?>
<li id="featured-sidebar">
<h3><?php _e('Recently in'); ?> <?php echo stripcslashes($the_cat_sidebar); ?></h3>
<ul>
<?php
//insert your category name
$my_query = new WP_Query('category_name='. $the_cat_sidebar . '&' . 'showposts=' . 10);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
$the_post_ids = get_the_ID();
?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;?>
</ul>
</li>
<?php } ?>


<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2)) : ?>


<li id="tag_cloud" class="widget_tag_cloud">
<h3><?php _e('Popular Tags'); ?></h3>
<ul><li>
<?php if(function_exists("wp_tag_cloud")) { ?>
<?php wp_tag_cloud('smallest=11&largest=24&'); ?>
<?php } ?>
</li>
</ul>
</li>



 <!-- widgets -->

<?php endif; ?>

</ul>




</div>

</div>