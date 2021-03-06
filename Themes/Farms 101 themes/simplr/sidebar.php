<div id="col1" class="sidebar">
	<ul>
<?php /* FUNCTION FOR WIDGETS */ if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(1) ) : ?>
<?php /* BEGIN SPECIFIC SIDEBAR CONTENT / IF FRONT PAGE */ if ( is_home() ) { ?>
		<li id="recent-posts">
			<h2><?php _e('Previous Posts');?></h2>
			<ul>
<?php 
$posts = get_posts('numberposts=5&offset=1');
	foreach($posts as $post) :
	setup_postdata($post);
?>
				<li>
					<a href="<?php the_permalink() ?>" title="<?php _e('Continue reading');?> <?php the_title(); ?>" rel="bookmark"><strong><?php the_title(); ?></strong><br/><em><?php the_content_rss('', TRUE, '', 10); ?></em><br/><small><?php the_time(__('F jS, Y')); ?> <?php comments_number('| No comments yet','| Comments (1)','| Comments (%)', 'number'); ?></small></a>
				</li>
<?php endforeach; ?>
			</ul>
		</li>
		<li id="recent-comments">
			<h2><?php _e('Recent Comments');?></h2>
			<?php simplr_src(5, 75, '', ''); ?>
			<?php /* YOU CAN CHANGE VARIABLES FOR THE RECENT COMMENTS. (X, Y, 'BEFORE', 'AFTER') WHERE X=NUMBER OF COMMENTS, Y=COMMENT LENGTH, BEFORE=TEXT BEFORE, AND AFTER=TEXT AFTER */ ?>
		</li>
<?php } /* IF THIS MONTH, DAY, OR YEAR ARCHIVE */ elseif ( is_month() || is_day() || is_year() ) { ?>
		<li id="archive-archives">
			<h2><a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('name'); ?>"> <?php _e('Home');?></a> > <?php the_time('F Y'); ?></h2>
			<p><?php _e('You are currently browsing the archives for');?> <?php the_time('F Y'); ?>.</p>
		</li>

<?php } /* IF THIS IS A  CATEGORY PAGE */ elseif ( is_category() ) { ?>
		<li id="category-archives">
			<h2><a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php _e('Home');?></a> > <?php single_cat_title(''); ?></h2>
			<p><?php echo category_description(); ?></p>
		</li>

<?php } /* IF THIS IS A  CATEGORY PAGE */ elseif ( is_search() ) { ?>
		<li id="searched">
			<h2><a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php _e('Home');?></a> > <?php _e('Search Results');?></h2>
			<p>Query completed for &#8220;<strong><?php echo wp_specialchars($s); ?></strong>&#8221;</p>
		</li>

<?php } /* IF PAGE  */ if ( is_page() ) { ?>
		<li id="page-top">
			<h2><a href="<?php echo get_settings('home'); ?>/" title="<?php bloginfo('name'); ?>"><?php _e('Home');?></a> > <?php the_title(); ?></h2>
			<p><?php if (have_posts()) : while (have_posts()) : the_post(); ?> <?php _e('Posted on');?> <?php the_time('l, F jS, Y') ?><?php endwhile; endif; ?></p>
		</li>

<?php } /* END OF IF FOR SPECIFIC SIDEBAR CONTENT */ ?>
<?php endif; /* END FOR WIDGETS CALL */ ?>
	</ul>
</div><!-- END COL1 / SIDEBAR -->

<div id="col2" class="sidebar">
	<ul>
<?php /* FUNCTION FOR WIDGETS */ if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(2) ) : ?>
<?php if ( is_home() ) { // SHOWS THE ABOUT TEXT, IF SELECTED IN THE THEME OPTIONS MENU
	simplr_aboutheader();
	simplr_abouttext();
} ?>
		<li id="search">
			<h2><label for="s"><?php _e('Search')?></label></h2>
			<ul>
				<li><?php include (TEMPLATEPATH . '/searchform.php'); ?></li>
			</ul>
		</li>
<?php /* BEGIN SPECIFIC SIDEBAR CONTENT / IF THIS IS THE FRONT PAGE, 404, OR SEARCH PAGE */ if ( is_home() ) { ?>
		<li id="category-links">
			<h2><?php _e('Categories');?></h2>
			<ul>
				<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>
			</ul>
		</li>

<?php } /* BEGIN SPECIFIC SIDEBAR CONTENT / IF THIS IS THE HOME */ if ( is_home() ) { ?>
		<li id="feed-links">
			<h2><?php _e('RSS Feeds');?></h2>
			<ul>
				<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Subscribe to the');?> <?php bloginfo('name'); ?> posts feed" rel="alternate" type="application/rss+xml">Posts RSS 2.0 <img src="<?php bloginfo('stylesheet_directory'); ?>/icons/feed.png" alt="XML" /></a></li>
				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('Subscribe to the');?> <?php bloginfo('name'); ?> comments feed" rel="alternate" type="application/rss+xml">Comments RSS 2.0 <img src="<?php bloginfo('stylesheet_directory'); ?>/icons/feed.png" alt="XML" /></a></li>
			</ul>
		</li>
		<li id="meta-links">
			<h2><?php _e('Meta');?></h2>
			<ul>
				<?php wp_register(); ?>
				<li><?php wp_loginout(); ?></li>
				<?php wp_meta(); ?>
			</ul>
		</li>

<?php } /* END OF IF FOR SPECIFIC SIDEBAR CONTENT */ ?>
<?php endif; /* END FOR WIDGETS CALL */ ?>
	</ul>
</div><!-- END COL1 / SIDEBAR -->