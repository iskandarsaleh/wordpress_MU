<?php get_header(); ?>

	<div id="content" class="widecolumn">

  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="post">

			<h2 id="post-<?php the_ID(); ?>"><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<h4><?php the_time(__('F jS, Y')) ?></h4>
			<div class="entrytext">
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?><?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890nocolor"); } ?>

				<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>

				<p class="postmetadata alt">
						<?php _e('Posted by');?> <?php the_author() ?> at <a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_time() ?></a>
						& <?php _e('Filed under');?> <?php the_category(', ') ?> <strong>|</strong> <?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?> <strong>|</strong> <?php edit_post_link(__('Edit'), '','<strong>|</strong>'); ?>  <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p>
				</p>
			</div>
		</div>

		<!--
		<div class="navigation">
			<div class="alignleft"><?php /* previous_post('&laquo; %','','yes') */ ?></div>
			<div class="alignright"><?php /* next_post(' % &raquo;','','yes') */ ?></div>
		</div>
		-->


	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>

<?php endif; ?>

	</div>


<?php get_sidebar(); ?>

<?php get_footer(); ?>
