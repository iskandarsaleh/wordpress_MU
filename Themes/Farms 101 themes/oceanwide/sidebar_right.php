	<div id="sidebar2">
<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("160x600-oceanwide-right"); } ?>
		<ul>

<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) :

?>

<?

 else : ?>

			<?php get_links_list(); ?>

			

			<li class="widget_pages"><h2><?php _e('Pages');?></h2>

				<ul>

				<? wp_list_pages2(); ?>

				</ul>

			</li>

						

			<li class="widget_meta"><h2><?php _e('Meta');?></h2>

				<ul>

					<?php wp_register(); ?>

					<li><?php wp_loginout(); ?></li>

					<li><a href="http://validator.w3.org/check/referer" title="<?php _e('This page validates as XHTML 1.0 Transitional');?>"><?php _e('Valid');?> <abbr title="<?php _e('eXtensible HyperText Markup Language');?>">XHTML</abbr></a></li>

					<li><a href="http://gmpg.org/xfn/"><abbr title="<?php _e('XHTML Friends Network');?>">XFN</abbr></a></li>

					<li><a href="http://wordpress.org/" title="<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.');?>">WordPress</a></li>

					<?php wp_meta(); ?>

				</ul>

			</li>



<?php endif; ?>

		</ul>

	</div>

