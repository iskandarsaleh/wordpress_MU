<?php get_header(); ?>

<!-- content ................................. -->
<div id="content">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>

		<h2><?php the_title(); ?></h2>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>

		<?php the_content(); ?>

<?php endwhile; ?>

<?php endif; ?>

<?php if ( comments_open() ) comments_template(); // Get wp-comments.php template ?>

</div> <!-- /content -->

<?php get_footer(); ?>