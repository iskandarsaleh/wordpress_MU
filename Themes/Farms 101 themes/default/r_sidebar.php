<div id="sidebar">
	<ul class="sidebar_list">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-default-sidebars"); } ?>

		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(2)) : ?>


		<li class="widget">
			<h2><?php _e('Latest Posts');?></h2>
			<ul>
				<?php 
query_posts('showposts=5');
if (have_posts()) : ?><?php while (have_posts()) : the_post(); ?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link to');?> <?php the_title(); ?>"><?php the_title();?> </a></li>
<?php endwhile; ?><?php endif; ?>
</ul>
		</li>

	<?php get_links_list('id'); ?>

			<li class="widget"><h2><?php _e('Archives');?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>

			<li class="widget"><h2><?php _e('Meta');?></h2>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<li><a href="http://<?php echo $current_site->domain . $current_site->path ?>wp-signup.php" title="<?php _e('Create a new blog');?>"><?php _e('Create another blog');?></a></li>
					<li><a href="http://<?php echo $current_site->domain . $current_site->path ?>" title="<?php echo $current_site->site_name ?>"><?php echo $current_site->site_name ?></a></li>
					<li><a href="http://edublogs.org/support" title="Edublogs Support">Edublogs Support</a></li>
					<li><a href="http://edublogs.org/campus" title="Edublogs Campus">Edublogs Campus</a></li>
					<?php wp_meta(); ?>
				</ul>
				</li>

				<li class="widget">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
			</li>

			

	
		<?php endif; ?>
	</ul>
</div>