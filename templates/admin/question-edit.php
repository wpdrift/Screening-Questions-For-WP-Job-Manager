<?php
global $wpdb;
$table_name = $wpdb->prefix . 'sq_questions';
$item = [];
if (isset($_REQUEST['id'])) {
   $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_GET['id']), ARRAY_A);
   if (!$item) {
      $item = [];
      $notice = __('Item not found', 'wpjmsq');
   }
}
?>
<div class="wrap">
<h1 class="wp-heading-inline">Edit Question</h1>

	
<hr class="wp-header-end"><div id="lost-connection-notice" class="error hidden">
	<p><span class="spinner"></span> <strong>Connection lost.</strong> Saving has been disabled until you’re reconnected.	<span class="hide-if-no-sessionstorage">We’re backing up this post in your browser, just in case.</span>
	</p>
</div>


<form name="post" action="" method="post" id="screening-question">
<?php wp_nonce_field(); ?>
<input type="hidden" name="question_id" value="<?php if(isset($item['ID'])){ echo $item['ID'];} ?>"/>
<div id="poststuff">
<div id="post-body" class="metabox-holder columns-2">
<div id="post-body-content" style="position: relative;">

<div id="titlediv">
<div id="titlewrap">
		
	<input type="text" name="question_title" size="30" id="title" spellcheck="true" autocomplete="off" placeholder="Enter question here" value="<?php if(isset($item['question'])){ echo $item['question'];} ?>" required>
</div>

</div><!-- /titlediv -->

</div><!-- /post-body-content -->

<div id="postbox-container-1" class="postbox-container">
<div id="side-sortables" class="meta-box-sortables ui-sortable" style=""><div id="submitdiv" class="postbox ">
<button type="button" class="handlediv" aria-expanded="true"><span class="screen-reader-text">Toggle panel: Publish</span><span class="toggle-indicator" aria-hidden="true"></span></button><h2 class="hndle ui-sortable-handle"><span>Publish</span></h2>
<div class="inside">
<div class="submitbox" id="submitpost">
<div id="major-publishing-actions">
<div id="delete-action">
<a class="submitdelete deletion" href="<?= admin_url('admin.php?page=wp-job-manager-screening-questions&action=delete&id='.$item['ID']); ?>">Move to Trash</a></div>

<div id="publishing-action">
<span class="spinner"></span>
		<input name="original_publish" type="hidden" id="original_publish" value="Publish">
		<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Update"></div>
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