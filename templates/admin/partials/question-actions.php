<?php
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'){
      global $wpdb;
      $table_name = $wpdb->prefix . 'sq_questions';
      $question_id = $_REQUEST['id'];
      if(current_user_can('administrator')){
         $deleted = $wpdb->delete($table_name,array('ID' => $question_id));
         if($deleted){
            $message = __('Item was successfully deleted', 'wpjbsq');
         }
         
         if (isset($message) && !empty($message)):
               echo '<div id="message" class="updated"><p>'.$message.'</p></div>';
         endif;
         
      }
}

if(isset($_POST['_wpnonce']) && $_POST['_wpnonce'] != ''){
   if(! wp_verify_nonce($_POST['_wpnonce'])){
      die('Invalid request');
   }
   
   if(isset($_POST['question_id']) && $_POST['question_id'] >= 1){
      global $wpdb;
      $table_name = $wpdb->prefix . 'sq_questions';
      $question = esc_attr($_POST['question_title']);
      $question_id = $_POST['question_id'];
      $result = $wpdb->update($table_name,[
         'question_type' => 'suggested',
         'question' => $question
      ], array('id' => $question_id));
      if ($result) {
         $message = __('Item was successfully updated', 'wpjbsq');
      } else {
         $notice = __('There was an error while updating item', 'wpjbsq');
      }
      
      if (isset($notice) && ! empty($notice)):
         echo '<div id="notice" class="error"><p>'.$notice.'</p></div>';
      endif;
      if (isset($message) && !empty($message)):
         echo '<div id="message" class="updated"><p>'.$message.'</p></div>';
      endif;
   }
   
   if(isset($_POST['question_id']) && $_POST['question_id'] == 0){
      global $wpdb;
      $table_name = $wpdb->prefix . 'sq_questions';
      $question = esc_attr($_POST['question_title']);
      $wpdb->insert($table_name,[
         'question_type' => 'suggested',
         'question' => $question
      ]);
      $q_id = $wpdb->insert_id;
      
      if ($q_id) {
         $message = __('Item was successfully created', 'wpjbsq');
      } else {
         $notice = __('There was an error while creating question', 'wpjbsq');
      }
      
      if (isset($notice) && ! empty($notice)):
         echo '<div id="notice" class="error"><p>'.$notice.'</p></div>';
      endif;
      if (isset($message) && !empty($message)):
         echo '<div id="message" class="updated"><p>'.$message.'</p></div>';
      endif;
   }
}