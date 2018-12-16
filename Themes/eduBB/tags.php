<?php bb_get_header(); ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Tags'); ?></h3>

<h2 id="main-forum-title"><?php _e('Tags'); ?><br />
<small><?php _e('This is a collection of tags that are currently popular on the forums.'); ?></small>
</h2>


<div id="paging">
<?php bb_tag_heat_map( 9, 38, 'pt', 300 ); ?>
</div>


<?php bb_get_footer(); ?>