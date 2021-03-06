<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php
  $title = '';

      if (is_single() ) $title = get_option('mandigo_title_scheme_single');
  elseif (is_page()   ) $title = get_option('mandigo_title_scheme_page');
  elseif (is_archive()) {
    if (is_day() || is_month() || is_year()) $title = get_option('mandigo_title_scheme_date');
    else                                     $title = get_option('mandigo_title_scheme_category');
  }
  elseif (is_search() ) $title = get_option('mandigo_title_scheme_search');
  else                  $title = get_option('mandigo_title_scheme_index');

  $title = str_replace('%blogname%',get_bloginfo('name')       ,$title);
  $title = str_replace('%tagline%' ,get_bloginfo('description'),$title);
  $title = str_replace('%post%'    ,get_the_title()            ,$title);
  $title = str_replace('%search%'  ,$s                         ,$title);

  if (single_cat_title('',false)) $title = str_replace('%category%',single_cat_title('',false) ,$title);
  else                            $title = preg_replace("/<[^>]+>/","",str_replace('%category%',get_the_category_list(', '),$title));

  if     (is_day()  ) $title = str_replace('%date%',get_the_time(__('l, F jS, Y','mandigo')),$title);
  elseif (is_month()) $title = str_replace('%date%',get_the_time(__('F, Y','mandigo'))      ,$title);
  elseif (is_year() ) $title = str_replace('%date%',get_the_time('Y')                       ,$title);

  echo $title;
?></title>



<?php
  global $schemes, $dirs;

  if (get_option('mandigo_scheme_random')) {
    update_option("mandigo_scheme",$schemes[array_rand($schemes,1)]);
    $dirs['loc']['scheme'] = $dirs['loc']['schemes'] . get_option('mandigo_scheme') ."/";
    $dirs['www']['scheme'] = $dirs['www']['schemes'] . get_option('mandigo_scheme') ."/";
  }

  if (get_option('mandigo_bold_links')) { $lastminutecss .= "  a { font-weight: bold; }\n"; };

  if (file_exists($dirs['loc']['headers'] . $post->ID .".jpg")) {
    $noheaderimg = 1;
    $lastminutecss .= "  #headerimg { background: url(". $dirs['www']['headers'] . $post->ID .".jpg) bottom center no-repeat; }\n";
  }

  elseif (get_option('mandigo_headers_random')) {
    $headersdir = opendir($dirs['loc']['headers']);
    while (false !== ($file = readdir($headersdir))) { if (preg_match("/\.(?:jpe?g|png|gif|bmp)$/i",$file)) $headers[] = $file; }

    if (sizeof($headers)) {
      $noheaderimg = 1;
      $lastminutecss .= "  #headerimg {   background: url(". str_replace(' ','%20',$dirs['www']['headers'] . $headers[array_rand($headers,1)]) .") bottom center no-repeat; }\n";
    }

  }

  if (file_exists($dirs['loc']['theme']."favicon.ico")) $favicon = $dirs['www']['theme']."favicon.ico";

  if ($favicon):
?>
<link rel="shortcut icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
<?php endif; ?>
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>.php<?php echo ($noheaderimg ? '?noheaderimg' : '') ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo $dirs['www']['scheme']; ?>scheme.css" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<script type="text/javascript" src="<?php echo $dirs['www']['js']; ?>jquery.js"></script>
<?php 
  wp_head();
  if ($lastminutecss) echo "<style type=\"text/css\">\n$lastminutecss</style>\n";
  echo get_option('mandigo_inserts_header');
?>





<!--[if !IE]> Some twisted freaky calling of header image if no upload for custom image is found<![endif]-->

<?php $get_the_custom_header = get_header_image(); ?>

<?php if($get_the_custom_header != ''){ ?>

<style type="text/css">
#headerimg {
background: url(<?php header_image(); ?>)!important;
}
</style>

<?php } ?>








</head>
<?php
  $bodytag = get_option('mandigo_inserts_body');
  echo (preg_match("/<body/i",$bodytag) ? $bodytag : "<body>");

  $tag_blogname = get_option('mandigo_tag_blogname');
  $tag_blogdesc = get_option('mandigo_tag_blogdesc');
?>

<div id="page">

<div id="header" class="png">


    <div id="headerimg">
<?php if (!get_option('mandigo_hide_blogname')): ?>
		<<?php echo $tag_blogname; ?> class="blogname" id="blogname"><a href="<?php echo get_option('home'); ?>/"><?php bloginfo('name'); ?></a></<?php echo $tag_blogname; ?>>
<?php endif; ?>
<?php if (!get_option('mandigo_hide_blogdesc') && get_bloginfo('description')): ?>
			<<?php echo $tag_blogdesc; ?> class="blogdesc" id="blogdesc"><?php bloginfo('description'); ?></<?php echo $tag_blogdesc; ?>>
<?php endif; ?>
		<ul class="pages<?php echo (get_option('mandigo_headoverlay') ? ' head_overlay' : ''); ?>">
			<li class="page_item"><a href="<?php echo get_option('home'); ?>/"><?php _e('Home','mandigo'); ?></a></li>
<?php wp_list_pages('sort_column=menu_order&depth=1&title_li=&exclude='.get_option('mandigo_exclude_pages')); ?>
</ul>
	</div>



</div>


<div id="main" class="png">
<?php echo get_option('mandigo_inserts_top'); ?>
<table>
<tr>
