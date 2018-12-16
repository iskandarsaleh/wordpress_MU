<?php get_header(); ?>

	<div id="content" class="narrowcolumn">
				
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	
		<div class="navigation"><!--
			<div class="alignleft"><?php previous_post_link('%link') ?></div>
			<div class="alignright"><?php next_post_link('%link') ?></div> -->
			<div class="alignleft"><?php previous_post('%', '', 'yes') ?></div>
			<div class="alignright"><?php next_post('%', '', 'yes') ?></div>
		</div>
	
		<div class="post" id="post-<?php the_ID(); ?>">
			<h2><a href="<?php echo get_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
	<div class="metaright"><div class="articlemeta"><span class="editentry"><?php edit_post_link('<img src="'.get_bloginfo(template_directory).'/images/pencil.png" alt="'.__("Edit Link").'"  />','<span class="editlink">','</span>'); ?></span>	<li class="date"><?php the_time('M jS, Y') ?></li> | <li class="cat"><?php the_category(', ') ?></li> | <li class="comm"> <a href='#comments'><?php comments_number(__('No Comments'), __('1 Comment'), __('% Comments')); ?></a></li> <br/></div></div>
		<div class="metaright">	<?php if(function_exists('UTW_ShowTagsForCurrentPost')) : ?><div class="utwtags"><?php UTW_ShowTagsForCurrentPost("commalist"); ?></div> <?php endif; ?></div>
				
			<div class="entrytext">
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>	<?php the_content(__('<p class="serif">Read the rest of this entry &raquo;</p>')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	
				<?php link_pages('<p><strong>'.__('Pages').':</strong> ', '</p>', 'number'); ?>
	</div> <!-- end entry text -->
				<div class="postmetadata">
					<small>
						<?php the_author() ?> posted this entry <?php _e('on');?> <?php the_time(__('l, F jS, Y')) ?> <?php _e('at');?> <?php the_time() ?>.
						Posted in the category <?php the_category(', ') ?>
					<?php if(function_exists('UTW_ShowTagsForCurrentPost')) : ?><li class="utwtags">and tagged as <?php UTW_ShowTagsForCurrentPost("commalist"); ?></li><br/> <?php endif; ?>	
						You can follow any responses to this entry through the <?php comments_rss_link('RSS 2.0'); ?> <?php _e('feed');?>. 
						
						<?php if (('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Both Comments and Pings are open ?>
							<?php _e('You can');?>  <a href="#respond"><?php _e('leave a response');?></a>, <?php _e('or');?> <a href="<?php trackback_url(true); ?>" rel="trackback"><?php _e('trackback');?></a> <?php _e('from your own site');?>.
						
						<?php } elseif (!('open' == $post-> comment_status) && ('open' == $post->ping_status)) {
							// Only Pings are Open ?>
							<?php _e('Responses are currently closed, but you can');?> <a href="<?php trackback_url(true); ?> " rel="trackback"><?php _e('trackback')?></a> <?php _e('from your own site');?>.
						
						<?php } elseif (('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Comments are open, Pings are not ?>
							<?php _e('You can skip to the end and leave a response. Pinging is currently not allowed.');?>
			
						<?php } elseif (!('open' == $post-> comment_status) && !('open' == $post->ping_status)) {
							// Neither Comments, nor Pings are open ?>
							<?php _e('Both comments and pings are currently closed.');?>			
						
						<?php } edit_post_link(__('Edit this entry.'),'',''); ?>
						
					</small>
				
<?php if (function_exists('UTW_ShowRelatedPostsForCurrentPost')) : ?>	<h3>Related Posts</h3>

<div class="utwrelposts"><?php UTW_ShowRelatedPostsForCurrentPost("postcommalist", "", "") ?></div> <?php endif; ?>
			</div>
		</div>
		
	<?php comments_template(); ?>
	
	<?php endwhile; else: ?>
	
		<p><?php _e('Sorry, no posts matched your criteria.');?></p>
	
<?php endif; ?>
	
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
