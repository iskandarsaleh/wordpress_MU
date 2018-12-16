  <div id="left_side">
  
  <?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar(1) ) : ?>
		
		
		      <div class="block block-user">
<?php if (function_exists('wp_theme_switcher')) { ?>

<h3>Themes</h3>

<?php wp_theme_switcher('dropdown'); ?>

<?php } ?>
   
 </div>
 
 
        <div class="block block-user">
   <h3><?php _e('Categories');?></h3>

<ul>

<?php wp_list_cats('sort_column=name&hierarchical=0'); ?>

</ul>
   
 </div>
 
 
      <div class="block block-user">
	  
	  <h3><?php _e('Archives');?></h3>

<ul>
<?php wp_get_archives('type=monthly'); ?>

</ul>
  
   
 </div>
 
 
      <div class="block block-user">
 
 <h3><?php _e('Meta:'); ?></h3>

<ul>

<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><?php _e('<abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>

<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>

<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional'); ?>"><?php _e('Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr>'); ?></a></li>

<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>

<?php wp_meta(); ?>

</ul>

 </div>
  
  <?php endif; ?>
  
  </div>
  
