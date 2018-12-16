<!-- begin r_sidebar -->





<div id="r_sidebar">





	<ul id="r_sidebarwidgeted">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-bgb-bluebird"); } ?>

	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>





	


	<h5><?php ('About');?></h5>


		<p><?php ("Replace me with a text widget (Sidebar 2 under 'Presentation') and tell the world about yourself!")?></p>


	</li>


		<div class="feedarea"><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS'); ?>"> <?php ('Grab my feed');?></a></div>


			


	


	<h5><?php ('Blogroll');?></h5>


		<ul>


			<?php get_links(-1, '<li>', '</li>', ' - '); ?>


		</ul>


	</li>


		





        <h5><?php ('Admin');?></h5>


		<ul>


			<?php wp_register(); ?>


			<li><?php wp_loginout(); ?></li>


			<li><a href="http://wordpress.org/">WordPress</a></li>


			<?php wp_meta(); ?>


			<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>


		</ul>


</li>


	<?php endif; ?>


	</ul>


			


</div>





<!-- end r_sidebar -->