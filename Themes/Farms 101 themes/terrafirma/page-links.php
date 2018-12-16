<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>
<div id="content">
	<div class="post">
		<div class="header">
					<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title(); ?></a></h3>					
				</div>
		
		<div class="entry">
			<ul>
				<?php get_links_list('name');?>
			</ul>
		</div>
	</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>