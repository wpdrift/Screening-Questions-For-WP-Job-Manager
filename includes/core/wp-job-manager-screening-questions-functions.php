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
 * Count total questions.
 */
function wpjmsq_count_questions() {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_questions';
	$total_records = $wpdb->get_results( "SELECT COUNT(ID) as count FROM {$table_name}" );
	return $total_records;
}

/**
 * Get paginated questions.
 *
 * @param      int     $start_from  The start from
 * @param      int     $per_page    The per page
 *
 * @return     object
 */
function wpjmsq_get_paginated_questions( $start_from, $per_page ) {
	global $wpdb;
	$table_name = $wpdb->prefix . 'sq_questions';
	$results = $wpdb->get_results( "SELECT * FROM {$table_name} ORDER BY `ID` DESC LIMIT $start_from, $per_page" );
	return $results;
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
