<!-- begin sidebar -->


<div id="menu">




<div id="nav">

<ul>

<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>

<?php get_links_list(); ?>
<li id="categories"><h2><?php _e('Categories:'); ?></h2>
<ul>
<?php wp_list_cats(); ?>
</ul>
</li>
<li id="archives"><h2><?php _e('Archives:'); ?></h2>
<ul>
<?php wp_get_archives('type=monthly'); ?>
</ul>
</li>
<?php if (function_exists('wp_theme_switcher')) { ?>
<li><h2><?php _e('Themes'); ?></h2>
<?php wp_theme_switcher('dropdown'); ?>
</li>
<?php } ?>

<?php endif; ?>
</ul>
</div>
<h5>&nbsp;</h5>

<div class="feeds"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS°'); ?>">rss</a></div><!-- feeds -->
<div class="feeds"><a href="<?php bloginfo('atom_url'); ?>" title="atom feed°">xml</a></div>


</div>
<!-- end sidebar -->
