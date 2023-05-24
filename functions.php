<?php
/**
 * ReTiS functions and definitions.
 * 
 * @see Elead
 */

// ***************************************
// ENABLE WEBP UPLOAD AND DISPLAY
// ***************************************

function webp_upload_mimes( $existing_mimes ) 
{
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}

add_filter( 'mime_types', 'webp_upload_mimes' );

// ***************************************
// REMOVE / RE-ADD WP/PARENT/CHILD ACTIONS
// ***************************************

function retis_add_actions()
{
	add_action( 'init', 'retis_remove_parent_actions');
	add_action( 'admin_enqueue_scripts', 'enqueue_retis_admin_styles' );
	add_action( 'wp_enqueue_scripts', 'enqueue_retis_parent_styles' );
	add_action( 'wp_enqueue_scripts', 'enqueue_retis_custom_styles' );
	add_action( 'wp_enqueue_scripts', 'enqueue_retis_custom_scripts' );
}

function retis_remove_parent_actions() 
{
	remove_action( 'widgets_init', 'elead_widgets_init' );
	remove_action( 'elead_header_action', 'elead_site_branding', 20 );
	remove_action( 'elead_header_action', 'elead_site_navigation', 30 );
	remove_action( 'customize_register', 'elead_customize_register' );
	
	remove_action( 'elead_primary_content_action', 'elead_add_slider_section', 10 );
	remove_filter( 'elead_filter_slider_section_details', 'elead_get_slider_section_details' );
	
	remove_action( 'elead_primary_content_action', 'elead_add_courses_section', 40 );
	remove_filter( 'elead_filter_courses_section_details', 'elead_get_courses_section_details' );
	
	remove_action( 'elead_primary_content_action', 'elead_add_service_section', 30 );
	remove_filter( 'elead_filter_courses_section_details', 'elead_get_service_section_details' );
	
	remove_action( 'elead_primary_content_action', 'elead_add_about_section', 20 );
	remove_filter( 'elead_filter_about_section_details', 'elead_get_about_section_details' );
}

retis_add_actions();

// **********************************
// ENQUEUE NEW STYLES/SCRIPTS
// **********************************

function enqueue_retis_admin_styles() 
{
	wp_enqueue_style( 'academic-icons-admin', get_stylesheet_directory_uri().'/assets/css/academicons.min.css' );
	wp_enqueue_style( 'retis-admin-style', get_stylesheet_directory_uri().'/admin.css');
}

function enqueue_retis_parent_styles() 
{
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function enqueue_retis_custom_styles() 
{
	wp_enqueue_style( 'academic-icons', get_stylesheet_directory_uri().'/assets/css/academicons.min.css' );
}

function enqueue_retis_custom_scripts() 
{
	wp_enqueue_script( 'retis-js', get_stylesheet_directory_uri() . '/script.js', array('jquery'), '', true );
}

// **************************************
// LOAD ANY OTHER THEME/PLUGIN OVERRIDER
// **************************************

/**
 * Load core file
 */
require get_stylesheet_directory() . '/inc/core.php';

/**
 * Load GS Team file
 */
require get_stylesheet_directory() . '/gs-team/gs-team.php';

/**
 * Load Visual Portfolio file
 */
require get_stylesheet_directory() . '/visual-portfolio/visual-portfolio.php';

/**
 * Load Widgets file
 */
require get_stylesheet_directory() . '/widgets/widgets.php';

?>
