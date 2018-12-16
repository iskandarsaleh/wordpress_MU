<?php // Do not delete these lines
/* Don't remove these lines. */
add_filter('comment_text', 'popuplinks');
foreach ($posts as $post) { start_wp();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
     <title><?php echo get_settings('blogname'); ?> - <?php echo sprintf(__("Comments on %s"), the_title('','',false)); ?></title>

	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php echo get_settings('blog_charset'); ?>" />
	<style type="text/css" media="screen">
		@import url( <?php bloginfo('stylesheet_url'); ?> );
	</style>
<?php
    /*
    You can uncomment the below lines, which will give you a function to call for
    a comment preview IF you're not using the Live Preview: Admin Panel, Comments
    plug-in by Chris Davis, on which the code is based but modified from for my purposes
    Also, you'll need to uncomment a bunch of stuff in comments.php
    */
    // $javascript = "<script type=\"text/javascript\">\n<!--\nfunction ReloadTextDiv()\n{\nvar NewText = document.getElementById(\"comment\").value;\nsplitText = NewText.split(/\\n/).join(\"<br />\");\nvar DivElement = document.getElementById(\"TextDisplay\");\nDivElement.innerHTML = splitText;\n}\n//-->\n</script>\n";
    // echo $javascript;
?>

<!--
You can uncomment these two lines to enable buttons quicktags on the comment form
IF you're not using Owen Winkler's quicktags plugin <http://www.asymptomatic.net/wp-hacks>,
on which the buttons.js code is based, but slightly modified from

<script src="<?php echo get_settings('siteurl') ?>/wp-admin/quicktags.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri() ?>/buttons.js" type="text/javascript"></script>
-->

</head>
<body id="commentspopup">

<h1 id="header"><a href="" title="<?php echo get_settings('blogname'); ?>"><?php echo get_settings('blogname'); ?></a></h1>
<div id="popupContainer">
<?php
// this line is WordPress' motor, do not delete it.
$comment_author = (isset($_COOKIE['comment_author_' . COOKIEHASH])) ? trim($_COOKIE['comment_author_'. COOKIEHASH]) : '';
$comment_author_email = (isset($_COOKIE['comment_author_email_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_email_'. COOKIEHASH]) : '';
$comment_author_url = (isset($_COOKIE['comment_author_url_'. COOKIEHASH])) ? trim($_COOKIE['comment_author_url_'. COOKIEHASH]) : '';
$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $id AND comment_approved = '1' ORDER BY comment_date");
$commentstatus = $wpdb->get_row("SELECT comment_status, post_password FROM $wpdb->posts WHERE ID = $id");

	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = 'alt';
?>

<!-- You can start editing here. -->

<?php
// default gravatar image URL
$gravatarURL = get_template_directory_uri() . "/gravatar-default.jpg";
$gravatarSize = 80;
$gravatarRating = "R";
?>


<?php if ($comments) : ?>
	<h4 id="comments"><?php comments_number(__('No Responses'), __('One Response'), __('% Responses' ));?> <?php _e('to');?>  &#8220;<?php the_title(); ?>&#8221;</h4> 

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li id="comment-<?php comment_ID() ?>" class="<?php echo $oddcomment; ?>">
		<div>
		<img class="gravatar" alt="" src="<?php
		// all of this stuff is to fill in the fields for the comment preview
		$gravatarEmail = $comment->comment_author_email;	
		$theGravatar = "http://www.gravatar.com/avatar.php?gravatar_id=".md5($gravatarEmail)."&amp;default=".urlencode($gravatarURL)."&amp;size=".$gravatarSize."&amp;rating=".$gravatarRating;
		echo $theGravatar;
		?>" />
			<div class="commentAuthor">
			<?php
			comment_type(__(''), __('Trackback from '), __('Pingback from '));
			comment_author_link();
			comment_type(__(' wrote'), __(''), __('')); ?>:	
			</div>
		<?php
		if ($comment->comment_approved == '0') : ?>
			<p><em><?php _e('Your comment is awaiting moderation.');?></em></p>
		<?php
		else :
			comment_text();
		endif;
		$i = $i + 1;
		?>
			<div class="commentTimestamp"><a href="#comment-<?php comment_ID() ?>"><?php comment_date('l, m.d.Y ') ?> <?php _e('at');?> <?php comment_time() ?></a><?php edit_comment_link(__("Edit This"), ' |'); ?>
			</div>
		</div>
		</li>
		
	
		<?php /* Changes every other comment to a different class */	
			if ('alt' == $oddcomment) $oddcomment = '';
			else $oddcomment = 'alt';
		?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

<?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php _e('Comments are closed.');?><p>
		
	<?php endif; ?>
	
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

<h4 id="respond"><?php _e('Leave a Comment');?></h4>

<?php if ( get_option('comment_registration') ) : // if comment registration is mandatory ?>

	<?php if ($user_ID) : // if the user is signed in ?>
	
		<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
		<p class="commentAuthor">
		Welcome back <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>
		</p>
		<p class="commentWelcome">		
		To use HTML formatting, highlight the text you want to format then click one of the four buttons.  
		To customize the avatar that appears by your comment, visit <a href="http://www.gravatar.com/">Gravatar.com</a>.
		<?php if ( pings_open() ) : ?>
		The trackback URL for this post is
		<a href="<?php trackback_url() ?>" rel="trackback">here</a>.
		<?php endif; ?>
		You can log out <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">here</a>.
		</p>
		<p>
		<!-- <script type="text/javascript"> // edToolbar2();</script>
		<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4" onkeyup="ReloadTextDiv();"></textarea> -->
		<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea>
		<!--
		<script type="text/javascript"> // var edCanvas = document.getElementById('comment');</script>
		</p>		
		<p><label for="preview"><strong>Preview</strong></label>
		</p>
		<?php
//		$theGravatar = "http://www.gravatar.com/avatar.php?gravatar_id=".md5( $comment_author_email )."&amp;default=".urlencode($gravatarURL)."&amp;size=".$gravatarSize."&amp;rating=".$gravatarRating;
		?>
		<div class="commentPreview">
		<div class="commentPreviewSpacer"></div>
		<span style="float: left;"><img class="gravatar" src="<?php // echo $theGravatar ?>" /></span>
		<div class="commentPreviewUsername">
		<a href="<?php // echo get_option('siteurl') ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>
		wrote:</div>
		<p id="TextDisplay"></p>
		<div class="commentPreviewSpacer"></div>
		</div>
		<p class="commentPreviewSpacer"><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit');?>" /></p>
		-->
		<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
		<?php do_action('comment_form', $post->ID); ?>
		</form>


	<?php else : // if the user is not signed in ?>
		<p><?php _e('You must be');?> <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
	<?php endif; ?>

<?php elseif ( !get_option('comment_registration') ) : // user registration is not mandatory to post comments, so we use cookie info instead ?>	

	<form action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post" id="commentform">
	
	<?php if ($comment_author == "" or $comment_author_email == "") : // either no user or no email stored in cookie, so we display entry fields ?>
	
		<?php if (!$user_ID) : ?>
		
			<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
			<label for="author"><strong>Name</strong> <?php if ($req) _e('(required)'); ?></label></p>
			
			<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
			<label for="email"><small><strong>Email</strong> (will not be published) <?php if ($req) _e('(required)'); ?></small></label></p>
			
			<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
			<label for="url"><strong><?php _e('Website');?></strong></label></p>
		
		<?php elseif ($user_ID) : ?>
		
			<p class="commentAuthor">
			Welcome back <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>
			</p>
		
		<?php endif; ?>
		
	<?php elseif ($comment_author != "" && $comment_author_email != "" && !$user_ID) : // at least user name and info is stored in cookie, so we display welcome message and make user info fields hidden ?>
	
		<?php /*
		For the mass-distributed theme, this has to be commented out because there's not
		a good way within Wordpress to clear user info from the cookies. I do it with the
		forget user info hack. Uncomment this HTML and comment out the three sets of HTML
		fields to pretify the welcome screen for non-registered users who have cookies set.
		Only recommended if you have the Forget User Info hack working already.
		
		<input type="hidden" name="author" id="author" value="<?php echo $comment_author; ?>" />
		<input type="hidden" name="email" id="email" value="<?php echo $comment_author_email; ?>" />
		<input type="hidden" name="url" id="url" value="<?php echo $comment_author_url; ?>" />
		<p class="commentAuthor">
		Welcome back 
		<?php
		$namePrefix = "";
		$nameSuffix = "";
		if ($comment_author_url != "") :
			$namePrefix = "<a href=\"" . $comment_author_url . "\">";
			$nameSuffix = "</a>";
		endif;
		echo $namePrefix . $comment_author . $nameSuffix;
		?>
		</p>
		*/ ?>
		<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
		<label for="author"><strong>Name</strong> <?php if ($req) _e('(required)'); ?></label></p>
		
		<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
		<label for="email"><small><strong>Email</strong> (will not be published) <?php if ($req) _e('(required)'); ?></small></label></p>
		
		<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
		<label for="url"><strong><?php _e('Website');?></strong></label></p>
		
	<?php elseif ($user_ID) : // because a logged-in user's info takes priority over cookie info, even when they're different ?>
		
		<p class="commentAuthor">
		Welcome back <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>
		</p>
		
	<?php endif; ?>
	
	<p class="commentWelcome">
	<?php if ($comment_author != "" && $comment_author_email != "" && !$user_ID) : // if there's any user info stored, give the user the option to erase it ?>
		
		<?php /*
		
		Requires the Forget User Info hack/plug-in
		Info at http://www.scriptygoddess.com/archives/2004/06/29/forget-user-info/
		
		If you're not <?php echo $comment_author ?> or you want to change information you previously submitted,
		click <a href="<?php echo get_settings('siteurl') ?>/forget_user_info=1">here</a>.
		*/ ?>
	
		
	<?php elseif ($user_ID) : ?>
		
		You can log out <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account') ?>">here</a>.
	
	<?php endif; ?>
	<!-- you can uncomment the line below if you're using the HTML quicktags.js script -->
	<!-- To use HTML formatting, highlight the text you want to format then click one of the four buttons. -->
	To customize the avatar that appears by your comment, visit <a href="http://www.gravatar.com/">Gravatar.com</a>.
	<?php if ( pings_open() ) : ?>
		The trackback URL for this post is
		<a href="<?php trackback_url() ?>" rel="trackback">here</a>.
	<?php endif; ?>
	</p>
	<p>
	<!-- <script type="text/javascript"> // edToolbar2();</script> -->
	<!-- <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4" onkeyup="ReloadTextDiv();"></textarea> -->
	<!-- uncomment the above line and comment out the below line to use the preview -->
	<textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4" ></textarea>
	<!-- <script type="text/javascript"> // var edCanvas = document.getElementById('comment');</script> -->
	</p>
	<!--
	<p><label for="preview"><strong>Preview</strong></label>
	</p>
	<?php
//	$theGravatar = "http://www.gravatar.com/avatar.php?gravatar_id=".md5( $comment_author_email )."&amp;default=".urlencode($gravatarURL)."&amp;size=".$gravatarSize."&amp;rating=".$gravatarRating;
	?>	
	<div class="commentPreview">
	<div class="commentPreviewSpacer"></div>
	<span style="float: left;"><img class="gravatar" src="<?php echo $theGravatar ?>" /></span>
	<div class="commentPreviewUsername">
	<?php // if ($comment_author != "" && $comment_author_email != "") : ?>
	
		<?php // if (!$user_ID) : ?>
		
			<?php /*
			$namePrefix = "";
			$nameSuffix = "";
			if ($comment_author_url != "") :
				$namePrefix = "<a href=\"" . $comment_author_url . "\">";
				$nameSuffix = "</a>";
			endif;
			echo $namePrefix . $comment_author . $nameSuffix;
			*/ ?>
		
		<?php // elseif ($user_ID) : ?>
			
			<a href="<?php // echo get_option('siteurl') ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>
		
		<?php // endif; ?>
				
	
	<?php // elseif ($comment_author == "" && $comment_author_email == "") : ?>
	
		You 
		
	<?php // endif; ?>
	wrote:</div>
	<p id="TextDisplay"></p>
	<div class="commentPreviewSpacer"></div>
	</div> -->
	<p class="commentPreviewSpacer"><input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit');?>" />
	<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
	</p>
	<?php do_action('comment_form', $post->ID); ?>
	</form>

<?php endif; ?>

<?php endif; // if you delete this the sky will fall on your head ?>

<?php } ?>
<script type="text/javascript">
<!--
document.onkeypress = function esc(e) {	
	if(typeof(e) == "undefined") { e=event; }
	if (e.keyCode == 27) { self.close(); }
}
// -->
</script>
</div>
</body>
</html>
