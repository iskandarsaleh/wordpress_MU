<?php get_header(); ?>

	<div id="bloque">
		<div id="noticias">
		
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

			<div class="entrada">
				<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
				
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(__("Continue reading ").the_title('', '', false)."..."); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
			<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>
			<?php link_pages('<p><strong>'.__('Pages').':</strong> ', '</p>', 'number'); ?>
			</div>
			
		</div>

		<?php endwhile; endif; ?>

<?php get_footer(); ?>