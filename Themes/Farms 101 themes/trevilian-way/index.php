<?php get_header(); ?>

<body id="body-index">

<div id="intro">
	
	<span id="site-description"><?php bloginfo('description'); ?></span>
	
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

<div id="index-wrap">
	
<div id="index-posts">

<?php
	$posts = get_posts('numberposts=1');
	foreach($posts as $post) : setup_postdata($post);
?>

	<div id="latest">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
		<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
		<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_excerpt(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
	</div>
	
	<div id="latest-meta">
		<span id="index-post-date-comment"><em><?php the_time('F d, Y'); ?></em> | <?php the_tags( '' . __( '| Tagged' ) . ' ', ', ', ''); ?><a id="post-comment-link" href="<?php the_permalink(); ?>#post-comments"><?php comments_number(__('0 Comments'),__('1 Comment'),__('% Comments')); ?></a></span>
		<span id="latest-continue"><a href="<?php the_permalink(); ?>" title="<?php _e('Continue reading');?> <?php the_title(); ?>"><?php _e('Continue reading');?> &raquo;</a></span>
		<span class="clearer"></span>
	</div>	
	
<?php
	endforeach;
?>

</div>

<div id="index-extra">
	<div class="widget-block-wide">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Index Top Right Only') ) : ?>
			
		<?php endif; ?>
	</div>
</div>

<div id="previous-posts">

	<div class="previous-posts-row">

	<?php
		$posts = get_posts('numberposts=3&offset=1');
		foreach($posts as $post) : setup_postdata($post);
	?>
		<div class="previous-post">
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<span class="previous-post-meta"><em><?php the_time('F d, Y'); ?></em>  <?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?>| <a href="<?php the_permalink(); ?>#post-comments"><?php comments_number('(0)','(1)','(%)'); ?></a></span>
		</div>
	<?php
		endforeach;
	?>
		
	</div>

	<div class="previous-posts-row">

	<?php
		$posts = get_posts('numberposts=3&offset=4');
		foreach($posts as $post) : setup_postdata($post);
	?>
		<div class="previous-post">
			<h2 class="post-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
			<?php the_excerpt(); ?>
			<span class="previous-post-meta"><em><?php the_time('F d, Y'); ?></em> <?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?>| <a href="<?php the_permalink(); ?>#post-comments"><?php comments_number('(0)','(1)','(%)'); ?></a></span>
		</div>
	<?php
		endforeach;
	?>
		
	</div>
	
	<span class="clearer"></span>
	
</div>
	
</div>

<?php get_footer(); ?>
