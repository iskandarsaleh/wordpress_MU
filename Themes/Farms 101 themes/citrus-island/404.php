<?php get_header(); ?>


<?php get_sidebar(); ?>


	<div id="main">





		<h1><?php _e('Error 404 - Not Found') ?></h2>


		<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>


		<?php include (TEMPLATEPATH . "/searchform.php"); ?>





	</div>


<?php include (TEMPLATEPATH . '/rbar.php'); ?>


<?php get_footer(); ?>