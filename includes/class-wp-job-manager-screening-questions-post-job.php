<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Post_Job class.
 */
class WP_Job_Manager_Screening_Questions_Post_Job {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'submit_job_form_job_fields_end', array( $this, 'add_post_job_view' ) );
        add_action( 'job_manager_update_job_data', array( $this, 'save_screening_questions' ), 100, 2 );
    }

    /**
     * Adds a post job view.
     */
    public function add_post_job_view() {
        load_wpjmsq_view( 'post-job' );
    }

    /**
     * Saves screening questions.
     *
     * @param      int    $job_id  The job identifier
     * @param      array  $values  The values
     */
    public function save_screening_questions( $job_id, $values ) {
        $all_questions = array();

        if ( isset( $_POST['new_question'] ) ) {
            foreach ( $_POST['new_question'] as $question ) {
                $question = sanitize_text_field( $question );
                $all_questions[] = wpjmsq_insert_question( get_current_user_id(), $job_id, $question );
            }
        }

        if ( isset( $_POST['suggested_question'] ) ) {
            foreach ( $_POST['suggested_question'] as $key => $value ) {
                $all_questions[] = $key;
            }
        }

        if ( count( $all_questions ) ) {
            update_post_meta( $job_id, 'wpjmsq_screening_questions', $all_questions );
        }
    }

}

new WP_Job_Manager_Screening_Questions_Post_Job();
