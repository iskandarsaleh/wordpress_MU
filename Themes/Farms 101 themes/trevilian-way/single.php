<?php get_header(); ?>

<body id="body-single">

<?php if (have_posts()) : ?>

<?php while (have_posts()) : the_post(); ?>
	
<div id="intro">
	
	<span id="post-id"><?php the_ID(); ?></span>
	
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
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("46860nocolor"); } ?>
		<h2 class="post-title"><?php the_title(); ?></h2>
		<?php the_excerpt(); ?>
	</div>	
	
	<!--[if lt IE 7]>
	<div id="ie6only">
	<![endif]-->
	
	<ul id="post-info">
		<li>Post Information
			<ul>
				<li id="post-meta">
					<span class="post-date">Date: <strong><?php the_time('l, F d, Y'); ?></strong></span>
					<span class="post-time">Time: <em><?php the_time(); ?></em></span>
					<span class="post-category">Category: <?php the_category(', '); ?>
					<span class="post-category"><?php the_tags( '' . __( 'Tagged' ) . ' ', ', ', ''); ?></span>
					<span>Discussion: <strong><a id="post-comment-link" href="#post-comments"><?php comments_number(__('0 Comments'),__('1 Comment'),__('% Comments')); ?></a></strong></span>
				</li>
			</ul>
		</li>
	</ul>

	<ul id="post-nav">
		<li>Post Navigation
			<ul>
				<li class="nav-prev-post"><?php previous_post_link('&laquo; %link') ?></li>
				<li class="nav-next-post"><?php next_post_link('%link &raquo;') ?></li>
			</ul>
		</li>
	</ul>
	
	<!--[if lt IE 7]>
	</div>
	<![endif]-->
	<span class="clearer"></span>

</div>	

<div id="post-content">
<!--[if IE]>
<div id="ie-post-content-inner">
<![endif]-->
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?><?php the_content(); ?><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280nocolor"); } ?>
<!--[if IE]>
</div>
<![endif]-->
</div>
<span class="clearer"></span>
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
