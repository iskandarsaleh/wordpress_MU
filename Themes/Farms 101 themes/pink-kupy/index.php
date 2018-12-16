<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">



<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

	<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; <?php _e('Blog Archive');?> <?php } ?> <?php wp_title(); ?></title>

	



	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />

	<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />

	<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />

	<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />

	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />



	<?php wp_get_archives('type=monthly&format=link'); ?>

	<?php wp_head(); ?>


</head>

<body class="bgsmall" topmargin="0" leftmargin="0" rightmargin="0" bottommargin="0" marginheight="0" marginwidth="0">
<div class="BGbig">
<div align="center">
  <table id="Table_01" width="750" height="480" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="5" class="image1" width="750" height="144">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5" class="image2" width="750" height="177"><div class="title"><a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a><br /><span class="sub"><?php bloginfo('description'); ?></span></div></td>
    </tr>
    <tr>
      <td valign="top" class="image3" width="52"><div class="image4">&nbsp;</div></td>
      <td bgcolor="#FFFFFF" width="171" height="159" valign="top" class="tdleft"><div class="td3">
	  
	  <div id="menu">

		<?php get_sidebar(); ?>
	  </div>

	  
      </div>      </td>
      <td bgcolor="#FFFFFF" width="9" height="159">&nbsp;</td>
      <td bgcolor="#FFFFFF" width="410" height="159" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td class="td1"><span class="style1"></span></td>
        </tr>
        <tr>
          <td valign="top" class="td2">
		  <?php 

			get_header();

		  ?>
		

<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-pinkkupy-top"); } ?>
<?php if (have_posts()) : ?>

		

	<?php while (have_posts()) : the_post(); ?>

			

		<div class="post" id="post-<?php the_ID(); ?>">

			<a href="<?php the_permalink() ?>" rel="bookmark" class="postlink" title="<?php bloginfo('name');?>: <?php the_title(); ?>"><?php the_title(); ?></a><br/>

			<span id="postdata"><?php _e('Posted on');?> <?php the_time(__('F jS, Y')) ?> <?php _e('at');?> <?php the_time('g:i a'); ?> <?php _e('by');?> <?php the_author() ?> and <?php the_tags( '' . __( 'tagged' ) . ' ', ', ', ''); ?></span>

			

			<div class="entry">

			<?php the_content(__('(Read the rest of this story.)')); ?>
			</div>

	

			<div id="cats">
                  <p class="postmetadata"><?php _e('Posted in ');?> <?php the_category(', ') ?>
                    <strong>|</strong> 
                    <?php edit_post_link(__('Edit'), '','<strong> |</strong>'); ?>
                    <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?>
                  </p>
                  <div id="divider"> </div></div>
		</div>



	<?php comments_template(); ?>

	<?php endwhile; ?>



		<p align="center"><?php next_posts_link(__('&laquo; Previous Entries')) ?> &nbsp; <?php previous_posts_link(__('Next Entries &raquo;')) ?></p>



	<?php else : ?>

		<h2 align="center"><?php _e('Not Found');?></h2>

		<p align="center"><?php _e("Sorry, but you are looking for something that isn't here.");?></p>

	<?php endif; ?>

	<?php if (function_exists('wp_ozh_wsa')) { wp_ozh_wsa("336x280-pinkkupy-bottom"); } ?>
<br><br></td>
        </tr>
      </table><br /><div align="center"><?php get_footer(); ?></div></td>
      <td valign="top" class="image5" width="108"><div class="image6">&nbsp;</div></td>
    </tr>
  </table>
</div>
</body>