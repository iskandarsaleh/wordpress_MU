<?php get_header(); ?>

		<div id="content_wrapper">
			<div id="content">
			
			<h1><?php _e('Error 404')?> - <?php _e('Page not found')?></h1>
		
			<p><?php _e('Sorry - this page cannot be found. Why not to search our archives?');?></p>
			
			<br />	
			<?php include("searchform.php") ?>
						
			</div>
		</div>
			
	
	<?php include("sidebar.php") ?>

<?php get_footer(); ?>
