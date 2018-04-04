<?php
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    
    
    class WP_Job_Manager_Screening_Questions_Apply_Job {
    
        /**
         * Constructor
         */
        public function __construct() {
            add_action('job_application_form_fields_end',array($this,'add_screening_questions'));
            add_action('new_job_application',array($this,'add_answers_to_application'));
            
            add_filter( 'job_application_content', array( $this, 'single_application_screening_answers' ), 10, 3);
        }


        function add_screening_questions(){
            load_wpjmsq_view('job-apply');
        }
        
        
        function add_answers_to_application($application_id){
            
            if(isset($_POST['answer'])){
                global $wpdb;
                $table_name = $wpdb->prefix . 'sq_answers';
                
                foreach($_POST['answer'] as $key => $value){
                    $answer = esc_attr($value);
                    $wpdb->insert($table_name,[
                     'user_id' => get_current_user_id(),
                     'application_id' => $application_id,
                     'question_id' => $key,
                     'answer' => $answer
                    ]);
                }
            }
        }
        
        
        
        
        function single_application_screening_answers($application,$application_obj){
                global $post,$wpdb;
           
                $questions_tbl = $wpdb->prefix . 'sq_questions';
                $answers_tbl = $wpdb->prefix . 'sq_answers';
                $application_id = $application_obj->ID;
                $job_id = wp_get_post_parent_id($application_id);
                $questions = get_post_meta($job_id,'wpjmsq_screening_questions',true);

                $application_content = '<div class="application-cover-message">';
                $application_content .= $application;
                $application_content .= '</div><br/>';


                if($questions):
                    for($i=0;$i<count($questions);$i++):
                    $question_id = $questions[$i];
                    $question_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $questions_tbl WHERE id = %d", $question_id), ARRAY_A);
                        if($question_data):
                        $answer_data = $wpdb->get_row($wpdb->prepare("SELECT * FROM $answers_tbl WHERE question_id = %d AND application_id = %d", $question_id,$application_id), ARRAY_A);

                        $application_content .= '<div>
                            <p><strong>'.$question_data['question'].'</strong><br/>';
                            if($answer_data):
                            $application_content .=$answer_data['answer'];
                            endif;
                        $application_content .= '</p></div><br/>';
                        endif;
                    endfor;
                endif; 
            
                return $application_content;
           
        }
    
        
    }
    
    new WP_Job_Manager_Screening_Questions_Apply_Job();