<div id="sidebar">
<div id="searchdiv"><?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
    <form id="searchform" method="get" action="/index.php">
      <input type="text" name="s" id="s" size="20"/>
      <input name="sbutt" type="submit" value="Find" alt="Submit"  />
    </form>
  </div>
<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
 <h2>Monthly Archives</h2>
  <ul>
    <?php wp_get_archives('type=monthly'); ?>
  </ul>
  <h2><?php _e('Categories');?></h2>
  <ul>
    <?php wp_list_cats(); ?>
  </ul>
<h2>Stay Updated</h2>
  <ul id="feed">
    <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>">RSS Articles</a></li>
  </ul>
<?php endif; ?>
</div>
