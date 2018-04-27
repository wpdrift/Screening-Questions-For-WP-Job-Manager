<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Ajax class.
 */
class WP_Job_Manager_Screening_Questions_Ajax {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'wp_ajax_nopriv_wpjmsq_get_suggested_questions_html', array( $this, 'get_questions' ) );
		add_action( 'wp_ajax_wpjmsq_get_suggested_questions_html', array( $this, 'get_questions' ) );
		add_action( 'wp_ajax_nopriv_wpjmsq_get_add_question_form', array( $this, 'get_add_question_form' ) );
		add_action( 'wp_ajax_wpjmsq_get_add_question_form', array( $this, 'get_add_question_form' ) );
	}

	/**
	 * Gets the questions.
	 */
	public function get_questions() {
		$suggested_questions = wpjmsq_get_suggested_questions();

		if ( $suggested_questions ) {
			?>

			<div class="wpjmsq-modal-heading">
				<h3><?php echo esc_html__( 'Select Questions', 'screening-questions-for-wp-job-manager' ); ?></h3>
			</div>

			<div class="wpjmsq-modal-body">
				<div class="form">
					<ul>
						<?php foreach ( $suggested_questions as $question ): ?>
							<li>
								<label>
									<input type="checkbox" name="suggested_question[]" value="<?php echo $question->ID; ?>" data-question="<?php echo esc_attr( $question->question ); ?>">
									<?php echo esc_html( $question->question ); ?>
								</label>
							</li>
						<?php endforeach ?>
					</ul>

					<button type="button" class="button choose-suggested-questions">
						<?php echo esc_html__( 'Choose', 'screening-questions-for-wp-job-manager' ); ?>
					</button>
				</div>
			</div>

			<?php
		} else {
			?>

			<div class="wpjmsq-modal-heading">
				<p><?php echo esc_html__( 'There are no suggested questions.', 'screening-questions-for-wp-job-manager' ); ?></p>
			</div>

			<?php
		}

		wp_die();
	}

	/**
	 * Gets the add question form.
	 */
	public function get_add_question_form() {
		?>

		<div class="wpjmsq-modal-heading">
			<h3><?php echo esc_html__( 'Add New Question', 'screening-questions-for-wp-job-manager' ); ?></h3>
		</div>

		<div class="wpjmsq-modal-body">
			<p>
				<textarea name="new_question" rows="4" placeholder="<?php echo esc_attr__( 'Type your question here..', 'screening-questions-for-wp-job-manager' ); ?>"></textarea>
			</p>

			<button type="button" class="button create_question_btn">
				<?php echo esc_html__( 'Add Question', 'screening-questions-for-wp-job-manager' ); ?>
			</button>
		</div>

		<?php
		wp_die();
	}

}

new WP_Job_Manager_Screening_Questions_Ajax();
