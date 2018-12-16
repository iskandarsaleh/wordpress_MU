<?php get_header(); ?>
<?php get_sidebar(); ?>
	<div id="main">
	    <?php if (have_posts()) : ?>
	    <?php while (have_posts()) : the_post(); ?>
	    <div class="post" id="post-<?php the_ID(); ?>">
			<h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>
			<div class="entry"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	            <?php the_content(__('Read the rest of this entry &raquo;')); ?>
		    </div>
	        <p class="post-footer align-right">
	             <?php the_category(', ') ?> |<span class="date"><?php the_time(__('F jS, Y')) ?></span><!--by <?php the_author() ?> |--><?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?> <?php edit_post_link(__('Edit'), '| ',' | '); ?>  <?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?>
		    </p>
        </div>
	    <?php endwhile; ?>
	
	    <div class="navigation">
		    <div align="left"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
		    <div align="right"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
	    </div>
	    <?php else : ?>
     	<h1><?php _e('Not Found');?></h1>
	    <p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
	    <?php include (TEMPLATEPATH . "/searchform.php"); ?>
	    <?php endif; ?>
	</div>
<?php include (TEMPLATEPATH . '/rbar.php'); ?>
<?php get_footer(); ?>
	