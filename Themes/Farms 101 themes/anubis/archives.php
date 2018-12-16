<?php


/*


Template Name: Archives


*/


?>


<?php get_header(); ?>


<div id="left">


<div id="content" class="widecolumn">

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-anubis-top"); } ?>
<h2 class="pagetitle">Archive</h2>


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


