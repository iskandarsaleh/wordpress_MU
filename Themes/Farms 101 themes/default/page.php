<?php get_header(); ?>

	<div id="content_box">
	
		<?php include (TEMPLATEPATH . '/l_sidebar.php'); ?>
	
		<div id="content" class="pages">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-default-top"); } ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<h2><?php the_title(); ?></h2>	
			<div class="entry">		

		
				<p><?php the_content(__('Read the rest of this page &rarr;')); ?></p>
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
			</div>
			<?php if ('open' == $post-> comment_status) { ?>
			<p class="tagged"><a href="<?php the_permalink() ?>#comments"><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a></p>
			<div class="clear"></div>
			<?php } else { ?>
			<div class="clear rule"></div>
			<?php } ?>
			
			<?php endwhile; endif; ?>
			
			<?php if ('open' == $post-> comment_status) { comments_template(); } ?>

		</div>
		
		<?php include (TEMPLATEPATH . '/r_sidebar.php'); ?>

	</div>

<?php get_footer(); ?>