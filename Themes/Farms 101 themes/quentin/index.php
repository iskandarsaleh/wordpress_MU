<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title(); ?> <?php bloginfo('name'); ?></title>



	<style type="text/css" media="screen">
		@import url( <?php bloginfo ('stylesheet_url' ); ?>  );
	</style>
	
	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
	
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

	<?php wp_head(); ?>
</head>

<body>
<div id="rap">
<div id="header">
<h1><a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?></a></h1>
<h3 class="description"><?php bloginfo('description'); ?></h3>
</div>


<div id="content">
<?php if (have_posts()) : while ( have_posts()) : the_post(); ?>

	
<div class="post">
<h2 class="storytitle" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e('Permanent Link:');?> <?php the_title(); ?>"><?php the_title(); ?></a></h2>

	
<div class="storycontent">
<div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?></div>
<?php the_content(); ?>
<div align="center"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336280graphite"); } ?></div>
</div>
<div class="meta"><?php if (!is_page()) { ?><?php _e("Published in:"); ?> <?php the_category() ?><?php } else { _e("Published"); } ?> <?php _e('on');?> <?php the_date('','',''); ?> <?php _e('at');?> <?php the_time() ?> <?php comments_popup_link(__('Comments (0)'), __('Comments (1)'), __('Comments (%)')); ?>
<br />
<?php the_tags(__('Tags: '), ', ', '<br />'); ?>
</div>
<img src="<?php bloginfo('stylesheet_directory'); ?>/images/printer.gif" width="102" height="27" class="pmark" alt=" " />


<div class="feedback">
<?php wp_link_pages(); ?>
</div>

<?php comments_template (); ?> 
</div>

<?php endwhile; ?>

	<div class="navigation">
		<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries')) ?></div>
		<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;')) ?></div>
	</div>

<?php else: ?>
<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
</div>



<div id="menu">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitgraphite"); } ?>
<ul>
<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar() ) : ?>
<li id="calendar">
	<?php get_calendar(); ?>
</li> 
<li id="search">
<form id="searchform" method="get" action="<?php bloginfo('home'); ?>/">
<input type="text" name="s" id="s" size="8" /> <input type="submit" name="submit" value="<?php _e('Search'); ?>" id="sub" />
</form>
</li>




<li id="categories"><?php _e('Categories:'); ?>
	<ul>
	<?php wp_list_cats(); ?>
	</ul>
</li>
 


<li id="archives"><?php _e('Archives:'); ?>
 	<ul>
	 <?php wp_get_archives('type=monthly'); ?>
 	</ul>
</li>


<?php get_links_list(); ?>
 

<?php endif; ?>
</ul>

</div> 

<div id="footer">
<p class="credit">

<cite><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr> 2.0'); ?></a>
| <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr> 2.0'); ?></a>
| Theme: <a href="http://www.pikemurdy.com/quentin" rel="designer"><em>Quentin</em></a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.
</p>


</div></div>

<?php do_action('wp_footer'); ?>

</body>
</html>
