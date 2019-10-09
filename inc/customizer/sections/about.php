<?php
/**
 * About Section options
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

$wp_customize->add_section( 'elead_about', array(
	'title'             => esc_html__( 'About','elead' ),
	'description'       => esc_html__( 'About Section Options.', 'elead' ),
	'panel'             => 'elead_sections_panel',
) );

// about section enable setting and control.
$wp_customize->add_setting( 'elead_theme_options[about_enable]', array(
	'sanitize_callback'	=> 'elead_sanitize_checkbox',
	'default'          	=> $options['about_enable'],
) );

$wp_customize->add_control( 'elead_theme_options[about_enable]', array(
	'label'            	=> esc_html__( 'Enable About Section', 'elead' ),
	'section'          	=> 'elead_about',
	'type'             	=> 'checkbox',
) );

// about section content type setting and control.
$wp_customize->add_setting( 'elead_theme_options[about_content_type]', array(
	'default'          	=> $options['about_content_type'],
	'sanitize_callback'	=> 'elead_sanitize_select',
) );

$wp_customize->add_control( 'elead_theme_options[about_content_type]', array(
	'label'            	=> esc_html__( 'About Content Type', 'elead' ),
	'section'          	=> 'elead_about',
	'type'             	=> 'select',
	'active_callback'	=> 'elead_is_about_enable',
	'choices'			=> array(
			'page'      => esc_html__( 'Page', 'elead' ),
			'retis'		=> esc_html__( 'Retis style', 'elead'),
        ),
) );

// Show content type page drop-down setting and control
$wp_customize->add_setting( 'elead_theme_options[about_content_page]', array(
	'sanitize_callback' => 'elead_sanitize_page'
) );

$wp_customize->add_control( 'elead_theme_options[about_content_page]', array(
	'label'           	=> esc_html__( 'Select Page', 'elead' ),
	'section'        	=> 'elead_about',
	'active_callback' 	=> 'elead_is_about_enable',
	'type'				=> 'dropdown-pages'
) );

// about section custom title setting and control.
$wp_customize->add_setting( 'elead_theme_options[about_custom_subtitle]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['about_custom_subtitle'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'elead_theme_options[about_custom_subtitle]', array(
	'label'            	=> esc_html__( 'Sub Title', 'elead' ),
	'section'          	=> 'elead_about',
	'type'             	=> 'text',
	'active_callback'	=> 'elead_is_about_enable',
) );

// service Section custom title setting and control.
$wp_customize->add_setting( 'elead_theme_options[about_content_category]', array(
	'sanitize_callback' => 'retis_sanitize_category_ids',
) );

$wp_customize->add_control( 'elead_theme_options[about_content_category]', array(
	'active_callback'	=> 'elead_is_about_enable',
	'label'             => esc_html__( 'Categories for slider', 'elead' ),
	'description'       => esc_html__( 'When retis selected, the categories will be used to select posts for slider', 'elead' ),
	'section'           => 'elead_about',
	'type'				=> 'text'
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'elead_theme_options[about_custom_subtitle]', array(
		'selector'            => '#about .wrapper .entry-header p.entry-title-desc',
		'settings'            => 'elead_theme_options[about_custom_subtitle]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'elead_about_sub_title',
    ) );
}