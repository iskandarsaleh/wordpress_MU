<?php
/*
Template Name: Links
*/
?>
<?php get_header(); ?>

<div id="content" class="widecolumn">
 <div id="navr">
  <ul class="menu">
    <li <?php if(is_home()){echo 'class="current_page_item"';}?>><a href="<?php bloginfo('siteurl'); ?>/" title="Home">Home</a></li>
    <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
	<?php wp_register('<li class="admintab">','</li>'); ?>
   </ul>
</div>
 <div id="headr">
    <h1><a href="<?php echo get_option('home'); ?>/">
      <?php bloginfo('name'); ?>
      </a></h1>
    <div class="description">
      <?php bloginfo('description'); ?>
    </div>
  </div>


  <h2><?php _e('Links:');?></h2>
  <ul>
    <?php get_links_list(); ?>
  </ul>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
