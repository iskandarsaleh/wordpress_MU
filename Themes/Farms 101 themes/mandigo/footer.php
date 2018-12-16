<?php /*

  Hi,

  Please DO NOT remove the link to my website from the footer. I have
  been working hard to make this theme and you have downloaded it for
  FREE. This is all I ask from you in return for Mandigo which didn't
  cost you a cent.

  Thank you.

  tom

*/

  global $dirs, $wpmu;
?>
</tr>
</table>
<?php echo get_option('mandigo_inserts_footer'); ?>
</div>
<div id="footer" class="png">
	<p>
<?php if ($wpmu): $current_site = get_current_site(); ?>
		
		Powered by <a href="http://wordpressmu.org">WordPress MU</a>.

		<a href="http://www.onehertz.com/portfolio/wordpress/" target="_blank" title="WordPress themes">Mandigo theme</a> by tom. 
<?php else: ?>
		<?php _e('Powered by <a href="http://wordpress.org/">WordPress</a>','mandigo'); ?>, <a href="http://www.onehertz.com/portfolio/wordpress/" target="_blank" title="WordPress themes">Mandigo theme</a> by tom.

<?php endif; ?>
		<br /><a href="<?php bloginfo('rss2_url'); ?>"><img src="<?php echo $dirs['www']['scheme']; ?>images/rss_s.gif" alt="" /> <?php _e('Entries (RSS)','mandigo'); ?></a>
		<?php _e('and','mandigo'); ?> <a href="<?php bloginfo('comments_rss2_url'); ?>"><img src="<?php echo $dirs['www']['scheme']; ?>images/rss_s.gif" alt="" /> <?php _e('Comments (RSS)','mandigo'); ?></a>.
		<?php if (get_option('mandigo_footer_stats')): ?>
		<br /><?php echo get_num_queries(); ?> <?php _e('queries');?>. <?php timer_stop(1); ?> <?php _e('seconds');?>.
		<?php endif; ?>
	</p>
</div>
</div>

		<?php wp_footer(); ?>

<script type="text/javascript">
<!-- // <![CDATA[
  hover = function(state,target,img) { document.getElementById(target).src = '<?php echo $dirs['www']['scheme']; ?>images/' + img +(state ? '_hover' : '') + '.gif'; }
  
  var maxw = Math.round(.96*<?php echo (-32+490+(get_option('mandigo_1024') ? (get_option('mandigo_3columns') ? -6 : (get_option('mandigo_nosidebars') ? 454 : 224)) : 0)); ?>);

  if (jQuery.browser.msie) {
    jQuery('.entry object, .entry img').load(function(){
      if (this.clientWidth > maxw) this.style.width = maxw+'px';
    });
  }

<?php if (!get_option('mandigo_no_animations')): ?>
  togglePost = function(id) {
    icon = jQuery('#switch-post-'+id+' img');
    icon.attr('src',/minus/.test(icon.attr('src')) ? icon.attr('src').replace('minus','plus') : icon.attr('src').replace('plus','minus'));
    jQuery('#post-'+id+' .entry').animate({ height: 'toggle', opacity: 'toggle' }, 1000);
  }

  toggleSidebars = function() {
    icon = jQuery('.switch-sidebars img');
    icon.attr('src',/hide/.test(icon.attr('src')) ? icon.attr('src').replace('hide','show') : icon.attr('src').replace('show','hide'));
    jQuery('.sidebars').animate({ width: 'toggle', height: 'toggle', padding: 'toggle', border: 'toggle' }, 1000);
  }

<?php /* there's also "#wp-calendar caption", but it doesn't work too well */ ?>
  jQuery('.widgettitle, .linkcat *:first, .commentlist li cite, .wpg2blockwidget h3').click(function() {
    jQuery(this).siblings().animate({ height: 'toggle', opacity: 'toggle' }, 1000);
  });
<?php endif; ?>

<?php if (get_option('mandigo_drop_shadow')): ?>
  jQuery('#blogname').after('<span class="blogname text-shadow">'+ jQuery('#blogname a').html() +"<\/span>");
  jQuery('#blogdesc').after('<span class="blogdesc text-shadow">'+ jQuery('#blogdesc'  ).html() +'<\/span>');
<?php endif; ?>

<?php if (get_option('mandigo_stroke')): ?>
  jQuery.each(['tl','tr','bl','br'],function() {
    jQuery('#blogname').after('<span class="blogname text-stroke-'+ this +'">'+ jQuery('#blogname a').html() +'<\/span>');
    jQuery('#blogdesc').after('<span class="blogdesc text-stroke-'+ this +'">'+ jQuery('#blogdesc'  ).html() +'<\/span>');
  });
<?php endif; ?>

<?php if (get_option('mandigo_sidebar1_left')): ?>
  t = jQuery('#sidebar1').clone();
  jQuery('#sidebar1').remove();
  jQuery('td#content').before(t);
<?php endif; ?>

<?php if (get_option('mandigo_sidebar2_left')): ?>
  t = jQuery('#sidebar2').clone();
  jQuery('#sidebar2').remove();
  jQuery('td#content').before(t);
<?php endif; ?>

// ]]> -->
</script>
</body>
</html>
