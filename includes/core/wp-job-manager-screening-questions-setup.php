<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function wp_job_manager_screening_questions_create_custom_tables() {
 	global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $sql =[];
    $sql[]="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."sq_questions`
          (
          ID bigint(20) NOT NULL auto_increment,
          author_id int(20) default 0,
          job_id int(20) default 0,
          question_type varchar(100) default 'suggested',
          question varchar(255),
          PRIMARY KEY  (`ID`)
          ) $charset_collate;";
  
    $sql[]="CREATE TABLE IF NOT EXISTS `".$wpdb->prefix."sq_answers`
          (
          ID bigint(20) NOT NULL auto_increment,
          user_id int(20) default 0,
          application_id int(20) default 0,
          question_id int(20) default 0,
          answer text,
          PRIMARY KEY  (`ID`)
          ) $charset_collate;";

       
  for($i=0;$i<count($sql);$i++){
    dbDelta($sql[$i]);
  }

}
// run the install scripts upon plugin activation



function wp_job_manager_screening_questions_delete_custom_tables(){
          /*global $wpdb;
         $wpdb->query( "DROP TABLE IF EXISTS `".$wpdb->prefix."sq_questions`" );
         $wpdb->query( "DROP TABLE IF EXISTS `".$wpdb->prefix."sq_answers`" );*/
}

/*
function tiny_shout_redirect_after_activation() {
  if (get_option('tiny_shout_do_activation_redirect', false)) {
    delete_option('tiny_shout_do_activation_redirect');
    exit( wp_redirect("admin.php?page=tiny_shout_settings") );
 }
  
}

function tiny_shout_add_redirect_option() {
  add_option('tiny_shout_do_activation_redirect', true);
}*/