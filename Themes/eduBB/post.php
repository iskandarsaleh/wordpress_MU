
<div class="post-author"><?php post_author_link(); ?>&nbsp;<small>(<?php post_author_title(); ?>)</small></div>
<div class="post-date"><?php printf( __('Posted %s ago'), bb_get_post_time() ); ?>&nbsp;&nbsp;<a href="<?php post_anchor_link(); ?>">#</a>&nbsp;<?php post_ip_link(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php post_edit_link(); ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php post_delete_link(); ?><?php if (function_exists('report_post_link')) : ?>&nbsp;&nbsp;&nbsp;&nbsp;<? report_post_link(); ?><?php endif; ?></div>

<div class="post-text">
<?php post_text(); ?>
</div>