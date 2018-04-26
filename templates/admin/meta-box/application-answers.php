<?php
$application_id = get_the_ID();
$job_id = wp_get_post_parent_id( $application_id );
$questions = wpjmsq_get_job_linked_questions( $job_id );

if ( $questions ) {
	foreach ( $questions as $question_id ) {
		$question_data = wpjmsq_get_question( $question_id );

		if ( $question_data ) {
			$answer_data = wpjmsq_get_applicant_answer( $question_id, $application_id );
			?>

			<div style="margin: 10px 0 0; background-color: #f9f9f9; border: 1px solid #ddd; padding: 8px;">
			    <p style="margin: 0 0 10px;"><strong><?php echo esc_html( $question_data['question'] ); ?></strong></p>

			    <?php if ( $answer_data ): ?>
					<p style="margin: 0; color: #666; font-style: italic; font-size: 11px;"><?php echo esc_html( $answer_data['answer'] ); ?></p>
			    <?php endif ?>
			</div>

			<?php
		}
	}
}
