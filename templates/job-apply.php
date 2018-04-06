<?php

do_action( 'wpjmsq_before_screening_questions' );

$questions = wpjmsq_get_job_linked_questions( get_the_ID() );

if ( $questions ) {
	foreach ( $questions as $question_id ) {
		$item = wpjmsq_get_question( $question_id );

		if ( $item ) {
			?>

			<fieldset>
			    <label><?php echo esc_html( $item['question'] ); ?></label>

			    <div class="field required-field">
			        <textarea cols="20" rows="3" class="<?php echo apply_filters( 'wpjmsq_answer_field_class', 'input-text' ); ?>" name="answer[<?php echo $question_id; ?>]" placeholder="<?php echo esc_attr__( 'Answer goes here', 'screening-questions-for-wp-job-manager' ); ?>" required></textarea>
			    </div>
			</fieldset>

			<?php
		}
	}
}

do_action( 'wpjmsq_after_screening_questions' );
