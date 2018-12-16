<?php get_header(); ?>

<!-- BEGIN PAGE CONTAINER -->
	<div id="page">
	<!-- START Loop --> 
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
	<?php
		switch($post->post_name){
			case 'comments-by-section':
				include('comments-by-section.php');
			break;
		
			case 'comments-by-user':
				include('comments-by-user.php');
			break;
							
			case 'general-comments':
				include('general-comments.php');						
			break;
			default:
			?>	
			<!-- START THE PAGE -->
			<div id="content"> 
				<h2 class="center"><?php _e('Error 404 - Not Found') ?></h2>
			</div> 
			<!-- end pages_leftCol -->
			

			<?
			break;				
		}
	?> 
	<!-- END Loop --> 
	<?php endwhile; endif; ?> 
	</div>
</div>
<?php get_footer(); ?>

