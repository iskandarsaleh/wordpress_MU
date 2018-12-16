<?php include (TEMPLATEPATH . '/options.php'); ?>

<div id="sidebar-column" class="bpside">

<div id="login-panel" class="widget">
<h2 class="widgettitle"><?php _e('Search the site'); ?></h2><ul>
<li>
<div id="searchbox">
<?php if($bp_existed == 'true') { ?>
<?php bp_search_form() ?>
<?php } else { ?>
<?php include (TEMPLATEPATH . '/search-panel.php'); ?>
<?php } ?>


<h2 class="widgettitle">
<?php if (!is_user_logged_in() ) { ?>
<?php _e('Member login'); ?><?php } else { ?><?php _e('Member Profile'); ?><?php } ?></h2>
<?php if($bp_existed == 'true') { ?>
<?php bp_login_bar() ?>
<?php } else { ?>
<?php include (TEMPLATEPATH . '/login-panel.php'); ?>
<?php } ?>
</div>
</li>
</ul>
</div>


<?php if($bp_existed == 'true') { ?><?php include (TEMPLATEPATH . '/random-blogs.php'); ?><?php } ?>


<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('right-column') ) : ?>

<div id="text" class="widget widget_text">
<h2 class="widgettitle"><?php _e('Right Column Widget'); ?></h2>
<div class="textwidget">
<?php _e( 'Please log in and add widgets to this column.', 'buddypress' ) ?>
&nbsp;<a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=sidebar-3"><?php _e( 'Add Widgets', 'buddypress' ) ?></a>
</div>
</div>

<?php endif; ?>


</div>