<?php get_header(); ?>

<div id="content">

<div id="post-entry">

<?php if (have_posts()) : ?>

<?php include (TEMPLATEPATH . '/headline.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div <?php if(function_exists("post_class")) : ?><?php post_class(); ?><?php else: ?>class="post"<?php endif; ?> id="post-<?php the_ID(); ?>">

<h1 class="post-title"><?php the_title(); ?></h1>


<!--<div class="post-author">
<div class="alignleft">
<?php echo get_avatar( get_the_author_email(), '16' ); ?>&nbsp;
<?php _e('by'); ?>&nbsp;<?php the_author_posts_link(); ?>&nbsp;<?php _e('in'); ?>&nbsp;<?php the_time('F jS Y') ?></div>

<div class="alignright">
<span class="coms-post"><?php comments_popup_link('No Comment', '1 Comment', '% Comments'); ?></span><?php edit_post_link('edit'); ?>
</div>
</div>-->


<div class="post-content">
<?php the_content(); ?>
<p><?php edit_post_link(__('Edit Page')); ?></p>
</div>

</div>

<?php endwhile; ?>



<?php
/*$mywp_version = get_bloginfo('version');
if ($mywp_version >= '2.7') {
comments_template('', true);
} else {
comments_template();
}*/
?>




<?php include (TEMPLATEPATH . '/paginate.php'); ?>

<?php else: ?>

<?php include (TEMPLATEPATH . '/result.php'); ?>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>