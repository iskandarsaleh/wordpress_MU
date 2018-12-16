<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

	<?php if (have_posts()) : ?>

		<h2 class="pagetitle"><?php _e('Search Results','nikynik'); ?></h2>
		
		<div class="navigation"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Entries'), __('Next Entries &raquo;')) ?>
	
		</div>


		<?php while (have_posts()) : the_post(); ?>
				
			<div class="post">
				<h3 id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>
				<small><?php the_time(__('l, F jS, Y','nikynik')) ?></small>
				
				<div class="entry">
					<?php the_excerpt() ?>
				</div>
		
				<p class="postmetadata"><?php _e('Filed under:','nikynik'); ?> <?php the_category(', ') ?> <strong>|</strong> <?php edit_post_link(__('Edit'),'','<strong>|</strong>'); ?> <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?></p> 
				
				<!--
				<?php trackback_rdf(); ?>
				-->
			</div>
	
		<?php endwhile; ?>

		<div class="navigation"><?php posts_nav_link(' &#8212; ', __('&laquo; Previous Entries'), __('Next Entries &raquo;')) ?>
	
		</div>
	
	<?php else : ?>

		<h2 class="center"><?php __('Not Found','nikynik'); ?></h2>
		<?php include (TEMPLATEPATH . '/searchform.php'); ?>
<?php endif; ?>
		
	</div>

<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>