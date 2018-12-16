<?php
/*
Template Name: Sidebar Left (the small one)
*/
?>

	<div id="midcontent">

		<ul> 

		<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar(1) ) : ?>			
			
			<li><h2><?php _e('Archives');?></h2>
				<ul>
				<?php wp_get_archives('type=monthly'); ?>
				</ul>
			</li>


		<?php endif; ?>	

		</ul>
	</div>