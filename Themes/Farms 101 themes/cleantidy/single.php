<?php get_header(); ?>

<div id="recent">
<div class="container">

<div class="recent-post">

<?php if(have_posts()):?><?php while(have_posts()): the_post(); ?>


<div class="recent-post">
<h2 id="post-<?php the_ID(); ?>" class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<small><?php the_time(__('F jS, Y')) ?> | <?php the_category(', ') ?> | <?php the_tags( '&nbsp;' . __( 'Tagged' ) . ' ', ', ', ''); ?>  <?php edit_post_link('Edit this post'); ?> </small>
</div>


</div>

<div class="clear"></div>
</div>
</div>


<div id="posts">
	<div class="container">
	<div class="recent-post">
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890graphite"); } ?>
	<?php the_content('More ...'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890graphite"); } ?>
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>	
  <div class="navigation">
			<div class="alignleft"><?php previous_post_link('&laquo; %link') ?></div>
			<div class="alignright"><?php next_post_link('%link &raquo;') ?></div>
	</div>
  
  <div id="comment-container">
  	<?php comments_template(); ?>
	</div>
<?php endwhile; else: ?>
	
<?php endif; ?>


	</div>
	
	<div id="sidebar">
		<ul  class="widgets">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('MostRecent sidebar') ) : ?>
				<?php endif; ?>	
				<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('Recents sidebar') ) : ?>
				<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php wp_list_bookmarks(); ?>
				<?php } ?>
				<?php endif; ?>	
		</ul>
	</div>
	
	</div>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>