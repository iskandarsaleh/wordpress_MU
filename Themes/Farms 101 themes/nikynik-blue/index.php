<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h2 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
				<small><?php _e('Filed under:'); ?> <?php the_category(', ') ?> <?php _e('on','nikynik'); ?> <?php the_time(__('l, F jS, Y','nikynik')) ?> <?php _e('by','nikynik'); ?> <?php the_author() ?> <strong>|</strong> <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit','nikynik'),'','<strong>|</strong>'); ?> <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?>  </small>
				
				<div class="entry">
				<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(__('Read the rest of this entry &raquo;','nikynik')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				</div>
		</div>
				 
				
				<!--
				<?php trackback_rdf(); ?>
				-->
			
	
		<?php endwhile; ?>

		<div class="navigation">

			<?php posts_nav_link(' &#8212; ', __('&laquo; Previous Page'), __('Next Page &raquo;')) ?>
		</div>
	<?php else : ?>

		<h2 class="center"><?php __('Not Found','nikynik'); ?></h2>
		<p class="center"><?php _e('Sorry, but you are looking for something that isn\'t here.','nikynik'); ?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>
<?php endif; ?>

	</div>

<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>