<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads a view.
 *
 * @param      string  $file   The file
 */
function load_wpjmsq_view( $file ) {
    require_once SCREENING_QUESTIONS_PLUGIN_DIR . 'templates/' . $file . '.php';
}

/**
 * Get question.
 *
 * @param      int    $id     The identifier
 *
 * @return     array
 */
function wpjmsq_get_question( $id ) {
	if ( !$id ) {
		return array();
	}

	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_questions';
	$item = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE ID = %d", $id ), ARRAY_A );

	return $item;
}

/**
 * Delete question.
 *
 * @param      int        $id     The identifier
 *
 * @return     int|false
 */
function wpjmsq_delete_question( $id ) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'sq_questions';

    return $wpdb->delete( $table_name, array( 'ID' => $id ) );
}

/**
 * Get questions those are linked with the job.
 *
 * @param      int    $job_id  The job identifier
 *
 * @return     array
 */
function wpjmsq_get_job_linked_questions( $job_id ) {
	return get_post_meta( $job_id, 'wpjmsq_screening_questions', true );
}

/**
 * Get questions those are suggested or created for this job.
 *
 * @param      int     $job_id  The job identifier
 *
 * @return     object
 */
function wpjmsq_get_job_questions( $job_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_questions';
	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE question_type = 'suggested' OR job_id = $job_id ORDER BY `ID` DESC" );
	return $results;
}

/**
 * Get only suggested questions.
 *
 * @return     object
 */
function wpjmsq_get_suggested_questions() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_questions';
	$results = $wpdb->get_results( "SELECT * FROM $table_name WHERE question_type = 'suggested' ORDER BY `ID` DESC" );
	return $results;
}

/**
 * Get applicant answer for question.
 *
 * @param      int    $question_id     The question identifier
 * @param      int    $application_id  The application identifier
 *
 * @return     array
 */
function wpjmsq_get_applicant_answer( $question_id, $application_id ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_answers';

	return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table_name WHERE question_id = %d AND application_id = %d", $question_id, $application_id ), ARRAY_A );
}

/**
 * Insert question into database.
 *
 * @param      int     $author_id  The author identifier
 * @param      int     $job_id     The job identifier
 * @param      string  $question   The question
 *
 * @return     int
 */
function wpjmsq_insert_question( $author_id, $job_id, $question ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_questions';

	$wpdb->insert( $table_name, array(
		'author_id'     => $author_id,
		'question_type' => 'user added',
		'job_id'        => $job_id,
		'question'      => $question,
	) );

	return $wpdb->insert_id;
}

/**
 * Insert answer to database.
 *
 * @param      int     $user_id         The user identifier
 * @param      int     $application_id  The application identifier
 * @param      int     $question_id     The question identifier
 * @param      string  $answer          The answer
 *
 * @return     object
 */
function wpjmsq_insert_answer( $user_id, $application_id, $question_id, $answer ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_answers';

	return $wpdb->insert( $table_name, array(
		'user_id'        => $user_id,
		'application_id' => $application_id,
		'question_id'    => $question_id,
		'answer'         => $answer,
	) );
}

/**
 * Gets the number of questions to show in the list table.
 *
 * @return     int
 */
function wpjmsq_get_questions_per_page_in_list_table() {
    $questions_per_page = intval( apply_filters( 'screening_questions_per_page_in_list_table', 20 ) );
    return $questions_per_page ? $questions_per_page : 20;
}

/**
 * Get all question
 *
 * @param      array  $args   The arguments
 *
 * @return     array
 */
function wpjmsq_get_all_question( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'number'  => wpjmsq_get_questions_per_page_in_list_table(),
        'offset'  => 0,
        'orderby' => 'ID',
        'order'   => 'DESC',
    );

    $args = wp_parse_args( $args, $defaults );

	$query = "SELECT * FROM {$wpdb->prefix}sq_questions";

	if ( isset( $args['s'] ) && ! empty( $args['s'] ) ) {
		$query .= " WHERE question LIKE '%{$args['s']}%'";
	}

	$query .= " ORDER BY {$args['orderby']} {$args['order']} LIMIT {$args['offset']}, {$args['number']}";

    $items = $wpdb->get_results( $query );

    return $items;
}

/**
 * Fetch all question from database
 *
 * @param      array  $args   The arguments
 *
 * @return     array
 */
function wpjmsq_get_question_count( $args = array() ) {
    global $wpdb;

    $query = "SELECT COUNT(*) FROM {$wpdb->prefix}sq_questions";

    if ( isset( $args['s'] ) && ! empty( $args['s'] ) ) {
    	$query .= " WHERE question LIKE '%{$args['s']}%'";
    }

    return (int) $wpdb->get_var( $query );
}

/**
 * Fetch a single question from database
 *
 * @param      int    $id
 *
 * @return     array
 */
function wpjmsq_list_table_get_question( $id = 0 ) {
    global $wpdb;

    return $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'sq_questions WHERE ID = %d', $id ) );
}

/**
 * Insert a new question
 *
 * @param      array             $args
 *
 * @return     WP_Error|boolean
 */
function wpjmsq_list_table_insert_question( $args = array() ) {
    global $wpdb;

    $defaults = array(
        'ID'       => null,
        'question' => '',
    );

    $args = wp_parse_args( $args, $defaults );
    $table_name = $wpdb->prefix . 'sq_questions';

    // some basic validation
    if ( empty( $args['question'] ) ) {
        return new WP_Error( 'no-question', __( 'No Question provided.', 'screening-questions-for-wp-job-manager' ) );
    }

    // remove row id to determine if new or update
    $row_id = (int) $args['ID'];
    unset( $args['ID'] );

    if ( ! $row_id ) {

        // insert a new
        if ( $wpdb->insert( $table_name, $args ) ) {
            return $wpdb->insert_id;
        }

    } else {

        // do update method here
        if ( $wpdb->update( $table_name, $args, array( 'ID' => $row_id ) ) ) {
            return $row_id;
        }

    }

    return false;
}
