<?php get_header(); ?>
<?php get_sidebar(); ?>

<div id="contentcontainer">

<?php 
if ( have_posts() ) :
	$post_count = 0; 
	while ( have_posts() ) : 
		++$post_count;
		if( $post_count == 2 ) {
			if ( vl_widget_count(__('2nd Banner', VL_DOMAIN)) > 0 ) {	
				?><div class="blogbefore"><?php
					?><div class="left"></div><?php
					?><div class="right"></div><?php
					?><div class="middle"></div><?php
				?></div><?php
				dynamic_sidebar(__('2nd Banner', VL_DOMAIN));
				?><div class="blogafter"><?php
					?><div class="left"></div><?php
					?><div class="right"></div><?php
					?><div class="middle"></div><?php
				?></div><?php
			}
		}
		else if( $post_count == 5 ) {
			if ( vl_widget_count(__('3rd Banner', VL_DOMAIN)) > 0 ) {	
				?><div class="blogbefore"><?php
					?><div class="left"></div><?php
					?><div class="right"></div><?php
					?><div class="middle"></div><?php
				?></div><?php
				dynamic_sidebar(__('3rd Banner', VL_DOMAIN));
				?><div class="blogafter"><?php
					?><div class="left"></div><?php
					?><div class="right"></div><?php
					?><div class="middle"></div><?php
				?></div><?php
			}
		}
		the_post(); ?>

<div class="blogbefore">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<div class="post"><div style="overflow: hidden;">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-vistered-top"); } ?>
<?php
if( is_page() ) {
?>
	<h1><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink for', VL_DOMAIN);?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>
<div class="headertext"><?php edit_post_link('edit.'); ?></div>
<?php
	if( function_exists('smart_pages') ) {
		$links = smart_pages();
		if( isset( $links[ 'back' ] ) ) echo $links[ 'back' ];
	}
}
else { ?>
<h1><a href="<?php the_permalink(); ?>" title="<?php _e('Permalink for', VL_DOMAIN);?> <?php the_title(); ?>"><?php the_title(); ?></a></h1>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860ink"); } ?>
<div class="headertext"><?php 
	_e('Posted on', VL_DOMAIN);
	echo ' ';
	the_date(); 
	echo ' ';
	if( !function_exists('get_theme_option')
		|| get_theme_option('showauthor') != "hide" ) {
	_e('by', VL_DOMAIN); 
	?> <a href="<?php 
		if( function_exists('get_author_posts_url')) {
			echo get_author_posts_url( get_the_author_ID() ); 
		}
		else {
			get_author_link( true, get_the_author_ID() );
		}
	?>"><?php the_author(); ?></a>. <?php
	}
	edit_post_link(__('edit.', VL_DOMAIN )); 
	?><br /><?php 
	_e('Categories', VL_DOMAIN);
	?>: <?php
	the_category(', ') 
	?>.</div><?php
} 
the_content(); 
?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860ink"); } ?><!-- google_ad_section_end --><?php 
if( is_page() ) {
	if( function_exists('smart_pages') ) {
		$links = smart_pages();
		if( isset( $links[ 'children' ] ) ) echo '<ul>' . $links[ 'children' ] . '</ul>';
		if( isset( $links[ 'back' ] ) ) echo $links[ 'back' ];
	}
}
?><div class="page-links"><?php
$next = wp_link_pages(array('nextpagelink' => __('Next',VL_DOMAIN),
					'previouspagelink' => __('Previous',VL_DOMAIN),
					'before' => '', 
					'after' => '', 
					'next_or_number' => 'next',
					'echo' => 0 ));

wp_link_pages(array('before' => '<p><strong>' . __('Pages:', VL_DOMAIN) . '</strong> ', 
					'after' => ' ' . $next . '</p>', 
					'next_or_number' => 'number'));
?></div><?php

?><div class="footeritems"><?php
	if( !function_exists('dynamic_sidebar') || !dynamic_sidebar( __('End Of Post', VL_DOMAIN) ) ) {
		$widget_args = array(
	        'before_widget' => '<div class="footer-item">',
	        'after_widget' => '<div>'
	    );
	    
		if(function_exists('vl_miniwidget_print')) {
			vl_miniwidget_print($widget_args);
		} 
		if( function_exists( 'vl_miniwidget_sociable' ) ) { 
			vl_miniwidget_sociable($widget_args);
		}	
		if( function_exists( 'vl_miniwidget_jeromes_keywords' ) ) {
			vl_miniwidget_jeromes_keywords($widget_args);
		}
		if( function_exists( 'vl_miniwidget_bunny_tags' ) ) {
			vl_miniwidget_bunny_tags($widget_args); 
		}
		if( function_exists('vl_miniwidget_utw_primary')) {
			vl_miniwidget_utw_primary($widget_args);
		}
		if( function_exists('vl_miniwidget_utw_related')) {
			vl_miniwidget_utw_related($widget_args);
		}
		if( function_exists( 'vl_miniwidget_morefromgoogle' ) ) {
			vl_miniwidget_morefromgoogle($widget_args);
		}
	}
	?><p class="footertext"><?php
	if( comments_open() ) {
	if(!is_single() && !is_page()) {
		comments_popup_link(__('no comments yet.', VL_DOMAIN),
							__('1 comment.', VL_DOMAIN), 
							__('% comments.', VL_DOMAIN) ); 			
	} 
	else {	
		comments_number(__('no comments yet.', VL_DOMAIN),
						__('1 comment.', VL_DOMAIN),
						__('% comments.', VL_DOMAIN) );
	}
	}
	?></p><?php 
?></div><?php
?><p class="postlinks"><?php
	next_post_link('%link', '<span class="right">%title &raquo;</span>');
	previous_post_link('%link', '<span class="left">&laquo; %title</span>');
?></p>
</div></div>

<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<?php
if( function_exists( 'yatcp_comments_template' ) ) {
	yatcp_comments_template();
}
else {
	comments_template();
}
?>

<?php endwhile; else:  ?>

<div class="blogbefore">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<div class="post">
<h3><?php _e('There are no posts relating to your query.', VL_DOMAIN); ?></h3>
</div>
<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>

<?php endif; ?>

<?php get_footer(); ?>
