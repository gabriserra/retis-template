<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

$wp_customize->add_section( 'elead_slider', array(
	'title'             => esc_html__( 'Slider','elead' ),
	'description'       => esc_html__( 'Slider Section Options.', 'elead' ),
	'panel'             => 'elead_sections_panel',
) );

// Slider Section enable setting and control.
$wp_customize->add_setting( 'elead_theme_options[slider_enable]', array(
	'sanitize_callback'	=> 'elead_sanitize_checkbox',
	'default'          	=> $options['slider_enable'],
) );

$wp_customize->add_control( 'elead_theme_options[slider_enable]', array(
	'label'            	=> esc_html__( 'Enable Slider Section', 'elead' ),
	'section'          	=> 'elead_slider',
	'type'             	=> 'checkbox',
) );

$wp_customize->add_control( new Elead_Customize_Horizontal_Line( $wp_customize, 'elead_theme_options[slider_hr]',
	array(
		'section'         => 'elead_slider',
		'active_callback' => 'elead_is_slider_enable',
		'type'			  => 'hr'
) ) );

// Add slider content type setting and control.
$wp_customize->add_setting( 'elead_theme_options[slider_content_type]', array(
	'default'           => $options['slider_content_type'],
	'sanitize_callback' => 'elead_sanitize_select'
) );

$wp_customize->add_control( 'elead_theme_options[slider_content_type]', array(
	'label'           	=> esc_html__( 'Content Type', 'elead' ),
	'description'     	=> esc_html__( 'Recommended slider image size is 1920x1080 px', 'elead' ),
	'section'         	=> 'elead_slider',
	'type'            	=> 'select',
	'active_callback' 	=> 'elead_is_slider_enable',
	'choices'         	=> array(
            'post'      => esc_html__( 'Post', 'elead' ),
            'page'      => esc_html__( 'Page', 'elead' ),
			'category'	=> esc_html__( 'Category', 'elead' )
        ), 
) );

// Slider Section custom title setting and control.
$wp_customize->add_setting( 'elead_theme_options[slider_content_post]', array(
	'sanitize_callback' => 'elead_sanitize_post_ids',
) );

$wp_customize->add_control( 'elead_theme_options[slider_content_post]', array(
	'active_callback'	=> 'elead_is_slider_enable',
	'label'             => esc_html__( 'Input Content Ids', 'elead' ),
	'description'       => esc_html__( 'Simply hover post title on dashboard to see the Content ID. Max no. of posts allowed is 4. ie: 11, 24, 34', 'elead' ),
	'section'           => 'elead_slider',
	'type'				=> 'text'
) );

// Slider Section custom title setting and control.
$wp_customize->add_setting( 'elead_theme_options[slider_content_category]', array(
	'sanitize_callback' => 'retis_sanitize_category_ids',
) );

$wp_customize->add_control( 'elead_theme_options[slider_content_category]', array(
	'active_callback'	=> 'elead_is_slider_enable',
	'label'             => esc_html__( 'Input Category Ids', 'elead' ),
	'description'       => esc_html__( 'Enabled only if selected above. Only first 4. are queried. Posts are ordered by date.', 'elead' ),
	'section'           => 'elead_slider',
	'type'				=> 'text'
) );

// Slider Section button label setting and control.
$wp_customize->add_setting( 'elead_theme_options[slider_btn_label]', array(
	'default'           => $options['slider_btn_label'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'elead_theme_options[slider_btn_label]', array(
	'active_callback'	=> 'elead_is_slider_enable',
	'label'             => esc_html__( 'Input link button label', 'elead' ),
	'section'           => 'elead_slider',
	'type'				=> 'text'
) );
