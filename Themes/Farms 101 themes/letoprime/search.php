<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results');?></h2>
		You have searched <?php _e('for');?> <strong>'<?php echo wp_specialchars($s); ?>'</strong>. If you can't find what you're looking for, try your search again.
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="metaright"><div class="articlemeta"><span class="editentry"><?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="'.__("Edit Link").'"  />','<span class="editlink">','</span>'); ?></span>	<li class="date"><?php the_time('M jS, Y') ?></li> | <li class="cat"><?php the_category(', ') ?></li> | <li class="comm"> <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></li> <br/></div></div>
		<div class="metaright">	<?php if(function_exists('UTW_ShowTagsForCurrentPost')) : ?><div class="utwtags"><?php UTW_ShowTagsForCurrentPost("commalist"); ?></div> <?php endif; ?></div>
				
		<?php the_excerpt(); ?>
				
			</div>
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php _e('No posts found. Try a different search?');?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>

	<?php endif; ?>
		
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>