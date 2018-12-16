<div id="post-forum">

<div id="post-forum-submit">
<?php if ( !is_topic() ) : ?>
<p id="notice">To avoid duplicate topics, please do a <a href="#wraps">search</a> on your question before posting</p>
<div class="form-box">
<p class="form-topic"><?php _e('Topic title: (be brief and descriptive)'); ?></p>
<p><input name="topic" type="text" class="intext" id="topic" size="50" maxlength="80" tabindex="1" /></p>
</div>

<?php endif; do_action( 'post_form_pre_post' ); ?>

<div class="form-box">
<p class="form-topic">
<?php _e('Post:'); ?><br /><br />
<?php _e('Allowed markup:'); ?><br />
<code><?php allowed_markup(); ?>
<br /><?php _e('Put code in between <code>`backticks`</code>.'); ?>
</code>
<br /><br />
<code>If this is a support question, please make sure you have searched the forums, browsed and searched our <a href="http://help.edublogs.org/" target="_blank">comprehensive help and support site</a>, checked out our <a href="http://help.edublogs.org/faq/">FAQs</a> and generally tried to fix it yourself :)
<br /><br />
Then, if you're still stuck let us know how we can help you - but please remember to be <a href="http://edublogs.org/forums/topic.php?id=7593" target="_blank">specific, courtous, <strong>provide specific URLs</strong> wherever you can and join in the chat</a>!
<br /><br />
Otherwise... go for it!</code>
</p>

<p>
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
<script type="text/javascript">edToolbar()</script> </p>
<textarea name="post_content" class="inarea" cols="50" rows="8" id="post_content" tabindex="3"></textarea>
<script type="text/javascript">var edCanvas = document.getElementById('post_content');</script>
</p>

</div>

<?php if ( !is_topic() ) : ?>

<div class="form-box">
<p class="form-topic"><?php printf(__('Enter a few words (called <a href="%s">tags</a>) separated by spaces to help someone find your topic:'), get_tag_page_link()) ?></p>
<p><input id="tags-input" name="tags" type="text" class="intext" value="<?php tag_name(); ?>" /></p>
</div>

<?php endif; ?>

<?php if ( is_tag() || is_front() ) : ?>

<div class="form-box">
<p class="form-topic"><?php _e('Pick a section:'); ?></p>
<p><?php bb_new_topic_forum_dropdown(); ?></p>
</div>

<?php endif; ?>

<p class="submit">
<input type="submit" class="sinput" id="postformsub" name="Submit" value="<?php echo attribute_escape( __('Submit Post &raquo;') ); ?>" />
</p>

</div>

</div>