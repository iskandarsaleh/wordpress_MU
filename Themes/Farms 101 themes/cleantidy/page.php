<?php get_header(); ?>

<div id="recent">
<div class="container">

<div class="recent-post">

<?php if(have_posts()):?><?php while(have_posts()): the_post(); ?>

<!-- begin mini loop -->
<div class="recent-post">
<h2 id="post-<?php the_ID(); ?>" class="title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
</div>
</div>

<div class="clear"></div>
</div>
</div>


<div id="posts">
	<div class="container">
	<div class="recent-post">

<?php endwhile; else: ?>
	
<?php endif; ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890graphite"); } ?>
		
<?php the_content('More ...'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890graphite"); } ?>
<small><?php edit_post_link(__('Edit')); ?></small>
	<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>


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