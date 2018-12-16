<?php get_header(); ?>

<div id="content">

<div id="contentleft">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<h1><?php the_title(); ?></h1>
	<p><?php _e('Posted on');?> <?php the_time('F j, Y'); ?>&nbsp;<?php edit_post_link(__('Edit Post'), '', ''); ?><br /><?php _e('Filed under');?> <?php the_category(', ') ?> <?php the_tags( '' . __( ' and tagged' ) . ' ', ', ', ''); ?></p>  
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(__('Read more'));?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><div style="clear:both;"></div>
 			
	<!--
	<?php trackback_rdf(); ?>
	-->
	
	<?php endwhile; else: ?>
	
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
	
	<h3><?php _e('Comments');?></h3>
	<?php comments_template(); // Get wp-comments.php template ?>

	</div>
	
<?php include(TEMPLATEPATH."/l_sidebar.php");?>

<?php include(TEMPLATEPATH."/r_sidebar.php");?>

</div>

<!-- The main column ends  -->

<?php get_footer(); ?>