<div class="wrap">
<h1 class="wp-heading-inline">Add New Question</h1>

<hr class="wp-header-end"><div id="lost-connection-notice" class="error hidden">
	<p><span class="spinner"></span> <strong>Connection lost.</strong> Saving has been disabled until you’re reconnected.	<span class="hide-if-no-sessionstorage">We’re backing up this post in your browser, just in case.</span>
	</p>
</div>


<form name="post" action="" method="post" id="screening-question">	
<?php wp_nonce_field(); ?>
<input type="hidden" name="question_id" value="0"/>
	
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content" style="position: relative;">

<div id="titlediv">
<div id="titlewrap">
		
	<input type="text" name="question_title" size="30" value="" id="title" spellcheck="true" autocomplete="off" placeholder="Enter question here" required>
</div>

</div><!-- /titlediv -->

</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables ui-sortable" style=""><div id="submitdiv" class="postbox ">
<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Publish</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>Publish</span></h2>
<div class="inside">
<div class="submitbox" id="submitpost">
<div id="major-publishing-actions">
<div id="publishing-action">
<span class="spinner"></span>
		<input name="original_publish" type="hidden" id="original_publish" value="Publish">
		<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Publish"></div>
<div class="clear"></div>
</div>
</div>

</div>
</div>


</div></div>

</div><!-- /post-body -->
<br class="clear">
</div><!-- /poststuff -->
</form>
</div>