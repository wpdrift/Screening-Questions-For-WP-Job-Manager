<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function load_wpjmsq_view($file){
    require_once SCREENING_QUESTIONS_PLUGIN_DIR.'/templates/'.$file.'.php';
}


function plugin_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=plugin_name">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
add_filter( "plugin_action_links_".SCREENING_QUESTIONS_PLUGIN_FILE, 'plugin_add_settings_link' );