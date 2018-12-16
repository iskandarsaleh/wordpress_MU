<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="content" class="narrowcolumn">
<div class="post">
<h2><?php _e('Archives by Month:','nikynik'); ?></h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>

<h2><?php _e('Archives by Subject:','nikynik'); ?></h2>
  <ul>
     <?php wp_list_cats(); ?>
  </ul>

</div>	</div>
<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>
