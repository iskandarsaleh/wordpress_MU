<?php get_header(); ?>

<body id="body-page">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>
	
<div id="intro">
	
	<span id="page-id">page</span>
	
	<div id="identity">
		
		<h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		<div id="main-nav">
			<ul>
			<?php
				wp_list_pages('title_li=&sort_column=menu_order&depth=1');
			?>
			</ul>
		</div>
		
	</div>
		
	<?php include (TEMPLATEPATH . "/searchform.php"); ?>
	
	<span class="clearer"></span>

</div>

<div id="summary">

	<div class="page-summary">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
		<h2 class="page-title"><?php the_title(); ?></h2>
	</div>	
	
	<span class="clearer"></span>

</div>	

<div id="post-content">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
</div>

<div id="discussion-area">

	<div id="post-comments">	
		<?php comments_template(); ?>
	</div>
	
</div>
	
<?php endwhile; ?>

<?php else : ?>

	<h2><?php _e('Not Found');?></h2>
	<p><?php _e("Sorry, but you are looking for something that isn't here.");?></p>

<?php endif; ?>

<?php get_footer(); ?>
