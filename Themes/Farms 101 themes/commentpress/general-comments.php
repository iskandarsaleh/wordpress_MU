<?
	$permalink_structure = get_option('permalink_structure');

	$comments_by_section = ('' != $permalink_structure ) ? "comments-by-section/?" : "?page_id=".get_option('commentpress_id_comment_by_section')."&";
	$comments_by_user = ('' != $permalink_structure ) ? "comments-by-user/?" : "?page_id=".get_option('commentpress_id_comment_by_user')."&";
	$general_comments = ('' != $permalink_structure ) ? "general-comments/?" : "?page_id=".get_option('commentpress_id_general_comments')."&";

?>

<div id="narrowcolumn">
	<?php // Do not delete these lines
	/*
		if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		 die ('Please do not load this page directly. Thanks!');
	*/
	if (!empty($post->post_password)) { // if there's a password
	 if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
		?> 
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.');?><p> 
		<?php
			return;
	 }
	}
	
	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
	?> 

		 <div id="genCommentsList"> 
		 
		 <?php $comments = get_approved_comments($post->ID); ?> 
		 <?php if ($comments) : ?> 
		 <h2> <?php comments_number('No ', 'One comment in ', '% ' );?> <?php the_title(); ?></h2> 
			 
		 <div class="commentlist"> 
			 <?php foreach ($comments as $comment) : ?> 
			 <div class="commentAuthor <?php echo $oddcomment; ?>" id="comment-<?php comment_ID() ?>">
				 <?php comment_author_link() ?> 
				 <span class="normalLight"> says:</span></div>
				<div>
				 <?php if ($comment->comment_approved == '0') : ?> 
				 <em><?php _e('Your comment is awaiting moderation.');?></em> 
				 <?php endif; ?> 
				 <?php comment_text() ?> 
				 <div class="cp_commentMeta">
				 <?php comment_date('F j, Y') ?> 
				 
				 <?php comment_time() ?> 
				 <?php edit_comment_link(__('Edit'),' | ',''); ?> 
				 </div> 
			 </div>
			 <br /> 
			 <?php /* Changes every other comment to a different class */	
			if ('alt' == $oddcomment) $oddcomment = '';
			else $oddcomment = 'alt';
		?> 
			 <?php endforeach; /* end for each comment */ ?> 
		 </div> 
		 <?php else : // this is displayed if there are no comments so far ?> 
		 <?php if ('open' == $post->comment_status) : ?> 
		 <!-- If comments are open, but there are no comments. --> 
		<div class="commentResponse">Here you post general comments not tied to any specific page or paragraph.</div>
		 <?php else : // comments are closed ?> 
		 <!-- If comments are closed. --> 
		 <p class="nocomments"><?php _e('Comments are closed.');?><p> 
		 <?php endif; ?> 
		 <?php endif; ?> 
		 <!-- END genCommentsList --> 
	 </div> 
</div>
<div id="widecolumn" style="padding-left: 30px;">
	<?php if ('open' == $post->comment_status) : ?> 

		 <?php if ( $user_ID ) : ?> 
		 <h3 id="respond">Post a general comment</h3> 
		 <?php else : ?> 
		 <h3 id="respond">Please login </h3> 
		 <?php endif; ?> 

	<div id="genCommentsForm"> 
		 <?php if ( get_option('comment_registration') && !$user_ID ) : ?> 
		 <!--
	<p><?php _e('You must be');?> <a href="<?php bloginfo('wpurl'); ?>/wp-login.php?redirect_to=<?php the_permalink(); ?>"><?php _e('logged in');?></a> <?php _e('to post a comment.');?></p>
	--> 
		 <div id="loginLayer" style="display:block"> 
			<form name="loginform" id="loginform" action="<?php bloginfo('wpurl'); ?>/wp-login.php" method="post"> 
				 <p> 
					<label>Username:<br /> 
					 <input type="text" name="log" id="log" value="" size="20" tabindex="1" /> 
					 </label> 
				</p> 
				 <p> 
					<label>Password:<br /> 
					 <input type="password" name="pwd" id="pwd" value="" size="20" tabindex="2" /> 
					 </label> 
				</p> 
				 <p> 
					<label> 
					 <input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="3" /> 
					 Remember me</label> 
				</p> 
				 <p class="submit"> 
					<input type="submit" name="submit" id="submit" value="Login &raquo;" tabindex="4" /> 
					<input type="hidden" name="redirect_to" value="<?php echo $_SERVER['REQUEST_URI']; ?>" /> 
					<!--<input type="hidden" name="redirect_to" value="wp-admin/" />--> 
				</p> 
			 </form> 
			<!--
		<ul>
			<li><a onclick="postCommentTabContent('registerLayer')">Register</a></li>
			<li><a onclick="postCommentTabContent('forgotPasswordLayer');" title="Password Lost and Found">Lost your password?</a></li>
		</ul>
		--> 
		</div> 
		 <?php else : ?> 
		 <form action="<?php bloginfo('wpurl'); ?>/wp-comments-post.php" method="post" id="commentform"> 
			<?php if ( $user_ID ) : ?> 
			<p><?php _e('Logged in as');?> <a href="<?php bloginfo('wpurl') ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>. <a href="<?php bloginfo('wpurl'); ?>/wp-login.php?action=logout" title="<?php _e('Log out of this account');?>"><?php _e('Logout');?> &raquo;</a></p> 
			<?php else : ?> 
			<p> 
				 <input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /> 
				 <label for="author"><small><?php _e('Name');?> <?php if ($req) echo "__('(required)')"; ?> 
				 </small></label> 
			 </p> 
			<p> 
				 <input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /> 
				 <label for="email"><small>Mail (will not be published)
				 <?php if ($req) echo "__('(required)')"; ?> 
				 </small></label> 
			 </p> 
			<p> 
				 <input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /> 
				 <label for="url"><small><?php _e('Website');?></small></label> 
			 </p> 
			<?php endif; ?> 
			<!--<p><small><strong>XHTML:</strong> <?php _e('You can use these tags:');?> <?php echo allowed_tags(); ?></small></p>--> 
			<p> 
				 <textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea> 
			 </p> 
			<p> 
				 <input name="submit" type="submit" id="submit" tabindex="5" value="<?php _e('Submit Comment');?>" /> 
				 <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /> 
			 </p> 
			<?php do_action('comment_form', $post->ID); ?> 
		</form> 
		 <?php endif; /* If registration required and not logged in*/ ?> 
		 <!-- END genCommentsForm --> 
	 </div> 
	<?php endif; /* if you delete this the sky will fall on your head*/ ?> 
<!-- end pages_rightCol -->	

