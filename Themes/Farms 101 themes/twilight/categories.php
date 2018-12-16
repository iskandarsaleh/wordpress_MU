<?php
/*
Template Name: Categories
*/
?>

<?php get_header(); ?>

<div class="entry">

<h2><?php _e('Categories');?></h2>

<ul>
<?php wp_list_cats('sort_column=name&optioncount=1'); ?>
</ul>

</div>	

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>