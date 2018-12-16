<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar 2') ) : else : ?>

<div class="menu">
<h2 class="menu-header"><span><?php _e('Categories'); ?></span></h2>
<?php echo ddmcc_generate(); ?>
</div>

<?php endif; ?>