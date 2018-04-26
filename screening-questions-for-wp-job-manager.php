<?php
/*
Plugin Name:  Screening Questions For WP Job Manager
Plugin URI: https://wpdrift.com/screening-questions-for-wp-job-manager/
Description: Screening Questions Add-on for WP Job Manager.
Version: 1.0.0
Author: WPdrift
Author URI: https://wpdrift.com
Requires at least: 4.4
Tested up to: 4.9.5
Text Domain: screening-questions-for-wp-job-manager
Domain Path: /languages/

Copyright: 2018 WPdrift
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

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Define constants
		define( 'SCREENING_QUESTIONS_VERSION', '1.0.0' );
		define( 'SCREENING_QUESTIONS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'SCREENING_QUESTIONS_PLUGIN_FILE',  __FILE__  );
		define( 'SCREENING_QUESTIONS_PLUGIN_URL', plugin_dir_url ( __FILE__ ) );

		// Include required files
		include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/core/wp-job-manager-screening-questions-functions.php' );
		include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/core/class-wp-job-manager-screening-questions-enqueue.php' );
		include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/class-wp-job-manager-screening-questions-post-job.php' );
		include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/class-wp-job-manager-screening-questions-ajax.php' );
		include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/class-wp-job-manager-screening-questions-apply-job.php' );

		if ( is_admin() ) {
			include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/admin/class-wp-job-manager-screening-questions-admin-menu.php' );
			include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/admin/class-wp-job-manager-screening-questions-list-table.php' );
			include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/admin/class-wp-job-manager-screening-questions-list-table-form-handler.php' );
			include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/admin/class-wp-job-manager-screening-question-application-metabox.php' );
			include_once( SCREENING_QUESTIONS_PLUGIN_DIR . 'includes/admin/class-wp-job-manager-screening-question-job-metabox.php' );
		}

		// Install db tables
		register_activation_hook( __FILE__, array( $this, 'install_db_tables' ) );

		// Actions
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		add_action( 'admin_notices', array( $this, 'dependency_check' ) );
	}

	/**
	 * Load textdomain for plugin.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain( 'screening-questions-for-wp-job-manager', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Install db tables.
	 */
	public function install_db_tables() {
		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$sql = array();

		$sql[] = "CREATE TABLE {$wpdb->prefix}sq_questions (
			ID bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			author_id int(20) NOT NULL,
			job_id int(20) NOT NULL,
			question_type varchar(100) DEFAULT 'suggested',
			question varchar(255)
		) {$charset_collate};";

		$sql[] = "CREATE TABLE {$wpdb->prefix}sq_answers (
			ID bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			user_id int(20) NOT NULL,
			application_id int(20) NOT NULL,
			question_id int(20) NOT NULL,
			answer text
		) {$charset_collate};";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		dbDelta( $sql );
	}

	/**
	 * Check plugin dependency.
	 */
	public function dependency_check() {
		$required_plugins = array();
		$required_job_manager_version = '1.22.0';
		$notice = '';

		if ( !is_plugin_active( 'wp-job-manager/wp-job-manager.php' ) ) {
			$required_plugins[] = '<a href="https://wordpress.org/plugins/wp-job-manager/" target="_blank">WP Job Manager</a>';
		}

		if ( !is_plugin_active( 'wp-job-manager-applications/wp-job-manager-applications.php' ) ) {
			$required_plugins[] = '<a href="https://wpjobmanager.com/add-ons/applications/" target="_blank">WP Job Manager - Applications</a>';
		}

		if ( $required_plugins ) {
			$notice = sprintf( esc_html__( 'Screening Questions For WP Job Manager requires you to install %s.', 'screening-questions-for-wp-job-manager' ), implode( ', ', $required_plugins ) );
		} elseif ( version_compare( JOB_MANAGER_VERSION, $required_job_manager_version, '<' ) ) {
			$notice = sprintf( esc_html__( 'Screening Questions For WP Job Manager requires WP Job Manager %s (you are using %s)', 'screening-questions-for-wp-job-manager' ), $required_job_manager_version, JOB_MANAGER_VERSION );
		}

		if ( ! $notice ) {
			return;
		}

		echo '<div class="error"><p>' . $notice . '</p></div>';
	}

}

$GLOBALS['job_manager_screening_questions'] = new WP_Job_Manager_Screening_Questions();
