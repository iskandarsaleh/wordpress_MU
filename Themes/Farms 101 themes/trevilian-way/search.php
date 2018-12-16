<?php get_header(); ?>

<body id="body-searc">

<div id="intro">
	
	<span id="page-id">search</span>
	
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

	<div class="post-summary">
		<h2 class="page-title"><?php _e('Results');?></h2>
	</div>	
	
	<span class="clearer"></span>

</div>

<div id="post-content">

<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>

	<div class="archive-post">
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<?php the_excerpt(); ?>
	
		<div class="archive-meta">
			<span class="archive-post-date-comment"><em><?php the_time('F d, Y'); ?></em> | <a class="archive-post-comment-link" href="<?php the_permalink(); ?>#post-comments"><?php comments_number(__('0 Comments'),__('1 Comment'),__('% Comments')); ?></a></span>
			<span class="latest-continue"><a href="<?php the_permalink(); ?>" title="<?php _e('Continue reading');?> <?php the_title(); ?>"><?php _e('Continue reading');?> &raquo;</a></span>
			<span class="clearer"></span>
		</div>
	</div>
	
<?php endwhile; ?>

<?php else : ?>

	<p><?php _e('Sorry, nothing can be found.');?></p>

<?php endif; ?>

</div>

<?php get_footer(); ?>
