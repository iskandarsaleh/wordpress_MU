<div id="sidebar1" class="sidecol">
<ul>
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
<li>
	<h3><?php _e('Latest Posts'); ?></h3>
	<ul><?php wp_get_archives("type=postbypost&limit=6")?></ul>
</li>
<li>
  <h3><?php _e('Search'); ?></h3>
	<form id="searchform" method="get" action="<?php bloginfo('siteurl')?>/">
		<input type="text" name="s" id="s" class="textbox" value="<?php echo wp_specialchars($s, 1); ?>" />
		<input id="btnSearch" type="submit" name="submit" value="<?php _e('Go'); ?>" />
	</form>
  </li>  
<?php if (is_home()) wp_list_bookmarks('title_li='); ?>      
<?php endif; ?>
</ul>
</div>

<div id="sidebar2" class="sidecol">
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>
<li>
  <h3><?php _e('About'); ?></h3>
  <p><?php query_posts('pagename=about'); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php the_excerpt(); ?>
<?php edit_post_link(__('Edit'), '<p>', '</p>'); ?>
<?php endwhile; ?>
<?php endif; ?></p>
</li>
  <li>
    <h3>
      <?php _e('Categories'); ?>
    </h3>
    <ul>
      <?php wp_list_cats('optioncount=1&hierarchical=1');    ?>
    </ul>
  </li>
  <?php if (function_exists('wp_tag_cloud')) {	?>
	<li >	
		<h3><?php _e('Tags'); ?></h3>
		<p><?php wp_tag_cloud(); ?></p>
	</li>
  <?php } ?>
  <li>
    <h3>
      <?php _e('Monthly'); ?>
    </h3>
    <ul>
      <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
    </ul>
  </li>
  <li>
    <h3><?php _e('Pages'); ?></h3>
    <ul>
      <?php wp_list_pages('title_li=' ); ?>
    </ul>
  </li>
	<li>
      <h3>Meta</h3>
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