<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>
		
		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post" id="post-<?php the_ID(); ?>">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<div class="metaright"><div class="articlemeta"><span class="editentry"><?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="'.__("Edit Link").'"  />','<span class="editlink">','</span>'); ?></span>	<li class="date"><?php the_time('M jS, Y') ?></li> | <li class="cat"><?php the_category(', ') ?></li> | <li class="comm"> <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></li> <br/></div></div>
		<div class="metaright">	<?php if(function_exists('UTW_ShowTagsForCurrentPost')) : ?><div class="utwtags"><?php UTW_ShowTagsForCurrentPost("commalist"); ?></div> <?php endif; ?></div>
				
				<div class="entrytext">
					<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(__('Read the rest of this entry &raquo;')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
				</div>
			</div> <!-- end post -->
	
		<?php endwhile; ?>

		<div class="navigation">
			<div class="alignleft"><?php next_posts_link(__('Previous Entries')) ?></div>
			<div class="alignright"><?php previous_posts_link(__('Next Entries')) ?></div>
		</div>
		
	<?php else : ?>

		<h2 class="center"><?php _e('Not Found');?></h2>
		<p class="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>
		<?php include (TEMPLATEPATH . "/searchform.php"); ?>

	<?php endif; ?>

	</div> <!-- end content -->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
