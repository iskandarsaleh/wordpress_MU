<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<!-- BEGIN PAGE CONTAINER -->
	<div id="container_page">

<?php include (TEMPLATEPATH . '/searchform.php'); ?>

<h2><?php _e('Archives by Month:');?></h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h2><?php _e('Archives by Subject:');?></h2>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>


<?php get_footer(); ?>
