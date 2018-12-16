<div class="mbar" id="right-box">


<?php
if((bp_is_page( BP_MEMBERS_SLUG )) || (bp_is_page( BP_GROUPS_SLUG )) || (bp_is_page( BP_BLOGS_SLUG ))) { ?>

<?php load_template( TEMPLATEPATH . '/directories/directory-sidebar.php' ) ?>

<?php } else { ?>

<?php load_template ( TEMPLATEPATH . '/optionsbar.php' ) ?>

<?php
global $bp, $is_single_group; 
if($bp->current_component == $bp->groups->slug && $bp->is_single_item) { ?>

<?php if ( bp_has_groups() ) : bp_the_group(); ?>
<?php load_template( TEMPLATEPATH . '/groups/group-menu.php' ) ?>
<?php endif; ?>


<?php } else { ?>

<?php if ( function_exists('bp_groups_random_groups') ) : ?>
<?php bp_groups_random_groups() ?>
<?php endif; ?>

<?php } ?>

<?php } ?>


</div>