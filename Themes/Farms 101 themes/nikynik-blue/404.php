<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

		<h2 class="center"><?php _e('Error 404 - Not Found','nikynik'); ?></h2>

	</div>

<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>