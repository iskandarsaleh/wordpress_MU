<div id="sidebar"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
<ul>
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
<?php if(is_home()) { ?>
<li>
	<h2><?php _e('About'); ?></h2>
	<p>
	<img src="<?php bloginfo('stylesheet_directory');?>/images/profile.jpg" alt="Profile" class="profile" />
	<strong><?php bloginfo('name');?></strong><br/><?php bloginfo('description');?>	
	</p>	
</li>
<? } ?>
<li>
	<h2><?php _e('Archives'); ?></h2>
	<ul><?php wp_get_archives('type=monthly&show_post_count=true'); ?></ul>
</li>

<li>
	<h2><?php _e('Tags'); ?></h2>
	<ul>
		<?php 
      if (function_exists('wp_list_categories')) 
        wp_list_categories('title_li=&show_count=1'); 
      else
        wp_list_cats('optioncount=1');    
    ?>
	</ul>		
</li>

<li>
	<h2><?php _e('Pages'); ?></h2>
	<ul><?php wp_list_pages('title_li=' ); ?></ul>	
</li>
<?php if(is_home()) { terrafirma_ShowLinks(); ?>
  <li>
	<h2><?php _e('Feed on RSS'); ?></h2>
	<ul class="feeds">
		<li>
			<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Posts Feed'); ?>"><?php _e('Posts Feed'); ?></a>
		</li>
		<li>
			<a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('Posts Feed'); ?>"><?php _e('Comments Feed'); ?></a>
		</li>
	</ul>
</li>
<li>
	<h2><?php _e('Meta'); ?></h2>
	<ul>
		<?php wp_register(); ?>
		<li><?php wp_loginout(); ?></li>
		<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
		<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>
		<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>
		<?php wp_meta(); ?>
	</ul>	
</li>
<?php }?>
  <?php endif; ?>
</ul>
</div><!-- end id:sidebar -->