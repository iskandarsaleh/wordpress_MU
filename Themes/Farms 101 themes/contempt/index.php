<?php get_header(); ?>

	<div id="content"><br /><br /><br /><br />
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-contempt-top"); } ?>

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','contempt'); ?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small><?php the_time(get_option('date_format')) ?></small><br />
				
				
				<div class="entry">
				
					<?php the_content(__('Read the rest of this entry &raquo;','contempt')); ?>
				</div>
		
				<p class="postmetadata">
				<img src="<?php bloginfo('stylesheet_directory'); ?>/images/blog/speech_bubble.gif" alt="" /> <?php comments_popup_link(__('No Comments &#187;','contempt'),__('1 Comment','contempt'),__('% Comments','contempt')); ?>
				| <img src="<?php bloginfo('stylesheet_directory'); ?>/images/blog/documents.gif" alt="" /> <?php the_category(', ') ?>
				<?php the_tags( ' | ' . __( 'Tagged' ) . ': ', ', ', ''); ?>
				 | <img src="<?php bloginfo('stylesheet_directory'); ?>/images/blog/permalink.gif" alt="" /> <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to','contempt'); ?> <?php the_title(); ?>"><?php _e('Permalink','contempt'); ?></a>
<br /><img src="<?php bloginfo('stylesheet_directory'); ?>/images/blog/figure_ver1.gif" alt="" /> <?php _e('Posted by','contempt'); ?> <?php the_author(); ?>				 
				</p>
			</div>
			<hr />
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','contempt')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','contempt')) ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found','contempt'); ?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.","contempt"); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-contempt-bottom"); } ?>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
