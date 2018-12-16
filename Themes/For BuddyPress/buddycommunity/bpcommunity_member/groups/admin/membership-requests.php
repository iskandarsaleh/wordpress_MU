<?php get_header() ?>

<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

<div class="content-header">
	<ul class="content-header-nav">
		<?php bp_group_admin_tabs(); ?>
	</ul>
</div>

<div class="vcard">
	
		<h2 id="post-header"><?php _e( 'Membership Requests', 'buddypress' ); ?></h2>
		
		<?php do_action( 'template_notices' ) // (error/success feedback) ?>
		
		<?php if ( bp_group_has_membership_requests() ) : ?>
			<ul id="request-list" class="item-list">
			<?php while ( bp_group_membership_requests() ) : bp_group_the_membership_request(); ?>
				<li>
					<?php bp_group_request_user_avatar_thumb() ?>
					<p><strong><?php bp_group_request_user_link() ?></strong><br />
                    <span class="comments"><?php bp_group_request_comment() ?></span></p>
					<span class="activity"><small><?php bp_group_request_time_since_requested() ?></small></span>
					<div class="action">
						
						<div class="generic-button accept">
							<a href="<?php bp_group_request_accept_link() ?>"><?php _e( 'Accept', 'buddypress' ); ?></a> 
						</div>
					


						<div class="generic-button reject">
							<a href="<?php bp_group_request_reject_link() ?>"><?php _e( 'Reject', 'buddypress' ); ?></a> 
						</div>
						
					</div>
				</li>
			<?php endwhile; ?>
			</ul>
		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'There are no pending membership requests.', 'buddypress' ); ?></p>
			</div>

		<?php endif;?>
</div>

<?php endwhile; endif; ?>

<?php get_sidebar() ?>

<?php get_footer() ?>
