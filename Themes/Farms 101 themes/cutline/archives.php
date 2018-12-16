<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>
		
	<div id="content_box">


		<div id="content" class="pages">
		
			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("cutline-top"); } ?>
			<h2><?php _e('Browse the Archives...');?></h2>
			
			<div class="entry">
				<h3 class="top">by month:</h3>
				<ul>
					<?php wp_get_archives('type=monthly'); ?>
				</ul>
				<h3><?php _e('By category:');?></h3>
				<ul>
					<?php list_cats(); ?>
				</ul>
			</div>
			<h4></h4>
			

		</div>	
		
		<?php get_sidebar(); ?>
			
	</div>
		
<?php get_footer(); ?>