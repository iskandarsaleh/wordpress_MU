<?php
  error_reporting(0);
  $fb = 0;

  $d = 0;
  while (!file_exists(str_repeat('../',$d).'wp-config.php')) { if (++$d > 99) exit; }
  $wpconfig = str_repeat('../',$d).'wp-config.php';

  if (file_exists(str_repeat('../',$d).'wpmu-settings.php')) $fb++;
  else
    if (file_exists($wpconfig))
      eval(preg_replace('/((require|include)(_once)?|define[^\n]+ABSPATH)[^\n]+|<\?php|\?>/','',file_get_contents($wpconfig)));

  if (defined('DB_USER')) {
    $dbh = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
    @mysql_select_db(DB_NAME,$dbh);
    $r = @mysql_query("SELECT option_name,option_value FROM ". $table_prefix ."options WHERE option_name REGEXP '^mandigo_(1024|sidebar[12]_left|3columns|wp(_(fixed|repeat|position))?|em_italics|bgcolor|no(float|border)|headnav_left|scheme|slim_header|small_title|number_comments|(posts|sidebars)_b[dg]color|floatright|nojustify)|stylesheet|siteurl';",$dbh);
    while ($a = @mysql_fetch_row($r)) {
      if ($a[1] == 'on' ) $a[1] = 1;
      if ($a[1] == 'off') $a[1] = 0;
      $$a[0] = $a[1];
    }
    @mysql_free_result($r);
    if (!$mandigo_scheme) $fb++;
    $stylesheet_directory = $siteurl . '/wp-content/themes/'. $stylesheet;
  }
  else $fb++;

  if ($fb) {
    require($wpconfig);
    $mandigo_em_italics       = get_option('mandigo_em_italics');
    $mandigo_scheme_random    = get_option('mandigo_scheme_random');
    $mandigo_3columns         = get_option('mandigo_3columns');
    $mandigo_sidebar1_left    = get_option('mandigo_sidebar1_left');
    $mandigo_sidebar2_left    = get_option('mandigo_sidebar2_left');
    $mandigo_headnav_left     = get_option('mandigo_headnav_left');
    $mandigo_wp               = get_option('mandigo_wp');
    $mandigo_1024             = get_option('mandigo_1024');
    $mandigo_nofloat          = get_option('mandigo_nofloat');
    $mandigo_bgcolor          = get_option('mandigo_bgcolor');
    $mandigo_scheme           = get_option('mandigo_scheme');
    $mandigo_slim_header      = get_option('mandigo_slim_header');
    $mandigo_noborder         = get_option('mandigo_noborder');
    $mandigo_small_title      = get_option('mandigo_small_title');
    $mandigo_wp_fixed         = get_option('mandigo_wp_fixed');
    $mandigo_wp_repeat        = get_option('mandigo_wp_repeat');
    $mandigo_wp_position      = get_option('mandigo_wp_position');
    $mandigo_number_comments  = get_option('mandigo_number_comments');
    $mandigo_posts_bgcolor    = get_option('mandigo_posts_bgcolor');
    $mandigo_posts_bdcolor    = get_option('mandigo_posts_bdcolor');
    $mandigo_sidebars_bgcolor = get_option('mandigo_sidebars_bgcolor');
    $mandigo_sidebars_bdcolor = get_option('mandigo_sidebars_bdcolor');
    $mandigo_floatright       = get_option('mandigo_floatright');
    $mandigo_nojustify        = get_option('mandigo_nojustify');
    $stylesheet_directory     = get_bloginfo('stylesheet_directory');
    foreach (array('em_italics','3columns','sidebar1_left','sidebar2_left','1024','nofloat','slim_header','noborder','small_title','wp_fixed','wp_repeat','wp_position','number_comments') as $a) {
      $a = 'mandigo_'. $a;
      if ($$a == 'on')  $$a = 1;
      if ($$a == 'off') $$a = 0;
    }
    status_header(200);
  }
  header('Content-type: text/css');

  $ie      = preg_match("/MSIE [4-6]/",$_SERVER['HTTP_USER_AGENT']);
  $ie7     = preg_match("/MSIE 7/",    $_SERVER['HTTP_USER_AGENT']);
  $safari  = preg_match("/Safari/",    $_SERVER['HTTP_USER_AGENT']);
  $firefox = preg_match("/Firefox/",   $_SERVER['HTTP_USER_AGENT']);
?>

/* Begin Typography & Colors */
body {
  font-size: 62.5%; /* Resets 1em to 10px */
  font-family: Arial, Sans-Serif;
  color: #333;
}

.narrowcolumn .entry, .widecolumn .entry { line-height: 1.4em; }

.widecolumn { line-height: 1.6em; }

small {
  font-family: Arial, Helvetica, Sans-Serif;
  font-size: 0.9em;
  line-height: 1.5em;
}

h1, h2, h3, .inline-widgets #wp-calendar caption, .blogname, .blogdesc {
  font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
  font-weight: bold;
}

#content { font-size: 1.2em; }

.blogname {
  font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
  font-size: <?php echo ($mandigo_small_title ? 3 : 4); ?>em;
  letter-spacing: -.05em; 
  margin-top:  <?php echo ($mandigo_small_title ? 25 : 15); ?>px;
}

.blogname, .blogname a, blogname a:hover, .blogname a:visited, .blogdesc {
  text-decoration: none;
  color: white;
}

.blogname, .blogdesc { 
  font-weight: bold;
  position: absolute;
  z-index: 100;
  margin-left: 15px;
}

.blogdesc { 
  font-size: 1.2em;
  margin-top:  60px; 
}

.posttitle, #comments, #respond, #trackbacks {
  font-family: 'Trebuchet MS', 'Lucida Grande', Verdana, Arial, Sans-Serif;
  font-weight: bold;
  font-size: 1.6em;
}

.posttitle, .posttitle a, .posttitle a:hover, .posttitle a:visited {
  text-align: left;
  text-decoration: none;
  color: #333;
}

.posttitle-archive, .posttitle-search, #comments, #respond { font-size: 1.5em; }

.pagetitle { font-size: 1.6em; }

.widgettitle, .sidebars li.linkcat h2 {
  font-family: 'Lucida Grande', Verdana, Sans-Serif;
  font-size: 1.2em;
}

.inline-widgets .widgettitle, .inline-widgets #wp-calendar caption { font-size: 1.4em; }

.sidebars .widgettitle, #wp-calendar caption, cite { text-decoration: none; }

.widgettitle a { color: #333; }

.widecolumn .entry p { font-size: 1.05em; }

.commentlist li, #commentform input, #commentform textarea {
  font: 0.9em 'Lucida Grande', Verdana, Arial, Sans-Serif;
}

.commentlist li { font-weight: bold; }

.commentlist cite, .commentlist cite a {
  font-weight: bold;
  font-style: normal;
  font-size: 1.1em;
}

.commentlist p {
  font-weight: normal;
  line-height: 1.5em;
  text-transform: none;
}

#commentform p { font-family: 'Lucida Grande', Verdana, Arial, Sans-Serif; }

.commentmetadata { font-weight: normal; }

.sidebars { font: 1em 'Lucida Grande', Verdana, Arial, Sans-Serif; }

small, .sidebars ul li, .sidebars ol li, .nocomments, .postmetadata, strike { color: #777; }

code { font: 1em 'Courier New', Courier, Fixed; }

blockquote {
  color: #555;
  font-style: italic;
}

em {
  <?php if ($mandigo_em_italics): ?>
  font-style: italic;
  font-weight: normal;
  <?php else: ?>
  font-style: normal;
  font-weight: bold;
  <?php endif; ?>
}

acronym, abbr, span.caps {
  font-size: 0.9em;
  letter-spacing: .07em;
}

a { text-decoration: none; }

a:hover { text-decoration: underline; }

#wp-calendar #prev a, #wp-calendar #next a { font-size: 9pt; }

#wp-calendar a { text-decoration: none; }

#wp-calendar caption { font: bold 1.2em 'Lucida Grande', Verdana, Arial, Sans-Serif; }

#wp-calendar th {
  font-style: normal;
  text-transform: capitalize;
}

.text-shadow { color: #333; }

.text-stroke-tl, .text-stroke-tr, .text-stroke-bl, .text-stroke-br { color: #000; }

.narrowcolumn .postmetadata { text-align: left; }

.four04 {
  font-weight: bold;
  font-size: 18pt;
  letter-spacing: -.1em;
  text-align: center;
  margin-top: 10px
}

.four04-big {
  font-size: 50pt;
  letter-spacing: -.05em;
  line-height: .6em;
  margin-top: .3em;
}
/* End Typography & Colors */



/* Begin Structure */
* {
 padding: 0; 
 margin: 0;
}

p { margin: 1em 0; }

body {
  background-color: <?php echo $mandigo_bgcolor; ?>;
  <?php if ($mandigo_wp): ?>
  background-image: url(<?php echo $stylesheet_directory; ?>/images/patterns/<?php echo $mandigo_wp; ?>);
  background-attachment: <?php echo ($mandigo_wp_fixed ? 'fixed' : 'scroll'); ?>;
  background-repeat: <?php echo ($mandigo_wp_repeat ? $mandigo_wp_repeat : 'repeat'); ?>;
    <?php if (isset($mandigo_wp_position)): ?>
  background-position: <?php echo $mandigo_wp_position; ?>;
    <?php endif; ?>
  <?php endif; ?>
  text-align: center;
  margin: 0 0 20px 0;
}

#page {
  margin: 20px auto;
  text-align: left;
  width: <?php echo (763+224*$mandigo_1024); ?>px;
}

#header {
  background: url(images/header<?php echo ($mandigo_1024 ? '-1024' : ''); ?>.png);
  height: <?php echo (237-($mandigo_slim_header ? 100 : 0)); ?>px;
  width: <?php echo (763+224*$mandigo_1024); ?>px;
}

#headerimg {
  position: relative;
  left: 13px;
  top: 11px;
  height: <?php echo (226-($mandigo_slim_header ? 100 : 0)); ?>px;
  width: <?php echo (737+224*$mandigo_1024); ?>px;
  <?php if (!isset($_GET['noheaderimg'])): ?>
  background: url('schemes/<?php echo $mandigo_scheme; ?>/images/head<?php echo ($mandigo_1024 ? '-1024' : ''); ?>.jpg') bottom center no-repeat;
  <?php endif; ?>
}

#main {
  background: url(images/bg<?php echo ($mandigo_1024 ? '-1024' : ''); ?>.png);
  width: <?php echo (763-2*15+224*$mandigo_1024); ?>px;
  padding: 9px 15px;
}

#main>table { width: 100%; }

.narrowcolumn { width: 100%; }

.narrowcolumn, .widecolumn, #sidebar1, #sidebar2 {
  vertical-align: top;
  padding: 0 3px;
}

.alt {
  background-color: #fafafa;
  border-top:    1px solid #eee;
  border-bottom: 1px solid #eee;
}

.postmetadata { background-color: #fff; }

#footer {
  background: url(images/foot<?php echo ($mandigo_1024 ? '-1024' : ''); ?>.png);
  border: none;
}

.post {
  position: relative;
  clear: both;
  text-align: <?php echo ($mandigo_nojustify ? 'left' : 'justify'); ?>;
  padding: 5px 15px;
  margin: 0 auto 9px auto;
  background: <?php echo $mandigo_posts_bgcolor; ?>; 
  border: 1px solid <?php echo $mandigo_posts_bdcolor; ?>; 
  <?php if ($ie||$ie7): ?>height: 1%; /* peekaboo */<?php endif; ?>
}

.narrowcolumn .postdata { padding-top: 5px; }

.widecolumn .postmetadata { margin: 30px 0; }

.smallattachment {
  text-align: center;
  width: 128px;
  margin: 5px 5px 5px 0px;
}

.attachment {
  text-align: center;
  margin: 5px 0px;
}

.postmetadata, .entry, .inline-widgets, .clear { clear: both; }

#footer {
  margin: 0 auto;
  width: <?php echo (763+224*$mandigo_1024); ?>px;
  height: 68px;
}

#footer p {
  margin: 0;
  padding: 10px 0 0 0;
  text-align: center;
}

<?php if ($ie): ?>
#footer a { position: relative; }
<?php endif; ?>

.sidebars {
  width: 210px;
  background: <?php echo $mandigo_sidebars_bgcolor; ?>;
  border: 1px solid <?php echo $mandigo_sidebars_bdcolor; ?>;
  padding: 5px;
  overflow: hidden;
}

.pagetitle {
  margin-top: 30px;
  text-align: center;
}

.post .pagetitle {
  margin-top: inherit;
  text-align: left;
  font-size: 1.5em;
}

.sidebars .widgettitle { margin: 5px 0 0 0; }

.comments { margin: 40px auto 20px; }

.text-shadow    { position: absolute; top: +2px; left: +2px; z-index: 98; }
.text-stroke-tl { position: absolute; top: -1px; left: -1px; }
.text-stroke-tr { position: absolute; top: -1px; left: +1px; }
.text-stroke-bl { position: absolute; top: +1px; left: -1px; }
.text-stroke-br { position: absolute; top: +1px; left: +1px; }
.text-stroke-tl, .text-stroke-tr, .text-stroke-bl, .text-stroke-br { z-index: 99; }

.switch-post {
  float: right;
  position: relative;
  right: -10px;
}
/* End Structure */



/* Begin Images */
.png { behavior: url(<?php echo $stylesheet_directory; ?>/js/iepngfix.htc.php?blank=<?php echo $stylesheet_directory; ?>/images/1x1.gif); }

p img { max-width: 95%; }

.entry img {
  float: <?php echo ($mandigo_nofloat ? 'none' : ($mandigo_floatright ? 'right' : 'left')); ?>;
  margin: 3px <?php echo ($mandigo_floatright ? 0 : 10); ?>px 3px <?php echo ($mandigo_floatright ? 10 : 0); ?>px;
  <?php if (!$mandigo_noborder): ?>
  background: #fff;
  border: 1px solid #333;
  padding: 3px;
  <?php endif; ?>
}

img.nofloat, img.nowrap, .nofloat img, .nowrap img, .smallattachment img, .attachment img, .entry img.wp-smiley { float: none; }

.entry img.wp-smiley {
  border: 0;
  padding: 0;
  margin: 0;
  background: transparent;
}

img.noborder {
  background: inherit;
  border: 0;
  padding: inherit;
}

img.centered {
  display: block;
  margin-left: auto;
  margin-right: auto;
  float: none;
}

img.alignright, img.alignleft {
  display: inline;
}

.alignright { float: right !important; }

.alignleft { float: left !important; }
/* End Images */



/* Begin Lists */
ol, ul { padding: 0 0 0 20px; }

ol ol, ol ul, ul ul, ul ol { padding: 0 0 0 10px; }

ul {
  margin-left: 0;
  list-style: none;
  list-style-type: circle;
} 

li { margin: 3px 0 4px 5px; }

.postdata ul, .postmetadata li {
  display: inline;
  list-style-type: none;
  list-style-image: none;
}

.sidebars li {
  list-style-image: url(schemes/<?php echo $mandigo_scheme; ?>/images/star.gif);
  margin: 0 0 15px 25px;
<?php if ($ie): ?>
  margin: 10px 0 15px 20px;
<?php endif; ?>
}

.sidebars ul, .sidebars ol { padding: 0; }

.sidebars ul li {
  list-style-type: circle;
  list-style-image: none;
  margin: 0;
}

ol li, .sidebars ol li {
  list-style: decimal outside;
  list-style-image: none;
}

.sidebars p, .sidebars select { margin: 5px 0 8px 0; }

.sidebars ul, .sidebars ol { margin: 5px 0 0 5px; }

.sidebars ul ul, .sidebars ol { margin: 0 0 0 10px; }

.sidebars ul li, .sidebars ol li { margin: 3px 0 0 0; }
/* End Entry Lists */



/* Begin Form Elements */
#searchform {
  margin: 0 auto;
  padding: 0 3px; 
  text-align: center;
}

#content #searchform {
  margin-bottom: 10px;
  text-align: left;
}

.sidebars #searchform #s {
  border: 1px dashed #ddd; 
  width: 140px;
  padding: 2px;
}

#content #searchform #s {
  border: 1px dashed #bbb; 
  width: 200px;
  padding: 2px;
}

.sidebars #searchsubmit, #content #searchsubmit {
  position: relative;
  top: 6px;
}

.entry form { text-align: center; }

select { width: 130px; }

#commentform { 
  margin-bottom: 1em;
  width: 99%;
}

#commentform input {
  width: 170px;
  padding: 2px;
  margin: 5px 5px 1px 0;
}

#commentform textarea {
  width: 99%;
  padding: 2px;
}

#commentform #submit {
  margin: 0 1em 0 0;
  float: right;
}
/* End Form Elements */



/* Begin Comments*/
.alt {
  margin: 0;
  padding: 10px;
}

.commentlist {
  text-align: justify;
  <?php if ($mandigo_number_comments): ?>
  margin-left: 3em;
  <?php endif; ?>
  margin-bottom: 15px;
}

.commentlist li {
  margin: 15px 0 3px 0;
  padding: 5px 10px 3px 10px;
  list-style: <?php echo ($mandigo_number_comments ? 'decimal outside' : 'none'); ?>;
}

.commentlist p { margin: 10px 5px 10px 0; }

#commentform p { margin: 5px 0; }

.nocomments { text-align: center; }

.commentmetadata { display: block; }

.authorcomment {
  background: #EEE;
  color: #000;
  border-top:    1px solid #CCC;
  border-bottom: 1px solid #CCC;
<?php if (0): ?>
  background: #666;
  color: #FFF;
<?php endif; ?>
}
/* End Comments */



/* Begin Calendar */
#wp-calendar {
  empty-cells: show;
  margin: 0 !important; margin-top: -1.5em<?php echo ($safari||$ie7 ? ' !important;' : ''); ?>;
  width: 155px;
}

#wp-calendar caption {
  margin-top: -1.2em;
<?php echo ($safari ? 'margin-bottom: 1.5em;' : ''); ?>
}

/* dirty fix for the event calendar plugin */
div#wp-calendar caption { padding-top: 1.5em; }
div#wp-calendar .nav {
  margin: <?php echo ($ie||$ie7||$safari ? ($ie7 ? 0 : '1.5em') .' 0 -1.5em 0' : 0); ?>;
  position: relative;
}
/* end dirty fix */

#wp-calendar #next a {
  padding-right: 10px;
  text-align: right;
}

#wp-calendar #prev a {
  padding-left: 10px;
  text-align: left;
}

#wp-calendar a { display: block; }

#wp-calendar #today { background: #fff; }

#wp-calendar caption {
  text-align: left;
  width: 100%;
}

#wp-calendar th {
  padding: 3px 0;
  text-align: center;
}
#wp-calendar td {
  padding: 3px 0;
  text-align: center;
}
/* End Calendar */



/* Begin Various Tags & Classes */
acronym, abbr, span.caps { cursor: help; }

acronym, abbr { border-bottom: 1px dashed #999; }

blockquote {
  margin: 15px 10px 0 10px;
  padding: 0 20px 0 20px;
  border: 1px dashed #ddd;
  border-left: 0;
  border-right: 0;
  background: #fff;
}

.center { text-align: center; }

a img { border: none; }

.navigation .alignleft  { 
  padding: 20px 0;
  width: 50%;
  text-align: left;
}

.navigation .alignright {
  padding: 20px 0;
  width: 50%;
  text-align: right;
}

.cal {
  color: #fff;
  text-align: center;
  line-height: 1.4em;
  font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Sans-Serif;
  padding: 1px;
  width: 2.9em;
}

.calborder {
  display: inline;
  padding: 1px;
  float: left;
  margin-right: 1em;
}

.cal span { display: block; }

.cald {
  font-size: 1.5em;
  letter-spacing: .2em;
  padding-left: .2em
}
.cald2 {
  letter-spacing: 0em;
  padding-left: 0em
}

.calm {
  font-weight: bold;
  font-size: 2em;
  line-height: .7em;
}

.caly {
  font-size: .8em;
  line-height: 1em;
}

.pages {
  display: inline;
  position: absolute;
  left: 0;
  bottom: 0;
  text-align: <?php echo ($mandigo_headnav_left ? 'left' : 'right'); ?>;
  padding: .6em 0;
  width: 100%;
}

.pages li {
  list-style-type: none;
  display: inline;
  margin: 0 1em;
}

.pages a, .pages a:hover {
  font-size: 1.5em;
  font-weight: bold;
  color: #FFF;
  letter-spacing: -.08em !important; letter-spacing: -.1em;
}

.postinfo { padding-bottom: 1em; }

.postinfo .posttitle { line-height: .9em; }

.head_overlay {
  background: url(images/<?php echo ($ie ? '1x1.gif' : 'head_overlay.png'); ?>);
  <?php if ($ie): ?>
  filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo $stylesheet_directory; ?>/images/head_overlay.png', sizingMethod='scale');
  <?php endif; ?>
}

#rss {
  float: right;
  padding-right: 4px;
}

.inline-widgets { padding-left: 0; }

.inline-widgets li { list-style-type: none; }

.inline-widgets li ul { padding-left: 2em; }

.inline-widgets li li { list-style-type: circle; }

.textwidget { padding-right: 10px; }

.googlemap img { background: inherit; }
/* End Various Tags & Classes*/



<?php 
  // the following set of rules are loaded only if a right-to-left script (eg. Hebrew, Arabic) is being used.
  if (preg_match("/^(ar|he_IL)$/",WPLANG)):
?>
/* RTL scripts support */
.pages, #content, .sidebars, #footer { direction: rtl; }

.blogname, .blogdesc { 
  width: <?php echo (737+224*$mandigo_1024-15); ?>px;
  text-align: right;
  padding-left: 0;
  margin-left: 0;
  margin-right: 15px;
}

.calborder {
  float: right;
  margin-right: 0;
  margin-left:  1em;
}

.narrowcolumn .postmetadata, #content #searchform, #respond, #commentform p, .sidebars, #wp-calendar caption, .posttitle { text-align: right; }

.entry img { 
  float: <?php echo ($mandigo_nofloat ? 'none' : ($mandigo_floatright ? 'left' : 'right')); ?>;
  margin: 3px <?php echo ($mandigo_floatright ? 10 : 0); ?>px 3px <?php echo ($mandigo_floatright ? 0 : 10); ?>px;
}

#commentform input { margin: 5px 0 1px 5px; }

#commentform #submit { margin: 0 0 0 1em; }

#commentform #submit, #rss { float: left; }

ol, ul { padding: 0 20px 0; }

ol ol, ol ul, ul ul, ul ol { padding: 0 10px 0 0; }

ul { margin-right: 0; } 

li { margin: 3px 5px 4px 0; }

.sidebars li {
  margin: 0 25px 15px 0;
<?php if ($ie): ?>
  margin: 10px 20px 15px 0;
<?php endif; ?>
}

<?php if ($firefox): ?>
.pages li {
  display: table-cell;
  padding: 0 1em;
}

.sidebars>li {
  list-style-image: none;
  list-style-type: none;
}

.sidebars>li .widgettitle {
  background-image: url(schemes/<?php echo $mandigo_scheme; ?>/images/star.gif);
  background-repeat: no-repeat;
  background-position: top right;
  margin-right: -20px;
  padding-right: 20px;
}
<?php endif; ?>

.sidebars p, .sidebars select { margin: 5px 0 8px 0; }

.sidebars ul, .sidebars ol { margin: 5px 5px 0 0; }

.sidebars ul ul, .sidebars ol { margin: 0 10px 0 0; }

.switch-post {
  float: left;
}
<?php 
  endif;
  // end of rtl scripts specific rules
?>
