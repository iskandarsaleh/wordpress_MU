<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="contentcontainer">

<div class="blogbefore">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<div class="post"><div style="overflow: hidden;">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-vistered-top"); } ?>
<?php
if( !function_exists('mfg_show_wordpress_search_results') 
	|| mfg_show_wordpress_search_results() ) {
	?>
<!-- google_ad_section_start -->
<?php
	if ( have_posts() ) : 
		?><h1><?php
			_e('Posts related to', VL_DOMAIN );
			?> <em><?php
				echo attribute_escape( stripslashes($_GET['s']) ); 
			?></em><?php
		?></h1><?php
		?><div class="headertext"></div><?php
		while ( have_posts() ) :
			the_post();
	
			?><div style="margin-bottom: 2em;"><?php
				?><h1><a href="<?php the_permalink(); ?>" title="Permalink for <?php the_title(); ?>"><?php the_title(); ?></a></h1><?php
				?><div class="headertext"><?php
					_e('Posted on', VL_DOMAIN );
					echo ' ';
					the_date(); 
					echo ' ';
					_e('by', VL_DOMAIN); 
					?> <a href="<?php 
						echo get_author_posts_url( get_the_author_ID() );
					?>"><?php the_author(); ?></a>. <?php
					edit_post_link( __('edit', VL_DOMAIN) ); 
					?><br /><?php 
					_e('Categories:', VL_DOMAIN);
					echo ' ';
					the_category( ', ' ); 
					?>.</div><?php
				?><div style="margin-left: 2em;"><?php 
					the_excerpt();
				?></div><?php
			?></div><?php
		endwhile; 
	else:
		?><h1><?php
			_e('There are no posts relating to', VL_DOMAIN );
			?> <em><?php
				 echo attribute_escape( stripslashes($_GET['s']) );
			?></em><?php
		?>.</h1><?php
		?><div class="headertext"></div><?php
	endif;
	?>
<!-- google_ad_section_end -->
<?php
}

if( function_exists('mfg_show_results') ) {
	mfg_show_results();
}
?>
</div>
</div>
<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>

<?php get_footer(); ?>