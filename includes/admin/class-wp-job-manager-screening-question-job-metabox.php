<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Job_Metabox class.
 */
class WP_Job_Manager_Screening_Questions_Job_Metabox {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', function() {
            add_meta_box(
                'wpjmsq-job-questions',
                __( 'Screening Questions', 'screening-questions-for-wp-job-manager' ),
                array( $this, 'add_questions_to_job' ),
                'job_listing',
                'normal',
                'default'
            );
        } );

        add_action( 'save_post', array( $this, 'save_job_questions' ) );
    }

    /**
     * Loads view.
     */
    public function add_questions_to_job() {
        load_wpjmsq_view( 'admin/meta-box/job-questions' );
    }

    /**
     * Saves job questions.
     *
     * @param      int   $job_id  The job identifier
     */
    public function save_job_questions( $job_id ) {
        $post_type = get_post_type( $job_id );

        if ( 'job_listing' === $post_type ) {
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

}

new WP_Job_Manager_Screening_Questions_Job_Metabox();
