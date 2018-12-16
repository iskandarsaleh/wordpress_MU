<div id="sidebar">

<?php include (TEMPLATEPATH . '/options.php'); ?>

<?php if($tn_wpmu_show_profile == "yes"){ ?>
<?php include (TEMPLATEPATH . '/profiles.php'); ?>
<?php } ?>

<!-- video feat -->

<?php
$tn_wpmu_featured_vid = get_option('tn_wpmu_featured_vid');
if($tn_wpmu_featured_vid == ''){ ?>
<?php } else { ?>
<ul class="list">
<li>
<h3><?php _e('Featured Videos'); ?></h3>
<ul>
<li><?php $tn_wpmu_featured_vid = stripcslashes($tn_wpmu_featured_vid); echo $tn_wpmu_featured_vid; ?> </li>
</ul>
</li>
</ul>
<?php } ?>

<!-- end -->


<ul class="list">

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Sidebar') ) : ?>

<li>
<h3><?php _e('Sidebar Widget'); ?></h3>
<ul>
<li><?php _e('All you need to do is to visit your <a href="wp-admin/widgets.php">widget</a> tab replace this with your widget'); ?></li>
</ul>
</li>

<?php endif; ?>
</ul>


</div>