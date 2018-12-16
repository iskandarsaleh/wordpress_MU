<?php
/*
Template Name: Archives
*/
?>

<?php get_header(); ?>

<div class="entry">

<h2><?php _e('Archives');?></h2>
<ul>
<?php get_archives('monthly', '', 'html', '', '', TRUE); ?>
</ul>

</div>	

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
