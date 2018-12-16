<?php
/*
Template Name: Archives
*/
?>
<?php get_header();?>

		<div id="content">
		
			<!-- primary content start -->
<div class="post">
				<div class="header">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
				</div>
				<p><?php edit_post_link(); ?></p>
				<div class="entry">
				<h3><?php _e('by Categories'); ?></h3>
					<ul>
						<?php list_cats(0, '', 'name', 'ASC', '/', true, 0, 1);    ?>
					</ul>
					
					<h3><?php _e('by Month'); ?></h3>
					<ul><?php wp_get_archives('type=monthly'); ?></ul>
				<h3><?php _e('Last 50 Entries');?></h3>			
					<ul>
					<?php $posts = query_posts('showposts=50');?>			
					<?php if ($posts) : foreach ($posts as $post) : start_wp(); ?>
						<li><h4><em><?php the_time('d M Y'); ?></em><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h4></li>
					<?php endforeach; else: ?>
					<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
					<?php endif; ?>		
					</ul>					
				</div>
			</div>
			<!-- primary content end -->	
		</div>		
	<?php get_sidebar();?>	
<?php get_footer();?>