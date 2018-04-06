<?php
$id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;
$item = wpjmsq_get_question( $id );
$item_id = isset( $item['ID'] ) ? $item['ID'] : 0;

if ( !$id || !$item_id ) {
	printf( '<div class="error"><p>' . esc_html__( 'Question not found!', 'screening-questions-for-wp-job-manager' ) . '</p></div>' );
}
?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html__( 'Edit Question', 'screening-questions-for-wp-job-manager' ); ?></h1>

	<hr class="wp-header-end">

	<form name="post" method="post" id="screening-question">
		<?php wp_nonce_field(); ?>

		<input type="hidden" name="question_id" value="<?php echo $item_id; ?>">

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">

					<div id="titlediv">
						<div id="titlewrap">
							<input type="text" name="question_title" size="30" id="title" spellcheck="true" autocomplete="off" placeholder="<?php echo esc_html__( 'Enter question here', 'screening-questions-for-wp-job-manager' ); ?>" value="<?php echo isset( $item['question'] ) ? esc_attr__( $item['question'] ) : ''; ?>" required>
						</div>
					</div><!-- /titlediv -->

				</div><!-- /post-body-content -->

				<div id="postbox-container-1" class="postbox-container">

					<div id="side-sortables" class="meta-box-sortables">

						<div id="submitdiv" class="postbox">
							<h2><span><?php echo esc_html__( 'Publish', 'screening-questions-for-wp-job-manager' ); ?></span></h2>

							<div class="inside">
								<div class="submitbox" id="submitpost">
									<div id="major-publishing-actions">
										<div id="delete-action">
											<a class="submitdelete deletion" href="<?php echo admin_url( 'admin.php?page=wp-job-manager-screening-questions&action=delete&id=' . $item_id ); ?>"><?php echo esc_html__( 'Delete', 'screening-questions-for-wp-job-manager' ); ?></a>
										</div>
										<div id="publishing-action">
											<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php echo esc_attr__( 'Update', 'screening-questions-for-wp-job-manager' ); ?>">
										</div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div><!-- /post-body -->
			<br class="clear">
		</div><!-- /poststuff -->
	</form>
</div>
