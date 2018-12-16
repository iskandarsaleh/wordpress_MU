<?php
/*

Template Name: About

*/
?>
<?php get_header(); ?>

<div id="content" class="narrowcolumn">
<div class="post">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php endwhile; endif; ?>

</div>	</div>
<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>
