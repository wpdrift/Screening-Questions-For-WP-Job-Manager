<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class WP_Job_Manager_Screening_Questions_Enqueue {

	/**
	 * Constructor
	 */
	public function __construct() {
        add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_styles' ) );
        add_action( 'wp_enqueue_scripts', 	array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue styles
	 */
	public function enqueue_styles() {
		wp_enqueue_style('wp-job-manager-screening-questions',SCREENING_QUESTIONS_PLUGIN_URL.'/assets/css/wp-job-manager-screening-questions.css');
    }
    
    /**
    * Enqueue scripts
    */

    public function enqueue_scripts(){
      wp_enqueue_script('jquery');
      wp_enqueue_script('wp-job-manager-screening-questions',SCREENING_QUESTIONS_PLUGIN_URL.'/assets/js/wp-job-manager-screening-questions.js',array('jquery'),'1.0',true);
    }

}

new WP_Job_Manager_Screening_Questions_Enqueue();