<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

			<div class="post">

			<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-solipsus-top"); } ?>

	<h2><?php _e('Archives by Month');?></h2>
  		<ul>
    			<?php wp_get_archives('type=monthly&show_post_count=1'); ?>
 		</ul>

	<h2><?php _e('Archives by Category');?></h2>
  		<ul>
     			<?php wp_list_cats('sort_column=name&optiondates=1&optioncount=1'); ?>
  		</ul>

	<h2>All Posts</h2>
  		<ol>
    			<?php wp_get_archives('type=postbypost'); ?>
 		</ol>

			</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
