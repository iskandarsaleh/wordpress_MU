<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
<?php $post_name = $post->post_name; ?>
<?php endwhile; endif; ?> 


<? if(get_option('commentpress_page_enabled') && !($post_name = 'comments-by-section' || $post_name = 'comments-by-user' || $post_name = 'general-comments' ) ): ?>
<?	include('single.php'); ?>
<? else: ?>
<?php get_header(); ?>

<!-- SIDEBAR -->
<?php 
 $skin = get_option('skin');  // commentpress_setting is a string
 include(TEMPLATEPATH ."/skins/".$skin."/sidebar.php"); 
?>

<!-- BEGIN PAGE CONTAINER -->
	<div id="page">
	<!-- START Loop --> 
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?> 
	<?php
		switch($post->post_name){
			case 'comments-by-section':
				include('comments-by-section.php');
			break;
		
			case 'comments-by-user':
				include('comments-by-user.php');
			break;
							
			case 'general-comments':
				include('general-comments.php');						
			break;
			default:
			?>	
			<!-- START THE PAGE -->
			<div id="content"> 
				<div class="post" id="post-<?php the_ID(); ?>"> 
					<h2><?php the_title(); ?></h2> 
					<div class="entrytext">
					<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
					<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?> 
					<!-- END entrytext --> 
					</div>
				<!-- end post -->	
				</div> 
			<!-- end pages_leftCol -->
			

			<?
			break;				
		}
	?> 
	<!-- END Loop --> 
	<?php endwhile; endif; ?> 
	</div>
</div>

<?php get_footer(); ?>
<? endif; ?>

