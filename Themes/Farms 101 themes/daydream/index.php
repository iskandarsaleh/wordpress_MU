<?php get_header(); ?>

	<div id="content">
		
	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>

						
					<div class="post" id="post-<?php the_ID(); ?>">
						<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
						<div class="data"><?php the_time(get_option('date_format')) ?> - <?php comments_popup_link('No Responses', 'One Response', '% Responses'); ?></div>
						
						<div class="entry">
							<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
							<?php the_content(__('Read the rest of this entry &raquo;')); ?>
							<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
							<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
						</div>

							<p class="postmetadata">
								Categorised in <?php the_nice_category(', ', ' and '); ?> <?php edit_post_link(__('Edit'), ' | ', ''); ?>
<br />
<?php the_tags(__('Tags: '), ', ', ''); ?>
							</p>

					</div>
				
				<?php endwhile; ?>
		
				<div class="navigation">
					<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
					<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
				</div>
		
	<?php else : ?>

		<h4><?php _e('Not Found');?></h4>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div>
	

<?php get_sidebar(); ?>

<?php get_footer(); ?>
