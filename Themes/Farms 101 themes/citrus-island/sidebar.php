	<div id="sidebar" >	


	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>


	    <h1>Subscribe</h1>


		<div class="left-box">


		    <a href="<?php bloginfo('rss2_url'); ?>" title="Feed for <?php bloginfo('name'); ?>"><img src="<?php bloginfo(template_directory); ?>/images/feedicon241.gif" alt="Feed for <?php bloginfo('name'); ?>" /></a>


		</div>


				


	    <h1><?php _e('Categories');?></h1>


		<div class="left-box">


		    <ul>				


				<?php wp_list_cats('sort_column=name&optioncount=1'); ?>


			</ul>


		</div>


		


		<h1><?php _e('Archives');?></h1>


		<div class="left-box">


		    <ul>				


				<?php wp_get_archives('type=monthly'); ?>


			</ul>


		</div>





	    <h1>Meta</h1>


		<div class="left-box">


		    <ul>				


				<?php wp_register(); ?>


			    <li><?php wp_loginout(); ?></li>


			    <?php wp_meta(); ?>


				<li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php _e('Syndicate this site using RSS 2.0'); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>


				<li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php _e('The latest comments to all posts in RSS'); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>'); ?></a></li>


			</ul>


		</div>


	<?php endif; ?>


	</div>