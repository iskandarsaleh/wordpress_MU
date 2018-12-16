<?php get_header(); ?>

<div id="post-entry">

<?php if (have_posts()) : ?>

<?php include (TEMPLATEPATH . '/headline.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div <?php if(function_exists("post_class")) : ?><?php post_class(); ?><?php else: ?>class="post"<?php endif; ?> id="post-<?php the_ID(); ?>">

<h1 class="post-title"><?php the_title(); ?></h1>

<div class="post-author"><?php the_time('jS F Y') ?> <?php _e('by') ?> <?php the_author_posts_link(); ?> <?php _e('under') ?> <?php the_category(', ') ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php edit_post_link(__('edit')); ?></div>

<div class="post-content">
<?php the_content(__('...click here to read more')); ?>
</div>


<div class="post-tagged">
<p class="tags">
<?php if(function_exists("the_tags")) : ?>
<?php the_tags(__('tags:&nbsp;'), ', ', ''); ?>
<?php endif; ?>
</p>
<p class="com">
<?php comments_popup_link(__('Leave Comments &rarr;'), __('One Comment &rarr;'), __('% Comments &rarr;')); ?>
</p>
</div>

</div>


<?php endwhile; ?>

<?php
$mywp_version = get_bloginfo('version');
if ($mywp_version >= '2.7') {
comments_template('', true);
} else {
comments_template();
}
?>


<?php include (TEMPLATEPATH . '/paginate.php'); ?>

<?php else: ?>

<?php include (TEMPLATEPATH . '/result.php'); ?>

<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>