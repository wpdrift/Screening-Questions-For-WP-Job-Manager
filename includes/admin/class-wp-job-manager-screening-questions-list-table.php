<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists ( 'WP_List_Table' ) ) {
    require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

/**
 * List table class
 */
class WP_Job_Manager_Screening_Questions_List_Table extends \WP_List_Table {

    function __construct() {
        parent::__construct( array(
            'singular' => 'question',
            'plural'   => 'questions',
            'ajax'     => false,
        ) );
    }

    function get_table_classes() {
        return array( 'widefat', 'fixed', 'striped', $this->_args['plural'] );
    }

    /**
     * Message to show if no designation found
     *
     * @return void
     */
    function no_items() {
        _e( 'No screening questions found', 'screening-questions-for-wp-job-manager' );
    }

    /**
     * Default column values if no callback found
     *
     * @param  object  $item
     * @param  string  $column_name
     *
     * @return string
     */
    function column_default( $item, $column_name ) {

        switch ( $column_name ) {
            case 'question':
                return $item->question;

            case 'question_type':
                return ucfirst($item->question_type);

            default:
                return isset( $item->$column_name ) ? $item->$column_name : '';
        }
    }

    /**
     * Get the column names
     *
     * @return array
     */
    function get_columns() {
        $columns = array(
            'cb'            => '<input type="checkbox" />',
            'question'      => __( 'Question', 'screening-questions-for-wp-job-manager' ),
            'question_type' => __( 'Question Type', 'screening-questions-for-wp-job-manager' ),

        );

        return $columns;
    }

    /**
     * Render the designation name column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_question( $item ) {

        $delete_question_nonce = wp_create_nonce( 'delete_question_nonce' );

        $actions = array();
        $actions['edit']   = sprintf( '<a href="%s" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=wp-job-manager-screening-questions&action=edit&id=' . $item->ID ), $item->ID, __( 'Edit this item', 'screening-questions-for-wp-job-manager' ), __( 'Edit', 'screening-questions-for-wp-job-manager' ) );
        $actions['delete'] = sprintf( '<a href="%s" class="submitdelete" data-id="%d" title="%s">%s</a>', admin_url( 'admin.php?page=wp-job-manager-screening-questions&action=delete_question&id=' . $item->ID . '&_wpnonce=' . $delete_question_nonce ), $item->ID, __( 'Delete this item', 'screening-questions-for-wp-job-manager' ), __( 'Delete', 'screening-questions-for-wp-job-manager' ) );

        return sprintf( '<a href="%1$s"><strong>%2$s</strong></a> %3$s', admin_url( 'admin.php?page=wp-job-manager-screening-questions&action=view&id=' . $item->ID ), $item->question, $this->row_actions( $actions ) );
    }

    /**
     * Get sortable columns
     *
     * @return array
     */
    function get_sortable_columns() {
        $sortable_columns = array(
            'question'      => array( 'question', true ),
            'question_type' => array( 'question_type', true ),
        );

        return $sortable_columns;
    }

    /**
     * Set the bulk actions
     *
     * @return array
     */
    function get_bulk_actions() {
        $actions = array(
            'trash' => __( 'Move to Trash', 'screening-questions-for-wp-job-manager' ),
        );
        return $actions;
    }

    /**
     * Render the checkbox column
     *
     * @param  object  $item
     *
     * @return string
     */
    function column_cb( $item ) {
        return sprintf(
            '<input type="checkbox" name="question_id[]" value="%d" />', $item->ID
        );
    }

    /**
     * Prepare the class items
     *
     * @return void
     */
    function prepare_items() {

        $columns = $this->get_columns();
        $hidden = array( );
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = array( $columns, $hidden, $sortable );

        $per_page = wpjmsq_get_questions_per_page_in_list_table();
        $current_page = $this->get_pagenum();
        $offset = ( $current_page -1 ) * $per_page;
        $this->page_status = isset( $_GET['status'] ) ? sanitize_text_field( $_GET['status'] ) : '2';

        $args = array(
            'offset' => $offset,
            'number' => $per_page,
        );

        if ( isset( $_REQUEST['orderby'] ) && isset( $_REQUEST['order'] ) ) {
            $args['orderby'] = sanitize_text_field( $_REQUEST['orderby'] );
            $args['order'] = sanitize_text_field( $_REQUEST['order'] );
        }

        if ( isset( $_REQUEST['s'] ) ) {
            $args['s'] = sanitize_text_field( $_REQUEST['s'] );
        }

        $this->items = wpjmsq_get_all_question( $args );

        $this->set_pagination_args( array(
            'total_items' => wpjmsq_get_question_count( $args ),
            'per_page'    => $per_page,
        ) );
    }
}
