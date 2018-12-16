<?php
 		/*
		Copyright 2007  Joachim Praetorius (yatcp@organisiert.net)

    YATCP is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation using version 2 of the License.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
		*/
?>
<?php
	global $cmts, $cmt_ID;
	/* This variable is for alternating comment background */
	$oddcomment = 'alt';
	
	global $vl_yatcp_top_level;
	if( !isset($vl_yatcp_top_level) ) {
		$vl_yatcp_top_level = true;
	}
?>

<?php if ($cmts && !empty($cmts[$cmt_ID])) :

	?><ol class="yatcp_commentlist" <?php
		if( $vl_yatcp_top_level ) { 
			echo "style='margin: 0px;'";
		}
	?>>
	<?php foreach ($cmts[$cmt_ID] as $comment) : ?>
	
	<?php if( $vl_yatcp_top_level ) { ?>
	<div class="blogbefore">
	    	<div class="left"></div>
	    	<div class="right"></div>
	    	<div class="middle"></div>
	</div>
	<div class="post">
	<?php }
	else { ?>
		<div class="reply">
	<?php
	} ?>
		<li class="<?php echo $oddcomment; ?> named" id="comment-<?php comment_ID() ?>">
			<div class="comment-author"><?php comment_author_link(); ?></div>
			<div class="headertext"><?php comment_type(); ?> <?php _e('on');?> <?php comment_time(__('F jS, Y')); ?>. <a href="#comment_parent" onclick="document.getElementById('comment_parent').value='<?php comment_ID()?>';">Reply</a> <?php edit_comment_link('e', '', ''); ?></div>
			<?php if ($comment->comment_approved == '0') : ?>
			<p><em>
			<?php _e( 'Your comment is awaiting moderation.', VL_DOMAIN ); ?>
			</em></p>
			<?php endif; ?>
			<?php comment_text() ?>
			<?php
				if(!count(yatcp_find_comments($comment))==0){
					$top_level = $vl_yatcp_top_level;
					$vl_yatcp_top_level = false;
					yatcp_show_comments($comment); 
					$vl_yatcp_top_level = $top_level;
				} 
			?>
		</li>
	<?php if( $vl_yatcp_top_level ) { ?>
	</div>
	<div class="blogafter">
	    	<div class="left"></div>
	    	<div class="right"></div>
	    	<div class="middle"></div>
	</div>
	<?php }
	else { ?>
		</div>
	<?php
	} ?>

	<?php /* Changes every other comment to a different class */
		if ('alt' == $oddcomment) $oddcomment = 'even';
		else $oddcomment = 'alt';
	?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>
<?php endif; ?>
