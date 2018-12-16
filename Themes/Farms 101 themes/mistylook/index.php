<?php get_header();?>
<div id="content">
<div id="content-main">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-mistylook-top"); } ?>

		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="posttitle">
			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title=""><?php the_title(); ?></a></h2>
				<p class="postmetadata"><?php the_time(get_option("date_format")); ?> <?php _e('by'); ?> <?php the_author_posts_link() ?> <?php edit_post_link(__('Edit'), ' | ', ' '); ?> </p>
				</div>
				
				<div class="entry">
				<?php the_content(__('Continue Reading &raquo;')); ?>
					<?php wp_link_pages(); ?>
				</div>
		
				<p class="post-info"><?php printf(__('Posted in %s'), get_the_category_list(', ')); ?> | <?php the_tags( __('Tagged').' ', ', ', ' | ' ); ?><?php comments_popup_link(__('No Comments &#187;'), __('1 Comment &#187;'), __('% Comments &#187;')); ?></p>
				<?php comments_template(); ?>
			</div>
		<?php endwhile; else : ?>
			<h2 class="center"><?php _e('Not Found'); ?></h2>
			<p class="center"><?php _e('Sorry, but you are looking for something that isn&#8217;t here.'); ?></p>
		<?php endif; ?>
		<p align="center"><?php posts_nav_link(' - ',__('&#171; Newer Posts'),__('Older Posts &#187;')) ?></p>
</div><!-- end id:content-main -->
<?php get_sidebar();?>
<?php get_footer();?>
