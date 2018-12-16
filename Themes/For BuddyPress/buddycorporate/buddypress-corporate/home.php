<?php get_header(); ?>

<div id="post-entry" class="home-column">


<div id="feat-content">
<div class="feat-articles">
<div class="feat-post">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); $bc == 0; ?>

<?php if ($bc < 1) { ?>

<h4><span>Blog | <?php the_time('F jS') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php _e( 'in', 'buddypress' ) ?></span> <?php the_category(', ') ?></h4>

<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

<div class="feat-tag"><?php the_tags(__('tagged in&nbsp;'), ', ', ''); ?></div>

<div class="feat-post-content">
<?php the_excerpt_feature(); ?>
</div>

<h2><?php _e( 'More Article &raquo;', 'buddypress' ) ?></h2>

<ul class="more-article">

<?php } else { ?>

<li><div class="alignleft"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></div><div class="alignright"><?php the_time('F jS') ?></div></li>

<?php } ?>

<?php $bc++; ?>

<?php endwhile; ?>

</ul>

<?php endif; ?>

</div>

</div>
</div>




<?php $the_home_featured_cat = get_option('tn_buddycorp_home_featured_cat'); ?>
<?php if(($the_home_featured_cat == '') || ($the_home_featured_cat == 'Choose a category:')){ ?>
<?php } else { ?>
<div class="widget widget_featured">
<h2 class="widgettitle"><?php _e( 'Recently in' ) ?>&nbsp;<?php echo stripcslashes($the_home_featured_cat); ?></h2>
<ul>
<?php
//insert your category name
$my_query = new WP_Query('category_name='. $the_home_featured_cat . '&' . 'showposts=' . 10);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID;
?>
<li><a title="<?php the_title(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;?>
</ul>
</div>
<?php } ?>





<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('left-column') ) : ?>


<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e( 'Left Column Widget', 'buddypress' ) ?></h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this column.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-1"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>

</div>

<?php include (TEMPLATEPATH . '/home-sidebar.php'); ?>

<?php get_footer(); ?>