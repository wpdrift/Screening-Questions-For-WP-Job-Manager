<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Handle the form submissions
 *
 * @package Package
 * @subpackage Sub Package
 */
class WP_Job_Manager_Screening_Questions_List_Table_Form_Handler {

    /**
     * Hook 'em all
     */
    public function __construct() {
        add_action( 'admin_init', array( $this, 'add_or_update_question' ) );
        add_action( 'admin_init', array( $this, 'delete_question' ) );
        add_action( 'admin_init', array( $this, 'process_bulk_action' ) );
    }

    /**
     * Handle the question new and edit form
     *
     * @return     void
     */
    public function add_or_update_question() {
        if ( ! isset( $_POST['submit_screening_question'] ) ) {
            return;
        }

        if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'question-new' ) ) {
            wp_die( __( 'Are you cheating?', 'screening-questions-for-wp-job-manager' ) );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Permission Denied!', 'screening-questions-for-wp-job-manager' ) );
        }

        $errors = array();
        $page_url = admin_url( 'admin.php?page=wp-job-manager-screening-questions' );
        $field_id = isset( $_POST['field_id'] ) ? intval( $_POST['field_id'] ) : 0;

        $question = isset( $_POST['question'] ) ? sanitize_text_field( $_POST['question'] ) : '';

        // some basic validation
        if ( ! $question ) {
            $errors[] = __( 'Error: Question is required', 'screening-questions-for-wp-job-manager' );
        }

        // bail out if error found
        if ( $errors ) {
            $first_error = reset( $errors );
            $redirect_to = add_query_arg( array( 'error' => urlencode($first_error) ), $page_url );
            wp_safe_redirect( $redirect_to );
            exit;
        }

        $fields = array(
            'question' => $question,
        );

        // New or edit?
        if ( ! $field_id ) {

            $fields['author_id'] = get_current_user_id();

            $insert_id = wpjmsq_list_table_insert_question( $fields );

        } else {

            $fields['ID'] = $field_id;

            $insert_id = wpjmsq_list_table_insert_question( $fields );
        }

        if ( is_wp_error( $insert_id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'error' ), $page_url );
        } else {
            if ( ! $field_id ) {
                $redirect_to = add_query_arg( array( 'message' => 'new-question-success' ), $page_url );
            } else {
                $redirect_to = add_query_arg( array( 'message' => 'edit-question-success' ), $page_url );
            }
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }

    /**
     * Delete question.
     */
    public function delete_question() {
        $action = isset( $_GET['action'] ) ? $_GET['action'] : '';

        if ( $action !== 'delete_question' ) {
            return;
        }

        if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'delete_question_nonce' ) ) {
            wp_die( __( 'Are you cheating?', 'screening-questions-for-wp-job-manager' ) );
        }

        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( __( 'Permission Denied!', 'screening-questions-for-wp-job-manager' ) );
        }

        $errors = array();
        $page_url = admin_url( 'admin.php?page=wp-job-manager-screening-questions' );
        $id = isset( $_GET['id'] ) ? intval( $_GET['id'] ) : 0;

        if ( ! $id ) {
            wp_die( __( 'Question ID is required!', 'screening-questions-for-wp-job-manager' ) );
        }

        if ( wpjmsq_delete_question( $id ) ) {
            $redirect_to = add_query_arg( array( 'message' => 'question-delete-success' ), $page_url );
        } else {
            $redirect_to = add_query_arg( array( 'message' => 'question-delete-error' ), $page_url );
        }

        wp_safe_redirect( $redirect_to );
        exit;
    }

    /**
     * Process bulk actions.
     */
    public function process_bulk_action() {
        if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'trash' && isset( $_REQUEST['page'] ) && $_REQUEST['page'] === 'wp-job-manager-screening-questions' ) {

            if ( ! wp_verify_nonce( $_POST['_wpnonce'], 'bulk-questions' ) ) {
                wp_die( __( 'Are you cheating?', 'screening-questions-for-wp-job-manager' ) );
            }

            if ( ! current_user_can( 'manage_options' ) ) {
                wp_die( __( 'Permission Denied!', 'screening-questions-for-wp-job-manager' ) );
            }

            $page_url = admin_url( 'admin.php?page=wp-job-manager-screening-questions' );
            $delete_ids = $_POST['question_id'];

            if ( count( $delete_ids ) ) {
                foreach ( $delete_ids as $id ) {
                    wpjmsq_delete_question( $id );
                }
            }

            if ( count( $delete_ids ) > 1 ) {
                $redirect_to = add_query_arg( array( 'message' => 'questions-delete-success' ), $page_url );
            } elseif ( count( $delete_ids ) === 1 ) {
                $redirect_to = add_query_arg( array( 'message' => 'question-delete-success' ), $page_url );
            }

            wp_safe_redirect( $redirect_to );
            exit;
        }

        return;
    }
}

new WP_Job_Manager_Screening_Questions_List_Table_Form_Handler();
