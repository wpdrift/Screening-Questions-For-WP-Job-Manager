<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Application_Metabox class.
 */
class WP_Job_Manager_Screening_Questions_Application_Metabox {

    /**
     * Constructor.
     */
    public function __construct() {
        add_action( 'add_meta_boxes', function() {
            $screen = get_current_screen();

            if ( 'add' != $screen->action ) {
                add_meta_box(
                    'wpjmsq-application-answers',
                    __( 'Answers', 'screening-questions-for-wp-job-manager' ),
                    array( $this, 'add_answers_to_application' ),
                    'job_application',
                    'normal',
                    'default'
                );
            }
        } );
    }

    /**
     * Loads view.
     */
    public function add_answers_to_application() {
        load_wpjmsq_view( 'admin/application-answers' );
    }

}

new WP_Job_Manager_Screening_Questions_Application_Metabox();
