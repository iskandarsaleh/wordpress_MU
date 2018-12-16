<?php if ( comments_open() ) : ?>

<div class="blogbefore">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>
<div class="post">
<div class="comment-form-title named" id="respond"><?php _e('Leave a comment', VL_DOMAIN); ?></div>
<div class="headertext">
	<p><?php _e('Names and email addresses are required (email addresses aren\'t displayed), url\'s are optional.', VL_DOMAIN); ?></p>
	<p><?php _e('Comments may contain the following xhtml tags:', VL_DOMAIN); ?><br />
	<?php echo allowed_tags(); ?>
	</p>
	<?php
		if( function_exists('get_theme_option') ) {
			$policy = get_theme_option('comment-policy');
			if( !empty( $policy ) ) {
				echo $policy;
			}
		}
	?>
</div>
<form id="commentform" action="<?php echo get_option('home'); ?>/wp-comments-post.php" method="post">

	<div>
	<textarea name="comment" id="comment" cols="40" rows="6" tabindex="4"></textarea>
	<input type="hidden" name="comment_post_ID" value="<?php echo $post->ID; ?>" />
	<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" />
	</div>

<?php if(!$user_ID) : 
	$comment_author = "";
	if( isset( $_COOKIE[ 'comment_author_' . COOKIEHASH ] ) )
		$comment_author = $_COOKIE[ 'comment_author_' . COOKIEHASH ];
		
	$comment_email = "";
	if( isset( $_COOKIE[ 'comment_author_email_' . COOKIEHASH ] ) )
		$comment_email = $_COOKIE[ 'comment_author_email_' . COOKIEHASH ];

	$comment_url = "";
	if( isset( $_COOKIE[ 'comment_author_url_' . COOKIEHASH ] ) )
		$comment_url = $_COOKIE[ 'comment_author_url_' . COOKIEHASH ];
		
?>

	<div id="inputcontainer">
	<div id="namefield">
	  <input type="text" name="author" id="author" class="textarea" value="<?php echo $comment_author; ?>" size="15" tabindex="1" /><br />
	  <label for="author"><?php _e('Name', VL_DOMAIN); ?></label>
	</div>
	<div id="emailfield">
	  <input type="text" name="email" id="email" value="<?php echo $comment_email; ?>" size="15" tabindex="2" /><br />
	  <label for="email"><?php _e('E-mail', VL_DOMAIN); ?></label>
	</div>
	<div id="urlfield">
	  <input type="text" name="url" id="url" value="<?php echo $comment_url; ?>" size="15" tabindex="3" /><br />
	   <label for="url"><acronym title="<?php _e( "Uniform Resource Identifier", VL_DOMAIN); ?>"><?php _e( 'URI', VL_DOMAIN ); ?></acronym></label>
	</div>
	</div>

<?php else : ?>

        <p class="identity">
          <?php
          	echo __('You are logged in as', VL_DOMAIN) . " <em>$user_identity</em>.";
		  ?>
        </p>

<?php endif; ?>

	<p id="submitter">
	  <input name="submit" id="submit" type="submit" value="<?php _e("I'm done, post it.", VL_DOMAIN ); ?>" />
	</p>

	<?php do_action('comment_form', $post->ID); ?>
	
</form>
</div>
<div class="blogafter">
    	<div class="left"></div>
    	<div class="right"></div>
    	<div class="middle"></div>
</div>

<?php else : // Comments are closed ?>

<?php endif; ?>

