<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    
    class WP_Job_Manager_Screening_Questions_Post_Job {
    
        /**
         * Constructor
         */
        public function __construct() {
            
            add_action(
                'submit_job_form_job_fields_end',
                array($this,'add_post_job_view')
            );
            
            add_action(
                'job_manager_update_job_data',
                array($this,'save_screening_questions'),
                100, 2 
            );
            
            /*add_action(
                'job_manager_update_job_data',
                array($this,'save_screening_questions')
            );*/
        }


        function add_post_job_view(){
            load_wpjmsq_view('post-job');
        }
        
        
        function save_screening_questions($job_id, $values){
           // print_r($job_id);
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
        }
    
        
    }
    
    new WP_Job_Manager_Screening_Questions_Post_Job();