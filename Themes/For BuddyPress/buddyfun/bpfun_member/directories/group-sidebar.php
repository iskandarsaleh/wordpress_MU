<div id="directory-sidebar">

	<div id="groups-directory-search" class="directory-search">
		<h3><?php _e( 'Find Groups', 'buddypress' ) ?></h3>

		<?php bp_directory_groups_search_form() ?>

	</div>

	<div id="groups-directory-featured" class="directory-featured">
		<h3><?php _e( 'Random Groups', 'buddypress' ) ?></h3>

		<?php if ( bp_has_site_groups( 'type=random&max=3' ) ) : ?>

			<ul id="groups-list" class="item-list">
			<?php while ( bp_site_groups() ) : bp_the_site_group(); ?>

				<li>
					<div class="item-avatar">
						<a href="<?php bp_the_site_group_link() ?>"><?php bp_the_site_group_avatar_thumb() ?></a>
					</div>

					<div class="item">
						<div class="item-title"><a href="<?php bp_the_site_group_link() ?>"><?php bp_the_site_group_name() ?></a></div>
						<div class="item-meta"><span class="activity"><?php bp_the_site_group_last_active() ?></span></div>

						<div class="field-data">
							<div class="field-name">
								<strong><?php _e( 'Members:', 'buddypress' ) ?></strong>
								<?php bp_the_site_group_member_count() ?>
							</div>

							<div class="field-name">
								<strong><?php _e( 'Description:', 'buddypress' ) ?></strong>
								<?php bp_the_site_group_description() ?>
							</div>
						</div>

						<?php do_action( 'bp_core_directory_groups_content' ) ?>
					</div>


					<div class="clear"></div>
				</li>

			<?php endwhile; ?>
			</ul>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'No groups found.', 'buddypress' ) ?></p>
			</div>

		<?php endif; ?>

	</div>

</div>


