<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div id="content" class="widecolumn">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280ink"); } ?>
<h2 class="title"><?php _e('Archives by Month:', 'chaoticsoul'); ?></h2>
  <ul class="archive">
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h2 class="title"><?php _e('Archives by Subject:', 'chaoticsoul'); ?></h2>
  <ul class="archive">
     <?php wp_list_cats(); ?>
  </ul>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
