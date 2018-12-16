<!-- open --><div id="top">
<p><a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a></p>

<ul>
<?php
$years = $wpdb->get_col("SELECT DISTINCT YEAR(post_date) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post' ORDER BY post_date DESC");
foreach($years as $year) : 
?>
<li><a href="<?php echo get_year_link($year); ?> "><?php echo $year; ?></a></li>
<?php endforeach; ?>
</ul>

<!-- close top --></div>

<!-- close page --></div>

<!-- open footer-wrapper --><div id="footer-wrapper">

<!-- open footer --><div id="footer">

<!-- open about --><div id="about">
<h2><?php _e('About');?></h2>
<?php query_posts('pagename=about'); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
<?php the_excerpt(); ?>
<?php edit_post_link(__('Edit'), '<p>', '</p>'); ?>
<?php endwhile; ?>
<?php endif; ?>
<!-- close about --></div>

<p>© <?php echo date(Y); ?> <a href="<?php echo get_settings('home'); ?>"><?php bloginfo('name'); ?></a>.<br />

<small><?php _e('Powered by');?> <a href="http://wordpress.alanwho.com/72class">72 Class</a> by <a href="http://alanwho.com">Alan Who?</a>. Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</small></p>
<?php do_action('wp_footer'); ?>
<!-- close footer --></div>

</body>

</html>