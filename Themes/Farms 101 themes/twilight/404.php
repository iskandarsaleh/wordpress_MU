<?php get_header(); ?>

	<div class="entry">
		<h2><?php _e('Error 404');?>- <?php _e('Page not found')?></h2>
<p>Oops!  This page either has been moved or does not exist.  Feel free to navigate using the sidebar or return to <a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a> to start over.</p>

	</div>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>