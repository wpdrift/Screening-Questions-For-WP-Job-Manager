<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Screening_Questions_Admin class.
 */
class WP_Job_Manager_Screening_Questions_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', 	array( $this, 'add_menu_page' ) );
	}

	/**
	 * Adds a menu page.
	 */
	public function add_menu_page() {
		add_menu_page( __('Screening Questions','wpjmsq'), __('Screening Questions','wpjmsq'), 'manage_options', 'wp-job-manager-screening-questions', array( $this, 'load_screening_question_admin_view' ) );
	}

	/**
	 * Loads screening question admin view.
	 */
	function load_screening_question_admin_view() {
		// Handle requests to create/delete questions
		load_wpjmsq_view( 'admin/partials/question-actions' );

		if ( isset( $_GET['action'] ) && $_GET['action'] === 'add' ) {
			load_wpjmsq_view( 'admin/question-add' );
		} elseif ( isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
			load_wpjmsq_view( 'admin/question-edit' );
		} else {
			load_wpjmsq_view( 'admin/index' );
		}
	}

}

new WP_Job_Manager_Screening_Questions_Admin();
