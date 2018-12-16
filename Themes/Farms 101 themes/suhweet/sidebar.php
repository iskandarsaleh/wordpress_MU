<?php
/*
Template Name: Sidebar Right (the wide one)
*/
?>

<div id="contentright">

	<div id="sidebar">
		<ul>
		<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar(2) ) : ?>
		<?php endif; ?>	
		</ul>
	</div>

</div>