<?php get_header(); ?>
	    
    <div id="content">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-bluebird"); } ?>

	<?php if (have_posts()) : ?>

		<?php while (have_posts()) : the_post(); ?>
<!-- item -->
				<div class="item entry" id="post-<?php the_ID(); ?>">
				          <div class="itemhead">
				            <h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				            <div class="date"><?php the_time(__('F jS, Y')) ?> <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?> </div>
				          
						  
								<?php the_content('Continue reading  &raquo;'); ?>
						 
				          <small class="metadata">
							 <?php ('Filed under');?> <span class="category"><?php the_category(', ') ?> </span> | <?php edit_post_link(__('Edit'), '', ' | '); ?> <?php comments_popup_link(__('Comment (0)'), __(' Comment (1)'), __('Comments (%)')); ?></small>
							 <div style="clear:both;"></div>
<div style="clear:both;"></div>
				 </div></div>
<!-- end item -->

<?php comments_template(); // Get wp-comments.php template ?>
		
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link('&laquo; Previous Entries') ?></div>
			<div class="alignright"><?php previous_posts_link('Next Entries &raquo;') ?></div>
			<p> </p>
		</div>

	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>

	<?php endif; ?>
<!-- end content -->

	</div>
	<div id="secondary">

<?php include(TEMPLATEPATH."/l_sidebar.php");?>

<?php include(TEMPLATEPATH."/r_sidebar.php");?>

	</div>
<?php get_footer(); ?>