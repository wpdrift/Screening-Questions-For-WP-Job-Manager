<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    
    class WP_Job_Manager_Screening_Questions_Application_Metabox {
    
        /**
         * Constructor
         */
        public function __construct() {
         add_action('add_meta_boxes',function(){
             $screen = get_current_screen();
		     if( 'add' != $screen->action ){
                 add_meta_box(
                    'wpjmsq-application-answers',
                    __( 'Answers', 'wpjmsq' ),
                    array($this,'add_answers_to_application'),
                    'job_application',
                    'normal',
                    'default'
                );
            }
         });
        }

        function add_answers_to_application(){
            load_wpjmsq_view('admin/application-answers');
        }
    
        
    }
    
    new WP_Job_Manager_Screening_Questions_Application_Metabox();