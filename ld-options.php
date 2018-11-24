<?php 
/*
Plugin Name: Launch Date
Author: Baron Watts
Plugin URI: http://baronwatts.com
Description: Displays a countdown timer from a specified date
Author URI: http://baronwatts.com
Version: 0.1
*/


//Add a page to the admin. Run the ld_options_page function only on the admin page
add_action('admin_menu', 'ld_options_page' );
function ld_options_page(){
	add_options_page('Launch Date', 'Lauch Date', 'manage_options', 'launch-date', 'ld_options_html');
}

//callback for content
function ld_options_html(){
	//security check!
	if(current_user_can('manage_options')){
		//include the form
		//includes doesn't work with www. only files!
		include(plugin_dir_path(__FILE__) . 'ld-form.php');
	}else{
		wp_die('You do not have permission to see this page');
	}
}



//Create a group of options that are allowed in the options table
add_action('admin_init', 'ld_create_settings');
function ld_create_settings(){
					//Group Name   		Database row name 	sanitizing function
	register_setting('ld_options_group', 'ld_options', 'ld_opt_sanitize');
}


//sanitize date
function ld_opt_sanitize($input){
	$clean['date'] = wp_filter_nohtml_kses($input['date'] );
	$allowed_tags = array( 
		'br' => array(), 
		'p' => array()
		);
	return $clean;
}



//make [date] shortcode
add_shortcode('date', 'ld_short_phone' );
function ld_short_phone(){
	$values = get_option('ld_options');
	$dateFormatted = $values['date'];
	/*$phone = preg_replace('/\D+/', '', $phoneFormatted);*/
	$output  = '<div id="clock">';
	$output .= $dateFormatted;
	$output .= '</div>'."\n";
	return $output;
}




/*******************************************************************************
 * Add JS
 ******************************************************************************/

function ld_js(){
    $src = plugins_url('ld.js', __FILE__);
    wp_register_script( 'ld_js', $src );
    wp_enqueue_script( 'ld_js' ); 

    
    $values = get_option('ld_options');
	$dateFormatted = $values['date'];

	//Allows you to take data from PHP and make it available in Javascript. PHP doesn't offer a localization process for JavScript
    wp_localize_script('ld_js', 'myPath', array(
    	'userdate' =>  $dateFormatted
	));
}
add_action( 'wp_enqueue_scripts', 'ld_js' );



/*******************************************************************************
 * Add CSS
 ******************************************************************************/
function ld_css(){
    $src = plugins_url('ld.css', __FILE__);
    wp_register_style( 'ld_css', $src );
    wp_enqueue_style( 'ld_css' ); 
}
add_action( 'wp_enqueue_style', 'ld_css' );





