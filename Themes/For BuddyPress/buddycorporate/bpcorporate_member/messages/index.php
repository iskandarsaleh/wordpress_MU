<?php get_header() ?>


<form action="<?php bp_messages_form_action() ?>" method="post" id="messages-form">

<div class="content-header">
	<div class="messages-options">	
		<?php bp_messages_options() ?>
	</div>
</div>


<h2><?php _e( "Inbox", "buddypress" ); ?></h2>
<?php do_action( 'template_notices' ) // (error/success feedback) ?>
	
<?php bp_message_get_notices(); // (admin created site wide notices) ?>

<?php if ( bp_has_message_threads() ) : ?>
<div class="pagination-links">
<?php bp_messages_pagination() ?>
</div>

<table id="message-threads">
		<?php while ( bp_message_threads() ) : bp_message_thread(); ?>
			<tr id="m-<?php bp_message_thread_id() ?>"<?php if ( bp_message_thread_has_unread() ) : ?> class="unread"<?php else: ?> class="read"<?php endif; ?>>
				<td width="1%">
					<span class="unread-count"><?php bp_message_thread_unread_count() ?></span>
				</td>

				<td width="99%">
                <?php bp_message_thread_avatar() ?>
               	<p><?php _e("From:", "buddypress"); ?> <?php bp_message_thread_from() ?></p>
				<p class="date"><?php bp_message_thread_last_post_date() ?></p>
                </td>


               	<td width="1%">

				</td>

				<td width="99%">
					<h3><a href="<?php bp_message_thread_view_link() ?>" title="<?php _e("View Message", "buddypress"); ?>"><?php bp_message_thread_subject() ?></a></h3>
					<p><?php bp_message_thread_excerpt() ?></p>
                    <a href="<?php bp_message_thread_delete_link() ?>" title="<?php _e("Delete Message", "buddypress"); ?>" class="delete"><?php _e("Delete", "buddypress"); ?></a> &nbsp;
					<input type="checkbox" name="message_ids[]" value="<?php bp_message_thread_id() ?>" />
				</td>

			</tr>
		<?php endwhile; ?>
</table>
		
<?php else: ?>
		
<div id="message" class="info">
<p><?php _e( 'You have no messages in your inbox.', 'buddypress' ); ?></p></div>
		
	<?php endif;?>



</form>



<?php get_footer() ?>