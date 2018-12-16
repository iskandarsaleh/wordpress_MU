<?php 

	$permalink_structure = get_option('permalink_structure');

	$comments_by_section = ('' != $permalink_structure ) ? "comments-by-section/?" : "?page_id=".get_option('commentpress_id_comment_by_section')."&";
	$comments_by_user = ('' != $permalink_structure ) ? "comments-by-user/?" : "?page_id=".get_option('commentpress_id_comment_by_user')."&";
	$general_comments = ('' != $permalink_structure ) ? "general-comments/?" : "?page_id=".get_option('commentpress_id_general_comments')."&";

	$usersWhoHaveCommented = getUsersWhoHaveCommented();
?>
<!-- START THE PAGE -->
<!-- already in pageContainer -->
 <div id="narrowcolumn"> 
	<h2>Table of Comments (<?= getAllCommentCount(); ?>)</h2> 
	<h3 style="margin-top: -20px;margin-bottom: 22px;">by commenter</h3> 
	<ul class="indexCommentsList">
		 <? foreach($usersWhoHaveCommented as $key=>$u) { ?> 
		 <li><a href="<?php bloginfo('url'); ?>/<?php echo $comments_by_user; ?>id=<?= ($u->user_id > 0) ? $u->user_id : $u->comment_author; ?>"><? echo $u->comment_author; ?></a> <span class="normalLight">(<? echo $u->comments_per_user; ?>)</span></li>
		 <? }?> 
	 </ul> 
	<!-- END disc_leftCol --> 
</div> 
<?

	$comments = getCommentsFromUser($_GET['id']);
	$userDetails = getAuthorInformation((int)$_GET['id']);

?> 
<div id="widecolumn"> 
	<div class="post" id="post-<?php the_ID(); ?>"> 
		<h3>Comments by </h3> 
		<? if(!strlen($_GET['id'])){ ?> 
		<div class="entrytext"> 
			
		<? echo '<br/><div class="commentResponse" style="display:block">This page contains a running transcript of all conversations taking place on the site. Click through the menu on the left to view comments by individual contributor. Click the "go to thread" link to see the comment in context.</div> ' ?>
			
			<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?> 
			<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?> 
			<!-- END entrytext --> 
		</div> 
		<? } ?> 
		<div id="disc_commentContainer"> 
			<h2><?php 
			
			
			if(strlen($userDetails->display_name)){
			 echo $userDetails->display_name;
			echo "&nbsp;<span class=\"normalLight\"><em>on...</em></span>";
			}
			else{
			 echo $_GET['id'];
			}
			
			
			
			?> </h2> 
			
	<?php 
					// should should never happen... but just in case.
				if(count($comments)==0 && strlen($_GET['id']) ){	
					echo '<br/><div class="commentResponse" style="display:block">There are no comments in this section.</div> ';
				}
	?> 

			<?php
			foreach ($comments as $key=>$comment) { 
			($comment->comment_parent == 0) ? $isCommentChild = 0 : $isCommentChild = 1;  
				// if this is a child comment, get some information about the parent comment
				if($isCommentChild){
					$commentParentArray = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_ID = ".$comment->comment_parent);
				}
					$commentParentObject = $commentParentArray[0]; 
			 ?>
			<div class="cp_indexList"> 
			 
				<div class="commentReference"><b><? echo $comment->post_title; ?></b>, <span class="normalLight"><i><? echo ($comment->comment_contentIndex > 0) ? "paragraph ".$comment->comment_contentIndex : " whole page"; ?></i></span><?php if($isCommentChild){ echo "<span class=\"normalLight\">, replying to </span>".$commentParentObject->comment_author; }?></div> 
				<!-- moderation notification or commment text --> 
				<?php if ($comment->comment_approved == '0') { ?> 
				Your comment is awaiting moderation.
				<?php }
			else {?> 
				<span id="allTheCommentText-<? echo $comment->comment_ID; ?>"> 
				<?php comment_text(); 
			}
			?> 
				</span> 
				
				<?php if($isCommentChild==1){ ?>
				<div class="commentParentLink"> 
					<!-- parent comment text --> 
					<span class="smDark" style="text-transform: uppercase;"><?php echo $commentParentObject->comment_author; ?></span> <span class="smLight">said...</span></div>
				<div class="commentParentText">
					<?php echo $commentParentObject->comment_content; ?> 
				</div>
				<br /> 
			 	<?php } ?>
				
				<!-- comment metadata --> 
				<div class="cp_commentMeta"> 
					<!-- Go to text --> 
					<?php 
			// Go to the Text link takes you to the text, highlights the paragraph, and scrolls to the comment (comment is at top of the comment area)
			if($comment->post_name == 'general-comments'){?> 
					<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#comment-<? echo $comment->comment_ID; ?>" class="cp_goToText_noaction">go to thread &raquo;</a> 
					<?php }else if($comment->comment_contentIndex == 0){  ?> 
					<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#<? echo $comment->comment_contentIndex; ?>" class="cp_goToText_noaction">go to thread &raquo;</a> 
					<?php } else{ ?> 
					<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#<? echo $comment->comment_contentIndex; ?>" class="cp_goToText_noaction">go to thread &raquo;</a> 
					<? }?> 
					<? 
			// Reply link takes you to comment with reply open (possible?)
			if($comment->comment_parent == 0){ ?> 
					<!--<a href="<?php bloginfo('url'); ?><? echo $currentpost->post_name; ?>#comment_contentIndex_<? echo $comment->comment_contentIndex; ?>">Reply to this comment</a>--> 
					<? } ?> 
					<div class="cp_posted"> Posted <? comment_date(); echo " &nbsp;"; comment_time(); ?> </div> 
				</div> 
				<?php /* Changes every other comment to a different class */
	if ('alt' == $oddcomment){ 
		$oddcomment = '';
	}
	else{
		$oddcomment = 'alt';
	}
	?> 
			</div> 

			<?php } /* end for each comment */ ?> 

			<!-- END disc_commentContainer --> 
		</div> 

		<!-- end disc_rightCol --> 
		</div>