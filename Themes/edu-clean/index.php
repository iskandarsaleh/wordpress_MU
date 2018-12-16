<?php get_header(); ?>

<div id="content">

<div id="post-entry">

<?php if (have_posts()) : ?>

<?php include (TEMPLATEPATH . '/headline.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div <?php if(function_exists("post_class")) : ?><?php post_class(); ?><?php else: ?>class="post"<?php endif; ?> id="post-<?php the_ID(); ?>">

<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>


<div class="post-author">
<div class="alignleft">

<?php
$if_author_on = get_option('tn_edus_author_avatar'); ?>
<?php if($if_author_on == 'yes') { ?>
<?php echo get_avatar( get_the_author_email(), '16' ); ?>&nbsp;
<?php } ?>

<?php _e('by'); ?>&nbsp;<?php the_author_posts_link(); ?>&nbsp;<?php _e('in'); ?>&nbsp;<?php the_time('F jS Y') ?></div>

<div class="alignright">
<span class="coms-post"><?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?></span><?php edit_post_link(__('edit')); ?>
</div>
</div>



<div class="post-content">
<?php if((is_category()) || (is_archive()) || (is_search())) { ?>
<?php the_excerpt(); ?>
<?php } else { ?>
<?php the_content(__('...click here to read more')); ?>
<?php } ?>
</div>


<?php
$if_cat_on = get_option('tn_edus_post_cat'); ?>
<?php if($if_cat_on == 'yes') { ?>
<div class="post-under">
Category: <?php the_category(', ') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if(function_exists("the_tags")) : ?><?php the_tags() ?><?php endif; ?>
</div>
<?php } ?>



</div>
<?php endwhile; ?>

<?php include (TEMPLATEPATH . '/paginate.php'); ?>

<?php else: ?>

<?php include (TEMPLATEPATH . '/result.php'); ?>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>