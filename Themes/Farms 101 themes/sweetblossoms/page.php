<?php get_header(); ?>

<!-- content ................................. -->
<div id="main">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

		<h2><?php the_title(); ?></h2>

		<?php the_content(); ?>

<?php endwhile; ?>

<?php endif; ?>

</div> <!-- /content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>