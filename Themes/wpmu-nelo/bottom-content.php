<div id="bottom-content">

<?php include (TEMPLATEPATH . '/options.php'); ?>


<div class="itembox" id="box1">


<div class="custom-bottom-image">
<a href="<?php echo stripslashes($tn_wpmu_box1_imgurl); ?>">
<?php
if(file_exists($upload_path . 'box_cat_left_crop.jpg')) {?>
<img src="<?php echo "$ttpl_path/box_cat_left_crop.jpg"; ?>" alt="" width="290" height="150" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/subimage.gif" alt="" width="290" height="150" />
<?php } ?>
</a>
</div>

<h2>
<?php if($tn_wpmu_box1_header == '') { ?>
<?php _e('This is box left header'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_box1_header); ?>
<?php } ?>
</h2>
<p>
<?php if($tn_wpmu_box1_text == '') { ?>
<?php _e('All you need to do is to visit your <a href="wp-admin/themes.php?page=custom-homepage.php">Custom Homepage Images</a> tab and upload new images (you can crop them after uploading) and enter text and links to replace this text.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_box1_text); ?>
<?php } ?>
</p>

<ul class="list">

<?php if(($tn_wpmu_box1_cat == "Choose a category") || ($tn_wpmu_box1_cat == '')) { ?>

<?php } else { ?>

<li>
<h3><?php echo stripslashes($tn_wpmu_box1_cat); ?></h3>
<ul>
<?php $my_query = new WP_Query('category_name='. $tn_wpmu_box1_cat . '&' . 'showposts=' . 10);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; ?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;?>
</ul>
</li>

<?php } ?>

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Home Box Left') ) : ?>


<?php endif; ?>

</ul>

</div>







<div class="itembox" id="box2">
<div class="custom-bottom-image">
<a href="<?php echo stripslashes($tn_wpmu_box2_imgurl); ?>">
<?php
if(file_exists($upload_path . 'box_cat_center_crop.jpg')) {?>
<img src="<?php echo "$ttpl_path/box_cat_center_crop.jpg"; ?>" alt="<?php echo "$tn_wpmu_box2_cat;" ?>" width="290" height="150" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/subimage.gif" alt="" width="290" height="150" />
<?php } ?>
</a>
</div>



<h2>
<?php if($tn_wpmu_box2_header == '') { ?>
<?php _e('This is box center header'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_box2_header); ?>
<?php } ?>
</h2>
<p>
<?php if($tn_wpmu_box2_text == '') { ?>
<?php _e('All you need to do is to visit your <a href="wp-admin/themes.php?page=custom-homepage.php">Custom Homepage Images</a> tab and upload new images (you can crop them after uploading) and enter text and links to replace this text.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_box2_text); ?>
<?php } ?>
</p>

<ul class="list">

<?php if(($tn_wpmu_box2_cat == "Choose a category") || ($tn_wpmu_box2_cat == '')) { ?>

<?php } else { ?>
<li>
<h3><?php echo stripslashes($tn_wpmu_box2_cat); ?></h3>
<ul>
<?php $my_query = new WP_Query('category_name='. $tn_wpmu_box2_cat . '&' . 'showposts=' . 10);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; ?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;?>
</ul>
</li>
<?php } ?>


<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Home Box Center') ) : ?>

<?php endif; ?>
</ul>

</div>







<div class="itembox" id="box3">

<div class="custom-bottom-image">
<a href="<?php echo stripslashes($tn_wpmu_box3_imgurl); ?>">
<?php
if(file_exists($upload_path . 'box_cat_right_crop.jpg')) {?>
<img src="<?php echo "$ttpl_path/box_cat_right_crop.jpg"; ?>" alt="" width="290" height="150" />
<?php } else { ?>
<img src="<?php bloginfo('template_directory'); ?>/images/subimage.gif" alt="" width="290" height="150" />
<?php } ?>
</a>
</div>



<h2>
<?php if($tn_wpmu_box3_header == '') { ?>
<?php _e('This is box right header'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_box3_header); ?>
<?php } ?>
</h2>
<p>
<?php if($tn_wpmu_box3_text == '') { ?>
<?php _e('All you need to do is to visit your <a href="wp-admin/themes.php?page=custom-homepage.php">Custom Homepage Images</a> tab and upload new images (you can crop them after uploading) and enter text and links to replace this text.'); ?>
<?php } else { ?>
<?php echo stripslashes($tn_wpmu_box3_text); ?>
<?php } ?>
</p>



<ul class="list">

<?php if(($tn_wpmu_box3_cat == "Choose a category") || ($tn_wpmu_box3_cat == '')) { ?>
<?php } else { ?>
<li>
<h3><?php echo stripslashes($tn_wpmu_box3_cat); ?></h3>
<ul>
<?php $my_query = new WP_Query('category_name='. $tn_wpmu_box3_cat . '&' . 'showposts=' . 10);
while ($my_query->have_posts()) : $my_query->the_post();
$do_not_duplicate = $post->ID; ?>
<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
<?php endwhile;?>
</ul>
</li>
<?php } ?>

<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar('Home Box Right') ) : ?>

<?php endif; ?>

</ul>

</div>

</div>