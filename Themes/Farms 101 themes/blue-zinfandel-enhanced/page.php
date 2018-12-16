<?php get_header(); ?>

<div id="content">

<?php include(TEMPLATEPATH."/l_sidebar.php");?>

<div id="contentmiddle">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
	<h1><?php the_title(); ?></h1><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	<?php the_content(__('Read more'));?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	<!--
	<?php trackback_rdf(); ?>
	-->

	<?php endwhile; else: ?>

	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
	</div>
	
<?php include(TEMPLATEPATH."/r_sidebar.php");?>
	
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>