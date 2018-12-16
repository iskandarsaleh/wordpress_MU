<!-- BEGIN SIDEBAR2.PHP -->

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar('Sidebar 2') ) : else : ?>

<div class="menu">
<h2 class="menu-header"><?php _e('Meta'); ?></h2>
<ul>
<?php wp_register(); ?>
<li><?php wp_loginout(); ?></li>
<li><a href="http://validator.w3.org/check/referer" title="Check The Validity Of This Site's XHTML"><abbr title="eXtensible HyperText Markup Language">XHTML 1.1</abbr></a></li>
<li><a href="http://jigsaw.w3.org/css-validator/validator?uri=<?php bloginfo('url'); ?>" title="Check The Validity Of This Site's CSS" rel="external"><abbr title="Cascading Style Sheets">CSS</abbr></a></li>
<?php wp_meta(); ?>
</ul>
</div>

<!-- uncomment this to add the calendar to your sidebar
<div class="menu">
<h2 class="menu-header"><?php _e('Calendar'); ?></h2>
<?php get_calendar(); ?>
</div>
-->

<?php endif; ?>

<!-- END SIDEBAR2.PHP -->