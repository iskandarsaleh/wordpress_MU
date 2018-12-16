<div id="sidebar">

<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Left-Sidebar') ) : ?>


<?php if(function_exists("wp_theme_switcher")) : ?>

<li><h3><?php _e('Themes'); ?></h3>
<?php wp_theme_switcher('dropdown'); ?>
</li>

<?php endif; ?>

<li>
<h3><?php _e('Categories'); ?></h3>
<ul>
<?php wp_list_categories('orderby=id&show_count=1&use_desc_for_title=0&title_li='); ?>
</ul>
</li>

<li>
<h3><?php _e('Archives'); ?></h3>
<ul>
<?php wp_get_archives('type=monthly&limit=12&show_post_count=1'); ?>
</ul>
</li>

<li>
<h3><?php _e('Pages'); ?></h3>
<ul>
<?php wp_list_pages('title_li=&depth=0'); ?>
</ul>
</li>


<li>
<h3><?php _e('Meta'); ?></h3>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional">Valid XHTML</a></li>
<li><a href="http://jigsaw.w3.org/css-validator/validator?uri=<?php echo get_settings('home'); ?>&amp;usermedium=all">Valid CSS</a></li>
<li><a href="http://wordpress.org/" title="Powered by WordPress, state-of-the-art semantic personal publishing platform.">WordPress</a></li>
<?php wp_meta(); ?>
</ul>
</li>

<?php endif; ?>

</ul>



</div>