<div id="sidebar">
    <?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("20090linkunitnocolor"); } ?>
	<?php if ( !function_exists('dynamic_sidebar')
        || !dynamic_sidebar() ) : ?>
	<?php if(get_option('gridlock_about_blurb') != '') { ?>
    <img id="about" src="<?php bloginfo('stylesheet_directory'); ?>/images/about.gif" alt="about the author" />
	<div id="aboutAuthor">
    	<p><?php echo(htmlspecialchars(stripslashes(get_option('gridlock_about_blurb')))); ?> 
		
		<?php if(get_option('gridlock_about_slug') != '') { ?>
		<a href="<?php bloginfo('url'); ?>/<?php echo(get_option('gridlock_about_slug')); ?>">read more&hellip;</a></p>
		<?php } ?>
    </div>
	<?php } ?>

    <ul> 
        <li><h2><?php _e('Categories');?></h2>
	        <ul>
            <?php wp_list_cats('sort_column=name'); ?>
        	</ul>
		</li>
        
        <li><h2><?php _e('Links');?></h2>
           <ul>
            <?php get_links('-1', '<li>', '</li>', '<br />', FALSE, 'name', FALSE); ?>
           </ul>
        </li>
        
        
        <li><h2><?php _e('Meta');?></h2>
        <ul>
            <li><?php wp_loginout(); ?></li>

            <li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>
            <li><a href="http://jigsaw.w3.org/css-validator/check/referer">Valid CSS</a></li>
			<?php if(is_home()) { ?>
            <li><a href="http://www.contentquality.com/mynewtester/cynthia.exe?Url1=<?php bloginfo('url'); ?>">508</a></li>
            <?php } ?>
			<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.'); ?>">WordPress</a></li>
			<?php if(get_option('gridlock_disable_sifr') == 'false') { ?>
            <li><a href="http://www.mikeindustries.com/sifr/" title="Scalable Inman Flash Replacement">sIFR</a> Rich Typography</li>
			<?php } ?>
			<li><a href="http://hyalineskies.com/wordpress/gridlock/" title="Gridlock Theme at hyalineskies">Gridlock</a> 1.4 by <a href="http://hyalineskies.com/" title="hyalineskies">hyalineskies</a></li>
			<li>Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</li>

            <?php wp_meta(); ?>
        </ul>
        </li>
    </ul>
<?php endif; ?>
</div>