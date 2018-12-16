<div id="sidebar">

<div class="side1">



<ul>


<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-anubis-sidebar"); } ?>


  <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>

  <?php wp_list_pages('title_li=<h2>'.__('Pages').'</h2>' ); ?>

	  <li class="blockr">

        <h2><?php _e('Archives');?></h2>

        <ul>

          <?php wp_get_archives('type=monthly'); ?>

        </ul>

      </li>

      <?php wp_list_categories(__('show_count=1&title_li=<h2>Categories</h2>')); ?>

  <?php endif; // end 1 Dynamic Sidebar  ?> 

</li>

</div>

</div>

</div> <!-- end left -->

<div id="right">

  <div class="side2">

    <ul>
	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-anubis-sidebar"); } ?>

	  <?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>

	  	<li class="blockr"><h2>Search on This Blog</h2>

				<?php include (TEMPLATEPATH . '/searchform.php'); ?>

		</li>	

      <?php /* If this is the frontpage */ if (is_home()) { ?>

      <?php wp_list_bookmarks(); ?>

      <?php } ?>

	  <li class="blockr">

	   <h2><?php _e('Meta');?></h2>

        <ul>

          <?php wp_register(); ?>

          <li>

            <?php wp_loginout(); ?>

          </li>

          <li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>

          <li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>

		  <li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>

          <?php wp_meta(); ?>

        </ul>

		</li>

      <?php endif; // end 1 Dynamic Sidebar  ?>

		</ul>

  </div>

</div>

