<div id="sidebar">
<div class="sec-a">
<h2><?php _e('Categories','ambiru'); ?></h2>
<ul>
<?php wp_list_cats('sort_column=name&optioncount=1&hierarchical=0'); ?>
</ul>
<h2><?php _e('Archives','ambiru'); ?></h2>
<ul>
 <?php wp_get_archives('type=monthly'); ?>
</ul>
</div>
<div class="sec-a">
<?php if (function_exists('wp_theme_switcher')){echo '<h2>Themes</h2>'; wp_theme_switcher();} ?>
<ul>
<?php get_links_list(); ?>
</ul>
</div>
</div>