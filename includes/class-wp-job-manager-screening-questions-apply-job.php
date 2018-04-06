<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Apply_Job class.
 */
class WP_Job_Manager_Screening_Questions_Apply_Job {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'job_application_form_fields_end', array( $this, 'add_screening_questions' ) );
        add_action( 'new_job_application', array( $this, 'add_answers_to_application' ) );
        add_filter( 'job_application_content', array( $this, 'single_application_screening_answers' ), 10, 2 );
    }

    /**
     * Adds screening questions.
     */
    public function add_screening_questions() {
        load_wpjmsq_view( 'job-apply' );
    }

    /**
     * Adds question answers to application.
     *
     * @param      int   $application_id  The application identifier
     */
    public function add_answers_to_application( $application_id ) {
        if ( isset( $_POST['answer'] ) ) {
            foreach ($_POST['answer'] as $question_id => $answer) {
                $answer = sanitize_text_field( $answer );
                wpjmsq_insert_answer( get_current_user_id(), $application_id, $question_id, $answer );
            }
        }
    }

    /**
     * Loads single application screening answers.
     *
     * @param      string  $application      The application
     * @param      object  $application_obj  The application object
     *
     * @return     string
     */
    public function single_application_screening_answers( $application, $application_obj ) {
        $application_id = $application_obj->ID;
        $job_id = wp_get_post_parent_id( $application_id );
        $questions = wpjmsq_get_job_linked_questions( $job_id );

        $application_content = '<div class="application-cover-message">';
            $application_content .= $application;
        $application_content .= '</div>';
        $application_content .= '<br />';

        if ( $questions ) {
            foreach ( $questions as $question_id ) {
                $question_data = wpjmsq_get_question( $question_id );

                if ( $question_data ) {
                    $answer_data = wpjmsq_get_applicant_answer( $question_id, $application_id );

                    $application_content .= '<div class="screening-question">';
                        $application_content .= '<p>';
                            $application_content .= '<strong>';
                                $application_content .= esc_html( $question_data['question'] );
                            $application_content .= '</strong>';

                            if ( $answer_data ) {
                                $application_content .= '<br />';
                                $application_content .= esc_html( $answer_data['answer'] );
                            }
                        $application_content .= '</p>';
                    $application_content .= '</div>';
                    $application_content .= '<br />';
                }
            }
        }

        return $application_content;
    }

}

new WP_Job_Manager_Screening_Questions_Apply_Job();
