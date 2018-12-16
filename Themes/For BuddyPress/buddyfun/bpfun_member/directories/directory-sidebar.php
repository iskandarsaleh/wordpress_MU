


<div id="directory-sidebar">

	<div id="members-directory-search" class="directory-search">
		<h3><?php _e( 'Find Members', 'buddypress' ) ?></h3>

		<?php bp_directory_members_search_form() ?>

	</div>

	<div id="members-directory-featured" class="directory-featured">
		<h3><?php _e( 'Random Members', 'buddypress' ) ?></h3>

		<?php if ( bp_has_site_members( 'type=random&max=3' ) ) : ?>

			<ul id="featured-members-list" class="item-list">
			<?php while ( bp_site_members() ) : bp_the_site_member(); ?>

				<li>
					<div class="item-avatar">
						<a href="<?php bp_the_site_member_link() ?>"><?php bp_the_site_member_avatar() ?></a>
					</div>

					<div class="item">
						<div class="item-title"><a href="<?php bp_the_site_member_link() ?>"><?php bp_the_site_member_name() ?></a></div>
						<div class="item-meta"><span class="activity"><?php bp_the_site_member_last_active() ?></span></div>

						<div class="field-data">
							<div class="field-name"><?php bp_the_site_member_total_friend_count() ?></div>
							<div class="field-name xprofile-data"><?php bp_the_site_member_random_profile_data() ?></div>
						</div>

						<?php do_action( 'bp_core_directory_members_content' ) ?>
					</div>

					<div class="clear"></div>
				</li>

			<?php endwhile; ?>
			</ul>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'There are not enough members to feature.', 'buddypress' ) ?></p>
			</div>

		<?php endif; ?>

	</div>

</div>


