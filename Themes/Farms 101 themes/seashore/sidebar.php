	<div id="sidebar1" class="sidecol">
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x200-seashore-sidebar"); } ?>
	<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
<li>
	<h2><?php _e('Latest Posts'); ?></h2>
	<ul><?php wp_get_archives("type=postbypost&limit=6")?></ul>
</li>
<li>
    <h2><?php _e('Feed on');?></h2>
    <ul>
      <li class="feed"><a title="<?php _e('RSS Feed of Posts');?>" href="<?php bloginfo('rss2_url'); ?>">Posts RSS</a></li>
      <li class="feed"><a title="<?php _e('RSS Feed of Comments');?>" href="<?php bloginfo('comments_rss2_url'); ?>">Comments RSS</a></li>
    </ul>
  </li>
<li>
  <h2><?php _e('Search'); ?></h2>
	<form id="searchform" method="get" action="<?php bloginfo('siteurl')?>/">
		<input type="text" name="s" id="s" class="textbox" value="<?php echo wp_specialchars($s, 1); ?>" />
		<input id="btnSearch" type="submit" name="submit" value="<?php _e('Go'); ?>" />
	</form>
  </li>  
<?php get_links_list(); ?>      
<?php endif; ?>
</ul>
</div>

<div id="sidebar2" class="sidecol">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x200-seashore-sidebar"); } ?>
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
  <li>
    <h2>
      <?php _e('Categories'); ?>
    </h2>
    <ul>
      <?php wp_list_cats('optioncount=1&hierarchical=1');    ?>
    </ul>
  </li>
  <li>
    <h2>
      <?php _e('Monthly'); ?>
    </h2>
    <ul>
      <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
    </ul>
  </li>
  <li>
    <h2><?php _e('Pages'); ?></h2>
    <ul>
      <?php wp_list_pages('title_li=' ); ?>
    </ul>
  </li>
	<li>
      <h2><?php _e('Meta');?></h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
			<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
			<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>
			<?php wp_meta(); ?>
		</ul>			
   </li>
    <?php endif; ?>
</ul>
</div>
<div style="clear:both;"></div>