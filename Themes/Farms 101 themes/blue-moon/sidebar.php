<div id="sidebar">


  <div id="searchdiv">


    <form id="searchform" method="get" action="/index.php">


      <input type="text" name="s" id="s" size="20"/>


      <input name="sbutt" type="submit" value="Find" alt="Submit"  />


    </form></div>

 
<?php if ( !function_exists('dynamic_sidebar')


        || !dynamic_sidebar() ) : ?>


<ul>


<a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"><img src="http://www.feedburner.com/fb/images/pub/feed-icon32x32.png"></a>


  </ul>


<h2><?php _e('Categories');?></h2>


  <ul>


    <?php wp_list_cats(); ?>


  </ul>


<h2><?php _e('Monthly Archives');?></h2>


  <ul>


    <?php wp_get_archives('type=monthly'); ?>


  </ul>


<?php endif; ?>


</div>


