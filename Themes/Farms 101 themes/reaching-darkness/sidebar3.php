<!-- BEGIN SIDEBAR3.PHP -->
<div class="menu">
<h2 class="menu-header"><?php _e('Categories'); ?></h2>
<ul class="categories">
<?php wp_list_categories('sort_column=name&optioncount=1&hierarchical=0&title_li='); ?>
</ul>
</div>

<div class="menu">
<h2 class="menu-header"><?php _e('Links'); ?></h2>
<ul class="links">
<?php wp_list_bookmarks('categorize=0&category_order=ASC&title_li='); ?>
</ul>
</div>
<!-- END SIDEBAR3.PHP -->