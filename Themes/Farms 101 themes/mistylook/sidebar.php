<div id="sidebar">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160-x-600-mistylook-sidebar"); } ?>
<ul>



<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
<li class="sidebox">
	<h2><?php _e('Archives'); ?></h2>
	<ul><?php wp_get_archives('type=monthly&show_post_count=true'); ?></ul>
</li>

<li class="sidebox">
	<h2><?php _e('Categories'); ?></h2>
	<ul>
		<?php 
		if (function_exists('wp_list_categories')) 
		{	
			wp_list_categories('show_count=1&title_li='); 
		}
		else 
		{   
			wp_list_cats('optioncount=1');  
		}  
		?>
	</ul>		
</li>

<li class="sidebox">
	<h2><?php _e('Pages'); ?></h2>
	<ul><?php wp_list_pages('title_li=' ); ?></ul>	
</li>
<li class="sidebox">
<ul><?php if ( is_home() ) { get_links_list(); } ?></ul>
</li>
<li class="sidebox">
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
  <?php endif; ?>
</ul>
</div><!-- end id:sidebar -->
</div><!-- end id:content -->
</div><!-- end id:container -->
