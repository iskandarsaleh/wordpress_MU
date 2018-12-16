<?php get_header(); ?>
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="entry" id="post-<?php the_ID(); ?>">
<div class="date"><span class="day"><?php the_time('j') ?></span><br /><span class="month"><?php the_time('F') ?></span><br /><span class="year"><?php the_time('Y') ?></span></div>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a><span class="comments"><?php comments_popup_link('0', '1', '%'); ?></span></h2>
	
		<div align="center">	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?></div>	<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?><div align="center">	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?></div>	
	
				<?php link_pages('<p><strong>'.__('Pages').':</strong> ', '</p>', 'number'); ?>
<p class="entrymeta">Posted under: <?php the_category(', '); ?> <?php edit_post_link('Edit this entry', '. ', ''); ?> </p>
</div>

<div class="navigation">
			<div class="alignleft"><?php previous_post('%','&laquo; Previous post', 'no'); ?></div>
			<div class="alignright"><?php next_post('%','Next post &raquo;', 'no'); ?></div>
<br style="clear: all;" />
		</div>

	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.');?></p>
	
<?php endif; ?>
	
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
