<?php get_header(); ?>

	<div id="content" class="narrowcolumn">

    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post">
		<h2 id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			<div class="entrytext">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>			<?php the_content(__('Read the rest of this entry &raquo;','nikynik')); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<?php link_pages(__('<p><strong>Pages:</strong> ','nikynik'), '</p>', __('number','nikynik')); ?>
	
			</div>
		</div>
	  <?php endwhile; endif; ?>
	</div>

<?php if(function_exists("se_get_sidebar")){se_get_sidebar();}else{get_sidebar();} ?>
<?php get_footer(); ?>