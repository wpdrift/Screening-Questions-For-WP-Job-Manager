<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Enqueue class.
 */
class WP_Job_Manager_Screening_Questions_Enqueue {

	/**
	 * Constructor.
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue styles.
	 */
	public function enqueue_styles() {
		wp_enqueue_style( 'wp-job-manager-screening-questions', SCREENING_QUESTIONS_PLUGIN_URL . 'assets/css/wp-job-manager-screening-questions.css' );
    }

    /**
     * Enqueue scripts.
     */
    public function enqueue_scripts() {
		wp_enqueue_script( 'wp-job-manager-screening-questions', SCREENING_QUESTIONS_PLUGIN_URL . 'assets/js/wp-job-manager-screening-questions.js', array( 'jquery' ), SCREENING_QUESTIONS_VERSION, true );
		wp_localize_script( 'wp-job-manager-screening-questions', 'wpjmsq_vars', array(
			'loading_text' => esc_html__( 'Loading...', 'screening-questions-for-wp-job-manager' ),
		) );
    }

}

new WP_Job_Manager_Screening_Questions_Enqueue();
