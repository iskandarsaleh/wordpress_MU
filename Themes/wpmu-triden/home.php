<?php get_header(); ?>

<?php include (TEMPLATEPATH . '/options.php'); ?>

<?php if(($tn_wpmu_tri_layout_mode == "") || ($tn_wpmu_tri_layout_mode == "custom homepage")) { ?>

<?php include (TEMPLATEPATH . '/custom-homepage.php'); ?>

<?php } else if($tn_wpmu_tri_layout_mode == "blog homepage") { ?>

<div id="post-entry">

<?php if (have_posts()) : ?>

<?php include (TEMPLATEPATH . '/headline.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div <?php if(function_exists("post_class")) : ?><?php post_class(); ?><?php else: ?>class="post"<?php endif; ?> id="post-<?php the_ID(); ?>">

<h1 class="post-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>

<div class="post-author"><?php _e('Posted by'); ?>&nbsp;<?php the_author_posts_link(); ?>&nbsp;<?php _e('on'); ?>&nbsp;<?php the_time('l, F jS Y') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php edit_post_link(__('edit')); ?></div>

<div class="post-content">
<?php the_content(__('...click here to read more')); ?>
</div>

</div>

<?php endwhile; ?>

<?php /* comments_template(); */ ?>

<?php include (TEMPLATEPATH . '/paginate.php'); ?>

<?php else: ?>

<?php include (TEMPLATEPATH . '/result.php'); ?>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php } ?>

<?php get_footer(); ?>