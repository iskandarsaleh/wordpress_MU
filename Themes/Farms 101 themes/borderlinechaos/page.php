<?php get_header(); ?>
<div id="sidebar">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-borderline-sidebar"); } ?>
	<div id="sidebox">
<div class="title"><?php bloginfo('description'); ?></div></div>
<br />
<div id="sidebox1">
			<div class="title">Pages</div>
<ul>
<?php wp_list_pages('title_li='); ?>
</ul>
</div>
</div>

<div id="contentwrapper">

<div id="content">
<br /><br />
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280-borderline-top"); } ?>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post">
		<h2 class="posttitle" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h2>
			<div class="entrytext">
			
				<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>
			
	<br />
				<?php link_pages('<p><strong>'.__('Pages:').'</strong> ', '</p>', 'number'); ?>
		<div class="navigation">

			<a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">« <?php _e('Return Home');?></a></div>
			</div>
		</div>
	  <?php endwhile; endif; ?>
	<?php edit_post_link(__('Edit this entry.'), '<p>', '</p>'); ?>

	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-borderline-bottom"); } ?>
	</div></div>

<?php get_footer(); ?>