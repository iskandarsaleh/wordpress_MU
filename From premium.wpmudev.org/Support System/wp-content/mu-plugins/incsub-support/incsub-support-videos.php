<?php
// no kiddies.
if ( !defined("ABSPATH") and !defined("INCSUBSUPPORT") ) {
	die("I don't think so, Tim.");
}

$my_videos = array(
	'blogging-introduction' => array( 'title' => 'An introduction to blogging', 'runtime' => '5:39', 'filename' => 'blogging-introduction'),
	'writing-a-post' => array( 'title' => 'Writing a post', 'runtime' => '4:48', 'filename' => 'writing-a-post'),
	'changing-your-design' => array( 'title' => 'Changing your design/theme', 'runtime' => '4:30', 'filename' => 'changing-your-design'),
	'changing-your-settings' => array( 'title' => 'Changing your settings', 'runtime' => '4:58', 'filename' => 'changing-your-settings'),
	'managing-your-blog' => array( 'title' => 'Managing your blog', 'runtime' => '4:21', 'filename' => 'managing-your-blog'),
);

$my_videos = apply_filters("incsub_support_videos", $my_videos);

	if ( !empty($_GET['video']) ) {
		if ( array_key_exists($_GET['video'], $my_videos ) ) {
			global $current_site;
			$vid_link = 'http://'. $current_site->domain . $current_site->path .'wp-admin/support/videos/'. $my_videos[$_GET['video']]['filename'] .'.swf';
?>
		<h2 id="player">Now Playing: <?php echo $my_videos[$_GET['video']]['title']; ?></h2>
		<br />
		<div style="text-align: center" align="center">
			<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="640" height="480">
				<param name="movie" value="<?php echo $vid_link; ?>"></param>
				<param name="quality" value="high"></param>
				<param name="bgcolor" value="#FFFFFF"></param>
				<param name="allowFullScreen" value="true"></param>
				<param name="scale" value="showall"></param>
				<param name="allowScriptAccess" value="always"></param>
				<embed src="<?php echo $vid_link; ?>" quality="high" bgcolor="#FFFFFF" width="640" height="480" type="application/x-shockwave-flash" 
					allowScriptAccess="always" allowFullScreen="true" scale="showall"></embed>
			</object>
			<br />
			<p style="text-align: center;">Approx running time: <?php echo $my_videos[$_GET['video']]['runtime']; ?></p>
		</div>
<?php
		} else {
?>
			<p style="text-align: center;">The video requested was not found.</p>
<?php
		}
	} else {
		// print a list of videos, with a link.
?>
		<h2>Video Library</h2>
		<ul>
<?php
		foreach ( $my_videos as $key => $val ) {
			echo '
			<li><a href="/wp-admin/support.php?page=videos&amp;video='. $key .'#player" title="'. $val['title'] .'">'. $val['title'] .'</a> <small>(Approximate runtime: '. $val['runtime'] .')</small></li>';
		}
?>
		</ul>
<?php
	}
?>