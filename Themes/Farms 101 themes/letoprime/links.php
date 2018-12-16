<?php
/*
Template Name: Links
*/
?>

<?php get_header(); ?>

<div id="content" class="narrowcolumn">

<h2><?php _e('Links:');?></h2>
<ul>
<?php get_links_list(); ?>
</ul>

</div>	
<?php get_sidebar(); ?>
<?php get_footer(); ?>
