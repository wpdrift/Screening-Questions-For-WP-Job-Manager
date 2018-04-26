<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin Menu
 */
class WP_Job_Manager_Screening_Questions_Admin {

    /**
     * Kick-in the class
     */
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    /**
     * Add menu items
     *
     * @return void
     */
    public function admin_menu() {

        /** Top Menu **/
        add_menu_page( __( 'Screening Questions', 'screening-questions-for-wp-job-manager' ), __( 'Screening Questions', 'screening-questions-for-wp-job-manager' ), 'manage_options', 'wp-job-manager-screening-questions', array( $this, 'plugin_page' ) );

        add_submenu_page( 'wp-job-manager-screening-questions', __( 'Screening Questions', 'screening-questions-for-wp-job-manager' ), __( 'Screening Questions', 'screening-questions-for-wp-job-manager' ), 'manage_options', 'wp-job-manager-screening-questions', array( $this, 'plugin_page' ) );
    }

    /**
     * Handles the plugin page
     *
     * @return void
     */
    public function plugin_page() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : 'list';
        $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        switch ($action) {
            case 'view':

                $template = SCREENING_QUESTIONS_PLUGIN_DIR . '/templates/admin/list-table/screening-questions-single.php';
                break;

            case 'edit':
                $template = SCREENING_QUESTIONS_PLUGIN_DIR . '/templates/admin/list-table/screening-questions-edit.php';
                break;

            case 'new':
                $template = SCREENING_QUESTIONS_PLUGIN_DIR . '/templates/admin/list-table/screening-questions-new.php';
                break;

            default:
                $template = SCREENING_QUESTIONS_PLUGIN_DIR . '/templates/admin/list-table/screening-questions-list.php';
                break;
        }

        if ( file_exists( $template ) ) {
            include $template;
        }
    }
}

new WP_Job_Manager_Screening_Questions_Admin();
