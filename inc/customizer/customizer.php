<?php
/**
 * Elead Theme Customizer.
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

 /**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function retis_customize_register( $wp_customize ) {
	$options = elead_get_theme_options();

	// Load custom control functions.
	require get_template_directory() . '/inc/customizer/custom-controls.php';

	// Load customize active callback functions.
	require get_template_directory() . '/inc/customizer/active-callback.php';

	// Load validation callback functions.
	require get_template_directory() . '/inc/customizer/validation.php';

	// Load partial callback functions.
	require get_template_directory() . '/inc/customizer/partial.php';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Add panel for section options
	$wp_customize->add_panel( 'elead_sections_panel' , array(
	    'title'      => esc_html__( 'Homepage Sections','elead' ),
	    'description'=> esc_html__( 'These options only applies when a static front page is set.', 'elead' ),
	    'priority'   => 150,
	) );
	
	// headline
	require get_template_directory() . '/inc/customizer/sections/headline.php';

	// Slider
	require get_stylesheet_directory() . '/inc/customizer/sections/slider.php';

	// about
	require get_stylesheet_directory() . '/inc/customizer/sections/about.php';
	
	// Service
	require get_stylesheet_directory() . '/inc/customizer/sections/service.php';
	
	// Courses
	require get_stylesheet_directory() . '/inc/customizer/sections/courses.php';

	// Call To Action
	require get_template_directory() . '/inc/customizer/sections/call-to-action.php';

	// Team
	require get_template_directory() . '/inc/customizer/sections/team.php';

	// Social
	require get_template_directory() . '/inc/customizer/sections/social.php';

	// Add panel for common theme options
	$wp_customize->add_panel( 'elead_theme_options_panel' , array(
	    'title'      => esc_html__( 'Theme Options','elead' ),
	    'description'=> esc_html__( 'Elead Theme Options.', 'elead' ),
	    'priority'   => 150,
	) );

	// load layout
	require get_template_directory() . '/inc/customizer/theme-options/layout.php';

	// load static homepage option
	require get_template_directory() . '/inc/customizer/theme-options/homepage-static.php';

	// load breadcrumb option
	require get_template_directory() . '/inc/customizer/theme-options/breadcrumb.php';

	// load pagination option
	require get_template_directory() . '/inc/customizer/theme-options/pagination.php';

	// load footer option
	require get_template_directory() . '/inc/customizer/theme-options/footer.php';

	// load reset option
	require get_template_directory() . '/inc/customizer/theme-options/reset.php';

	// load blog option
	require get_template_directory() . '/inc/customizer/theme-options/blog.php';
	
	// load single option
	require get_template_directory() . '/inc/customizer/theme-options/single.php';

}
add_action( 'customize_register', 'retis_customize_register' );

/*
 * Load retis customizer sanitization functions.
 */
require get_stylesheet_directory() . '/inc/customizer/sanitize.php';