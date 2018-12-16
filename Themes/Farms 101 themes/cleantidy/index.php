<?php get_header(); ?>

<div id="recent">
<div class="container">

<div class="recent-post">

<?php
$posts = get_posts('numberposts=1');
foreach($posts as $post) :
setup_postdata($post);
 ?>
<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<small><?php the_time(__('F jS, Y')) ?> | <?php the_category(', ') ?> | <?php comments_popup_link('No comments', '1 comment', '% comments','Comments are off for this post'); ?> <?php edit_post_link('Edit this post'); ?> </small>
<div class="post-body"><br /><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
<?php the_content('Continue reading'); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("72890ink"); } ?>
</div>
<?php endforeach; ?>

</div>

<div class="aboutbox">
<ul class="widgets">
				<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('MostRecent sidebar') ) : ?>
				<?php wp_list_categories('hierarchical=0&title_li=<h2>'.__('Categories').'</h2>'); ?>
				<?php endif; ?>			
</ul>
</div>
<div class="clear"></div>
</div>
</div>


<div id="posts">
	<div class="container">
	<div class="recent-post">
<?php
$posts = get_posts('numberposts=5&offset=1');
foreach($posts as $post) :
setup_postdata($post);
 ?>
<div class="post" id="post-<?php the_ID(); ?>">
<h2 class="post-title"><a href="<?php the_permalink() ?>" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>
<small><?php the_time(__('F jS, Y')) ?> | <?php the_category(', ') ?> | <?php comments_popup_link('No comments', '1 comment', '% comments','Comments are off for this post'); ?> <?php edit_post_link('Edit this post'); ?></small>
<div class="post-body">
<?php the_content('Continue reading'); ?>
</div>
</div>
<?php endforeach; ?>
	

	</div>
	
	<div id="sidebar">
		<ul  class="widgets">
				<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar('Recents sidebar') ) : ?>
				<?php /* If this is the frontpage */ if ( is_home() || is_page() ) { ?>
				<?php wp_list_bookmarks(); ?>
				<li><h2><?php _e('Archives');?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
				</li>
				<?php } ?>
				<?php endif; ?>	
		</ul>
	</div>
	</div>
	<div class="clear"></div>
</div>
<?php get_footer(); ?>