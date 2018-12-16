<?php /*
Template Name: Tag Archive
*/ ?>
<?php get_header(); ?>
<?php get_sidebar(); ?>


<div id="contentcontainer">
<?php if ( have_posts() ) { while ( have_posts() ) { the_post(); ?>

	<div class="blogbefore">
		<div class="left"></div>
		<div class="right"></div>
		<div class="middle"></div>
	</div>
	<div class="post"><div style="overflow: hidden;">
	<!-- google_ad_section_start -->
	<h3><a href="<?php the_permalink(); ?>" title="Permalink for <?php the_title(); ?>"><?php the_title(); ?></a></h3>
	<div class="headertext"><?php edit_post_link('edit.'); ?></div>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php
	the_content(); 
	if( function_exists( 'UTW_ShowWeightedTagSetAlphabetical' ) ) {
		UTW_ShowWeightedTagSetAlphabetical("coloredsizedtagcloud","",0);
	}
	else {
		?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><p><?
		_e( 'Well, you should be seeing a pretty nifty tag cloud here, however it looks like someone has disabled it and forgot to hide/delete this page.', VL_DOMAIN ); 
		?></p><?php
	}
	?>
<p class="postlinks">
<?php next_post_link('%link', '<span class="right">%title &raquo;</span>'); ?>
<?php previous_post_link('%link', '<span class="left">&laquo; %title</span>'); ?>
</p>
</div></div>

<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>

<?php comments_template(); }} ?>

<?php get_footer(); ?>
