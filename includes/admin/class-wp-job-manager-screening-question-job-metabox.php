<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    
    class WP_Job_Manager_Screening_Questions_Job_Metabox {
    
        /**
         * Constructor
         */
        public function __construct() {
         add_action('add_meta_boxes',function(){
             $screen = get_current_screen();
		     //if( 'add' != $screen->action ){
                 add_meta_box(
                    'wpjmsq-job-questions',
                    __( 'Screening Question', 'wpjmsq' ),
                    array($this,'add_questions_to_job'),
                    'job_listing',
                    'normal',
                    'default'
                );
           // }
         });
            
            
            
        add_action(
            'save_post',
            array($this,'save_job_questions')
            , 10, 3
        );    
        
        }

        function add_questions_to_job(){
            load_wpjmsq_view('admin/job-questions');
        }
        
        function save_job_questions($job_id){
            
            $post_type = get_post_type($job_id);
            if('job_listing' == $post_type):
            $all_questions = [];
            global $wpdb;
            $table_name = $wpdb->prefix . 'sq_questions';
             if(isset($_POST['new_question'])){
                 for($i=0;$i<count($_POST['new_question']);$i++){
                     
                  $question = esc_attr($_POST['new_question'][$i]);
                  $wpdb->insert($table_name,[
                     'author_id' => get_current_user_id(),
                     'question_type' => 'user added',
                     'job_id' => $job_id,
                     'question' => $question
                  ]);
                     $all_questions[] = $wpdb->insert_id;
                 }
             }
            
            if(isset($_POST['suggested_question'])){
                 foreach($_POST['suggested_question'] as $key => $value){
                     $all_questions[] = $key;
                 }
            }
            
            
            
            if(count($all_questions)){
                update_post_meta(
                    $job_id,
                    'wpjmsq_screening_questions',
                    $all_questions
                );
            }
            endif;
            
        }
    
        
    }
    
    new WP_Job_Manager_Screening_Questions_Job_Metabox();