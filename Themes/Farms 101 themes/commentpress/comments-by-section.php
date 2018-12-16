<?php

	$permalink_structure = get_option('permalink_structure');

	$comments_by_section = ('' != $permalink_structure ) ? "comments-by-section/?" : "?page_id=".get_option('commentpress_id_comment_by_section')."&";
	$comments_by_user = ('' != $permalink_structure ) ? "comments-by-user/?" : "?page_id=".get_option('commentpress_id_comment_by_user')."&";
	$general_comments = ('' != $permalink_structure ) ? "general-comments/?" : "?page_id=".get_option('commentpress_id_general_comments')."&";

	$comments = commentpress_comments_by_section($_GET['comments']);

	
?>	

<!-- START THE PAGE -->
<!-- already in pageContainer -->
 <div id="narrowcolumn"> 
	<h2>Table of Comments (<?= getAllCommentCount(); ?>)</h2> 
	<? $commentpress_setting = get_option('commentpress_default_front_page');  // 1 = blog, 2 = document?>
	<h3 style="margin-top: -20px;margin-bottom: 22px;"><?php echo ($commentpress_setting=='blog')? "by post" : "by section"; ?></h3> 

	<ul class="indexCommentsList">
		<?php
		$post_menu = getParentPosts();
		foreach($post_menu as $item){
		?>
			<li><a href="<?php bloginfo('url'); ?>/<?php echo $comments_by_section; ?>comments=<?= $item->post_name; ?>"><?= $item->post_title; ?></a>  <span class="normalLight">(<?= $item->comment_count; ?>)</span> </li>
		<?
		}
		?>
			<li style="padding-top: 1em;"><a href="<?php bloginfo('url'); ?>/<?php echo $comments_by_section; ?>comments=general-comments&menu=general-comments">General Comments</a>  <span class="normalLight">(<?= getCommentCount('general-comments') ?>)</span> </li>
		
	</ul>	
	<!-- END disc_leftCol --> 
</div> 



 


<div id="widecolumn">
<div class="post" id="post-<?php the_ID(); ?>">

		<h3>Comments on</h3>
			<? if(!strlen($_GET['comments'])){ ?>

			<div class="entrytext">
				<? echo '<br/><div class="commentResponse" style="display:block">This page contains a running transcript of all conversations taking place on the site. Click through the menu on the left to view comments for individual sections. Click the "go to thread" link to see the comment in context.</div> ' ?>

				<?php the_content(__('<p class="serif">Read the rest of this page &raquo;</p>')); ?>	
				<?php link_pages(__('<p><strong>Pages:</strong> '), '</p>', 'number'); ?>
				
			<!-- END entrytext -->
			</div> 
			<?php } ?>
<?php
if($_GET['comments']){

?>
<div id="disc_commentContainer">
	<h2><?php 
	
		$myid =  getPostID($_GET['comments']);
		$pageTitle = get_post($myid);
		echo $pageTitle->post_title; 

	?></h2>
	<?php if(count($comments)==0){	
					echo '<br/><div class="commentResponse" style="display:block">There are no comments in this section.</div> ';
				}
	?> 
	
		<?php
		if(count($comments))

			foreach ($comments as $key=>$comment) { 
				($comment->comment_parent == 0) ? $isCommentChild = 0 : $isCommentChild = 1;  
				// if this is a child comment, get some information about the parent comment
				if($isCommentChild){
					$commentParentArray = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_ID = ".$comment->comment_parent);
				}
					$commentParentObject = $commentParentArray[0]; ?> 
			<div <? if($isCommentChild==0){ echo "class='cp_indexList'"; }else{ echo "class='cp_indexListChild'";} ?> > 
				<!-- comment author name --> 
				<? if($isCommentChild==0){ ?> 
				<div class="commentAuthor" id="comment-<?php comment_ID() ?>" contentIndex="<?php echo $comment->comment_contentIndex; ?>"> <span> 
						<? comment_author(); ?>
					</span><span class="normalLight">
				<? }else if($isCommentChild==1){?> 
				<div class="commentAuthor" id="comment-<?php comment_ID() ?>" contentIndex="<?php echo $comment->comment_contentIndex; ?>"> <span> <? comment_author(); ?></span> <span class="normalLight">replies to </span><?php echo $commentParentObject->comment_author; ?><span class="normalLight">
				<!-- comment reference --> 
				<? } ?> 
				<!-- <div class="commentReference"><b><?= $comment->post_title;  ?></b>,  -->
				<?php 
				($commentpress_setting=='blog')? $pageorpost = "post" : $pageorpost="section";
				if($_GET['comments']=='general-comments'){ 
					echo "in <i>general comments</i>" ;
					}else{
					echo ($comment->comment_contentIndex > 0) ? " on <i>paragraph ".$comment->comment_contentIndex ."</i>": "on <i>the whole ". $pageorpost. "</i>"; 						
				}
				?>
				</span>
				</div> 
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
					<span class="smDark"><span class="smLight"><?php echo $commentParentObject->comment_author; ?></span> said... </span></span></div>
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
					<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#comment-<? echo $comment->comment_ID; ?>" class="cp_goToText_noaction">go to thread  &raquo;</a> 
					<?php }else if($comment->comment_contentIndex == 0){  ?> 
					<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#<? echo $comment->comment_contentIndex; ?>" class="cp_goToText_noaction">go to thread  &raquo;</a> 
					<?php } else{ ?> 
					<a href="<?php echo get_permalink($comment->comment_post_ID); ?>#<? echo $comment->comment_contentIndex; ?>" class="cp_goToText_noaction">go to thread  &raquo;</a> 
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
		<? } ?>
<!-- end disc_rightCol -->
</div>


