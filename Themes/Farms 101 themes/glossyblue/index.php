<?php get_header(); ?>
  <div id="content">
  <?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-glossyblue-top"); } ?>
  <?php if (have_posts()) : ?>
  
  	<?php while (have_posts()) : the_post(); ?>
  
    <div class="post" id="post-<?php the_ID(); ?>">
	  <div class="post-date"><span class="post-month"><?php the_time('M') ?></span> <span class="post-day"><?php the_time('d') ?></span></div>
	  <div class="entry">
        <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<span class="post-cat"><?php the_category(', ') ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?></span> <span class="post-comments"><?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></span>
		<div class="post-content">
			<?php the_content(__('Read the rest of this entry &raquo;')); ?>
		</div>
	  </div>
	</div>
	
	<?php endwhile; ?>
	
	<div class="navigation">
	  <span class="previous-entries"><?php next_posts_link(__('Previous Entries')) ?></span> <span class="next-entries"><?php previous_posts_link(__('Next Entries')) ?></span>
	</div>
	
	<?php else : ?>
	
		<h2 class="center"><?php _e('Not Found');?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
		
  <?php endif; ?>
	
  </div><!--/content -->
  
<?php get_sidebar(); ?>

<?php get_footer(); ?>
