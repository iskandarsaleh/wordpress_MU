<!-- Start Sidebar -->





	<div class="sidebar">


<ul>





<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>





	<li><h2><?php _e('Calendar'); ?></h2>


		<ul>


			<li><?php get_calendar(); ?></li>


		</ul>


	</li>





	<?php get_links_list(); ?>





<?php endif; ?>





	<li><h2><?php _e('Meta'); ?></h2>


		<ul>


			<?php wp_register(); ?>


			<li><?php wp_loginout(); ?></li>


			<li><a href="http://validator.w3.org/check/referer" title="This page validates as XHTML 1.0 Transitional"><?php _e('Valid'); ?> <abbr title="eXtensible HyperText Markup Language">XHTML</abbr></a></li>


			<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>


			<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>


			<li><a href="http://www.wpdesigner.com/" title="Theme by WPDesigner">WPDesigner</a></li>


			<li>Powered by <a href="http://wordpressmu.org">WordPress MU</a>.</li>




			<?php wp_meta(); ?>


		</ul>


	</li>





</ul>


	</div>





<!-- End Sidebar -->