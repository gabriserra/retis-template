<?php
/**
 * Service Section options
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

$wp_customize->add_section( 'elead_service', array(
	'title'             => esc_html__( 'Services','elead' ),
	'description'       => esc_html__( 'Services Section Options.', 'elead' ),
	'panel'             => 'elead_sections_panel',
) );

// service Section enable setting and control.
$wp_customize->add_setting( 'elead_theme_options[service_enable]', array(
	'sanitize_callback'	=> 'elead_sanitize_checkbox',
	'default'          	=> $options['service_enable'],
) );

$wp_customize->add_control( 'elead_theme_options[service_enable]', array(
	'label'            	=> esc_html__( 'Enable Service Section', 'elead' ),
	'section'          	=> 'elead_service',
	'type'             	=> 'checkbox',
) );

// service Section title setting and control.
$wp_customize->add_setting( 'elead_theme_options[service_section_title]', array(
	'default'           => $options['service_section_title'],
	'sanitize_callback' => 'sanitize_text_field',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'elead_theme_options[service_section_title]', array(
	'active_callback'	=> 'elead_is_service_enable',
	'label'             => esc_html__( 'Section Title', 'elead' ),
	'section'           => 'elead_service',
	'type'				=> 'text'
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'elead_theme_options[service_section_title]', array(
		'selector'            => '#services .wrapper .entry-header h2.entry-title',
		'settings'            => 'elead_theme_options[service_section_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'elead_service_title',
    ) );
}

//service Section subtitle setting and control.
$wp_customize->add_setting( 'elead_theme_options[service_section_subtitle]', array(
	'default'           => $options['service_section_subtitle'],
	'sanitize_callback' => 'sanitize_text_field',
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'elead_theme_options[service_section_subtitle]', array(
	'active_callback'	=> 'elead_is_service_enable',
	'label'             => esc_html__( 'Section SubTitle', 'elead' ),
	'section'           => 'elead_service',
	'type'				=> 'text'
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'elead_theme_options[service_section_subtitle]', array(
		'selector'            => '#services .wrapper .entry-header p.entry-title-desc',
		'settings'            => 'elead_theme_options[service_section_subtitle]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'elead_service_sub_title',
    ) );
}

// service post hr setting and control
$wp_customize->add_setting( 'elead_theme_options[service_hr]', array(
	'sanitize_callback' => 'sanitize_text_field'
) );

$wp_customize->add_control( new Elead_Customize_Horizontal_Line( $wp_customize, 'elead_theme_options[service_hr]',
	array(
		'section'         => 'elead_service',
		'active_callback' => 'elead_is_service_enable',
		'type'			  => 'hr'
) ) );

// service Section content type setting and control.
$wp_customize->add_setting( 'elead_theme_options[service_content_type]', array(
	'default'          	=> $options['service_content_type'],
	'sanitize_callback'	=> 'elead_sanitize_select',
) );

$wp_customize->add_control( 'elead_theme_options[service_content_type]', array(
	'label'            	=> esc_html__( 'Services Content Type', 'elead' ),
	'section'          	=> 'elead_service',
	'type'             	=> 'select',
	'active_callback'	=> 'elead_is_service_enable',
	'choices'			=> array(
            'post'      => esc_html__( 'Post', 'elead' ),
			'page'      => esc_html__( 'Page', 'elead' ),
			'static'	=> esc_html__( 'Static', 'elead'),
        ),
) );

// service Section custom title setting and control.
$wp_customize->add_setting( 'elead_theme_options[service_content_post]', array(
	'sanitize_callback' => 'elead_sanitize_post_ids',
) );

$wp_customize->add_control( 'elead_theme_options[service_content_post]', array(
	'active_callback'	=> 'elead_is_service_enable',
	'label'             => esc_html__( 'Input Content Ids', 'elead' ),
	'description'       => esc_html__( 'Simply hover post title on dashboard to see the Content ID. Max no. of posts allowed is 4. ie: 11, 24, 34', 'elead' ),
	'section'           => 'elead_service',
	'type'				=> 'text'
) );

// add control if you want to place static content (icons + caption)
$wp_customize->add_setting( 'elead_theme_options[service_content_icons]', array(
	'sanitize_callback' => 'retis_sanitize_cs_input',
) );
$wp_customize->add_setting( 'elead_theme_options[service_content_captions]', array(
	'sanitize_callback' => 'retis_sanitize_cs_input',
) );
$wp_customize->add_setting( 'elead_theme_options[service_content_urls]', array(
	'sanitize_callback' => 'retis_sanitize_cs_textarea',
) );

$wp_customize->add_control( 'elead_theme_options[service_content_icons]', array(
	'active_callback'	=> 'elead_is_service_enable',
	'label'             => esc_html__( 'Static: Icons FontAwesome ID', 'elead' ),
	'description'       => esc_html__( 'Insert FontAwesome class ids. Use commas as separators', 'elead' ),
	'section'           => 'elead_service',
	'type'				=> 'text'
) );
$wp_customize->add_control( 'elead_theme_options[service_content_captions]', array(
	'active_callback'	=> 'elead_is_service_enable',
	'label'             => esc_html__( 'Static: Box captions', 'elead' ),
	'description'       => esc_html__( 'Insert text caption for each box. Use commas as separators', 'elead' ),
	'section'           => 'elead_service',
	'type'				=> 'text'
) );
$wp_customize->add_control( 'elead_theme_options[service_content_urls]', array(
	'active_callback'	=> 'elead_is_service_enable',
	'label'             => esc_html__( 'Static: Box urls', 'elead' ),
	'description'       => esc_html__( 'Insert urls for each box. Use commas as separators', 'elead' ),
	'section'           => 'elead_service',
	'type'				=> 'textarea'
) );