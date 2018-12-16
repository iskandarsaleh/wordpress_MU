<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>

<div id="content" class="widecolumn">
   <div id="pre">
 <div id="headr">
    <h1><a href="<?php echo get_option('home'); ?>/">
      <?php bloginfo('name'); ?>
      </a></h1>
    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>
</div>


  <div class="post">
  <h2><?php _e('Archives by Month:');?></h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>
  <h2><?php _e('Archives by Subject:');?></h2>
  <ul>
    <?php wp_list_categories(); ?>
  </ul>
  </div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
