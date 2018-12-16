<!-- begin sidebar --><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("18090linkunitshadow"); } ?>

<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
<li><h2><?php _e('Pages');?></h2>
<ul><?php wp_list_pages('title_li='); ?></ul></li>

<li><h2><?php _e('Recent Posts');?></h2>
<ul><?php wp_get_archives('type=postbypost&limit=10'); ?></ul></li>

<?php get_links_list(); ?>


<li><h2><?php _e('Categories');?></h2>
<ul><?php wp_list_cats(); ?></ul></li>



<li><h2><?php _e('Archives');?></h2>
<ul><?php wp_get_archives('type=monthly'); ?></ul></li>


<li><h2><?php _e('Meta');?></h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="feed:<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
<li><a href="feed:<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>
<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>
<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>"><abbr title="WordPress">WP</abbr></a></li>
<?php wp_meta(); ?>
</ul></li>

<li><h2><?php _e('Search');?></h2>
<ul><li>
<form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="text" name="s" id="s" size="15" /><br />
<input type="submit" value="<?php _e('Search'); ?>" />
</form></li></ul></li>
<?php endif; ?>

</ul>

<!-- end sidebar -->
