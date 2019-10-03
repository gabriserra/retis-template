<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package elead
	 */

	/**
	 * elead_doctype hook
	 *
	 * @hooked elead_doctype -  10
	 *
	 */
	do_action( 'elead_doctype' );
?>
<head>
<?php
	/**
	 * elead_before_wp_head hook
	 *
	 * @hooked elead_head -  10
	 *
	 */
	do_action( 'elead_before_wp_head' );

	wp_head(); 
?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wp_body_open' ); ?>
<?php
	/**
	 * elead_page_start_action hook
	 *
	 * @hooked elead_page_start -  10
	 *
	 */
	do_action( 'elead_page_start_action' ); 

	/**
	 * elead_before_header hook
	 *
	 * @hooked elead_add_breadcrumb -  20
	 *
	 */
	do_action( 'elead_before_header' );

	/**
	 * elead_header_action hook
	 *
	 * @hooked elead_add_headline_section -  5
	 * @hooked elead_header_start -  10
	 * @hooked elead_site_branding -  20
	 * @hooked elead_site_navigation -  30
	 * @hooked elead_header_end -  50
	 *
	 */
	do_action( 'elead_header_action' );

	/**
	 * elead_content_start_action hook
	 *
	 * @hooked elead_content_start -  10
	 * @hooked elead_custom_header -  20	 
	 *
	 */
	do_action( 'elead_content_start_action' );
	
	/**
	 * elead_primary_content_action hook
	 *
	 * @hooked elead_add_slider_section -  10
	 * @hooked elead_add_about_section -  20
	 * @hooked elead_add_service_section -  30
	 * @hooked elead_add_courses_section -  40
	 * @hooked elead_add_call_to_action_section -  50
	 * @hooked elead_add_team_section -  70
	 */
	do_action( 'elead_primary_content_action' );