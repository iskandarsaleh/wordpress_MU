<div id="sidebar">
  <div class="side2"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitink"); } ?>
    <ul>
  	  <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar() ) : else : ?>
     	  <li class="linkside">
	  <h2>List Pages</h2>
	   <ul class="menu">
    <li <?php if(is_home()){echo 'class="current_page_item"';}?>><a href="<?php bloginfo('siteurl'); ?>/" title="Home">Home</a></li>
    <?php wp_list_pages('sort_column=menu_order&depth=1&title_li='); ?>
	<?php wp_register('<li class="admintab">','</li>'); ?>
   </ul>
	  </li>
	  <li class="linkside">
	    <h2>Archives</h2>
        <ul>
          <?php wp_get_archives('type=monthly'); ?>
        </ul>
      </li>
      <?php wp_list_categories('show_count=1&title_li=<h2>Categories</h2>'); ?>
      <?php /* If this is the frontpage */ if (is_home()) { ?>
      <?php wp_list_bookmarks(); ?>
      <?php } ?>
	  <li class="linkside">
	   <h2>Meta</h2>
        <ul>
          <?php wp_register(); ?>
          <li>
            <?php wp_loginout(); ?>
          </li>
          <li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>
          <li><a href="http://gmpg.org/xfn/"><abbr title="XHTML Friends Network">XFN</abbr></a></li>
		  <li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
          <?php wp_meta(); ?>
        </ul>
	</li>
	<li class="linkside">
				<?php include (TEMPLATEPATH . '/searchform.php'); ?>
      </li>
      <?php endif; // End of Dynamic Sidebar?>
  </ul>
  </div>
</div>
