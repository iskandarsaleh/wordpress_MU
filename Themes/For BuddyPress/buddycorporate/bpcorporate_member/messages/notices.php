<?php get_header() ?>

<div class="content-header">

</div>

<div id="content">
	<div class="pagination-links">
		<?php bp_messages_pagination() ?>
	</div>
	
	<h2><?php _e("Sent Notices", "buddypress"); ?></h2>
	
	<?php do_action( 'template_notices' ) ?>

	<?php if ( bp_has_message_threads() ) : ?>
		
		<ul id="message-threads" class="notices">
		<?php while ( bp_message_threads() ) : bp_message_thread(); ?>
		   <li>
					<p><strong><?php bp_message_notice_subject() ?></strong></p>
					<p><?php bp_message_notice_text() ?></p>


					<p><?php bp_message_is_active_notice() ?></p>
					<p class="date"><?php _e("Sent:", "buddypress"); ?> <?php bp_message_notice_post_date() ?></p>


					<a href="<?php bp_message_activate_deactivate_link() ?>"><?php bp_message_activate_deactivate_text() ?></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<a href="<?php bp_message_notice_delete_link() ?>" title="<?php _e("Delete Message", "buddypress"); ?>"><?php _e("Delete", "buddypress"); ?></a>

			</li>
		<?php endwhile; ?>
		</ul>
		
	<?php else: ?>
		
		<div id="message" class="info">
			<p><?php _e("You have not sent any notices.", "buddypress"); ?></p>
		</div>	

	<?php endif;?>

</div>

<?php get_footer() ?>