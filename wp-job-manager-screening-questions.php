<?php
/*
Plugin Name:  WP Job Manager – Screening Questions
Plugin URI: http://wpdrift.com/wp-job-manager-company-listings/
Description: Screening Questions Add-on for WPJM.
Version: 1.0.0
Author: WPDrift
Author URI: http://wpdrift.com
Requires at least: 4.1
Tested up to: 4.7

Copyright: 2017 WPDrift
License: GNU General Public License v3.0
License URI: http://www.gnu.org/licenses/gpl-3.0.html
*/


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP_Job_Manager_Screening_Questions class.
 */
class WP_Job_Manager_Screening_Questions {


	public function __construct() {
		// Define constants
		define( 'SCREENING_QUESTIONS_VERSION', '1.0.0' );
		define( 'SCREENING_QUESTIONS_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'SCREENING_QUESTIONS_PLUGIN_FILE',  __FILE__  );
		define( 'SCREENING_QUESTIONS_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );

		// Includes
		include( 'includes/core/wp-job-manager-screening-questions-setup.php');
		include( 'includes/core/wp-job-manager-screening-questions-functions.php');
		include( 'includes/core/class-wp-job-manager-screening-questions-enqueue.php');
		include('includes/class-wp-job-manager-screening-questions-post-job.php');
		include('includes/class-wp-job-manager-screening-questions-ajax.php');
		include('includes/class-wp-job-manager-screening-questions-apply-job.php');
		
		include( 'includes/admin/class-wp-job-manager-screening-questions-admin-menu.php');
		
		include( 'includes/admin/class-wp-job-manager-screening-question-application-metabox.php');
		
		include( 'includes/admin/class-wp-job-manager-screening-question-job-metabox.php');


		
		register_activation_hook(__FILE__,'wp_job_manager_screening_questions_create_custom_tables');
		register_deactivation_hook(__FILE__,'wp_job_manager_screening_questions_delete_custom_tables');
		
		add_action( 'admin_notices', array( $this, 'version_check' ) );
		add_action( 'admin_init', array( $this, 'updater' ) );
	}
	
	
	
	public function version_check() {
		$required_jm_version      = '1.22.0';
		if ( ! defined( 'SCREENING_QUESTIONS_VERSION' ) ) {
			?><div class="error"><p><?php _e( 'Screening questions requires WP Job Manager to be installed!', 'wp-job-manager-applications' ); ?></p></div><?php
		} elseif ( version_compare( JOB_MANAGER_VERSION, $required_jm_version, '<' ) ) {
			?><div class="error"><p><?php printf( __( 'Screening questions requires WP Job Manager %s (you are using %s)', 'wp-job-manager-applications' ), $required_jm_version, SCREENING_QUESTIONS_VERSION ); ?></p></div><?php
		}
	}
	
	
	
	/**
	 * Handle Updates
	 */
	public function updater() {
		if ( 
			version_compare( 
				JOB_MANAGER_VERSION, 
				get_option( 'wp_company_listings_version' ),
				'>') 
			) {
		//include_once('includes/class-wp-job-manager-company-listings-install.php' );
		}
	}
	
	
	


}

$GLOBALS['job_manager_screening_questions'] = new WP_Job_Manager_Screening_Questions();