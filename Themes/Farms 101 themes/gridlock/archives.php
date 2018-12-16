<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="main_content">
	<h3 class="subhead"><?php bloginfo('name'); ?> <?php _e('Archives');?></h3>
	<p>Find what you're looking for.</p>
	
	<?php include (TEMPLATEPATH . '/searchform.php'); ?>
	
<div class="substory" id="left">
			<h3 class="substory_subhead"><?php _e('Monthly Archives');?></h3>
            <p>
            <?php get_archives('monthly','','custom','','<br/>'); ?>
            </p>
</div>
<div class="substory" id="right">
			<h3 class="substory_subhead"><?php _e('Archives by Category');?></h3>
			<p>
			<?php wp_list_cats('sortcolumn=name&list=0'); ?>
			</p>
</div>
		
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>