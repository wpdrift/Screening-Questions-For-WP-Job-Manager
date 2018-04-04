<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class WP_Job_Manager_Screening_Questions_Admin_Pages {

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', 	array( $this, 'add_menu_link' ) );
	}
	
	
	function add_menu_link(){
		
			add_menu_page(
				__('Screening Questions','wpjmsq'),
				__('Screening Questions','wpjmsq'),
				'manage_options',
				'wp-job-manager-screening-questions',
				array($this,'load_screening_question_admin_view')
			);
		
			add_submenu_page(
				'wp-job-manager-screening-questions',
				__('Settings','wpjmsq'),
				__('Settings','wpjmsq'),
				'manage_options',
				'wp-job-manager-screening-questions-settings',
				array($this,'load_screening_question_admin__settings_view')
			);
	}
	
	function load_screening_question_admin_view(){
		load_wpjmsq_view('admin/partials/question-actions');
		if(isset($_GET['action']) && $_GET['action']=='add'):
			load_wpjmsq_view('admin/question-add');
		elseif(isset($_GET['action']) && $_GET['action']=='edit'):
			load_wpjmsq_view('admin/question-edit');
		else:
			load_wpjmsq_view('admin/index');
		endif;
	}
	
	
	function load_screening_question_admin__settings_view(){
		load_wpjmsq_view('admin/settings');
	}

	
}

new WP_Job_Manager_Screening_Questions_Admin_Pages();