<?php get_header(); ?>

<div id="post-entry">

<div id="blog-content">

<?php if (have_posts()) : ?>

<?php include (TEMPLATEPATH . '/headline.php'); ?>

<?php while (have_posts()) : the_post(); ?>

<div <?php if(function_exists("post_class")) : ?><?php post_class(); ?><?php else: ?>class="page"<?php endif; ?> id="post-<?php the_ID(); ?>">

<h1 class="post-title"><?php the_title(); ?></h1>

<div class="post-content">
<?php the_content(__('.....click here to read more')); ?>
<p><?php edit_post_link(__('Edit This Page')); ?></p>
</div>



</div>

<?php endwhile; ?>

<?php /* comments_template(); */ ?>

<?php include (TEMPLATEPATH . '/paginate.php'); ?>

<?php else: ?>

<?php include (TEMPLATEPATH . '/result.php'); ?>

<?php endif; ?>

</div>

<?php include (TEMPLATEPATH . '/right-sidebar.php'); ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>