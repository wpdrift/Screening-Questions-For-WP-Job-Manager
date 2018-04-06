<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html__( 'Add New Question', 'screening-questions-for-wp-job-manager' ); ?></h1>

	<hr class="wp-header-end">

	<form name="post" method="post" id="screening-question">
		<?php wp_nonce_field(); ?>

		<input type="hidden" name="question_id" value="0">

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content">

					<div id="titlediv">
						<div id="titlewrap">
							<input type="text" name="question_title" size="30" id="title" spellcheck="true" autocomplete="off" placeholder="<?php echo esc_html__( 'Enter question here', 'screening-questions-for-wp-job-manager' ); ?>" required>
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
										<div id="publishing-action">
											<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="<?php echo esc_attr__( 'Publish', 'screening-questions-for-wp-job-manager' ); ?>">
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
