<div id="post-forum">

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Edit Post'); ?></h3>

<div id="post-forum-submit">

<?php if ( $topic_title ) : ?>

<div class="form-box">
<p class="form-topic"><?php _e('Topic title: (be brief and descriptive)'); ?></p>
<p><input name="topic" type="text" class="intext" id="topic" value="<?php echo attribute_escape( get_topic_title() ); ?>" /></p>
</div>

<?php endif; ?>


<div class="form-box">
<p class="form-topic">
<?php _e('Post:'); ?><br /><br />
<?php _e('Allowed markup:'); ?><br />
<code><?php allowed_markup(); ?>
<br /><?php _e('Put code in between <code>`backticks`</code>.'); ?>
<br /><br />
If this is a support question, please make sure you have searched the forums, browsed and searched our <a href="http://help.edublogs.org/" target="_blank">comprehensive help and support site</a>, checked out our <a href="http://help.edublogs.org/">FAQs</a> and generally tried to fix it yourself :)
<br /><br />
Then, if you're still stuck let us know how we can help you - but please remember to be <a href="http://edublogs.org/forums/topic.php?id=7593" target="_blank">specific, courtous, <strong>provide specific URLs</strong> wherever you can and join in the chat</a>!
</code>
</p>

<p>
<script type='text/javascript'>
quicktagsL10n = {
quickLinks: "(Quick Links)",
wordLookup: "Enter a word to look up:",
dictionaryLookup: "Dictionary lookup",
lookup: "lookup",
closeAllOpenTags: "Close all open tags",
closeTags: "close tags",
enterURL: "Enter the URL",
enterImageURL: "Enter the URL of the image",
enterImageDescription: "Enter a description of the image"
}
</script>
<script type="text/javascript">edToolbar()</script>
<textarea name="post_content" class="inarea" cols="50" rows="8" id="post_content"><?php echo apply_filters('edit_text', get_post_text() ); ?></textarea>
<script type="text/javascript">var edCanvas = document.getElementById('post_content');</script>
</p>

</div>


<p class="submit">
<input type="submit" class="sinput" id="postformsub" name="Submit" value="<?php echo attribute_escape( __('Edit Post &raquo;') ); ?>" />
<input type="hidden" name="post_id" value="<?php post_id(); ?>" />
<input type="hidden" name="topic_id" value="<?php topic_id(); ?>" />
</p>




</div>
</div>