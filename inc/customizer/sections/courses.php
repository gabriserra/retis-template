<?php
/**
 * Courses Section options
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

$wp_customize->add_section( 'elead_courses', array(
	'title'             => esc_html__( 'Courses','elead' ),
	'description'       => esc_html__( 'Courses Section Options.', 'elead' ),
	'panel'             => 'elead_sections_panel',
) );

// courses Section enable setting and control.
$wp_customize->add_setting( 'elead_theme_options[courses_enable]', array(
	'sanitize_callback'	=> 'elead_sanitize_checkbox',
	'default'          	=> $options['courses_enable'],
) );

$wp_customize->add_control( 'elead_theme_options[courses_enable]', array(
	'label'            	=> esc_html__( 'Enable Courses Section', 'elead' ),
	'section'          	=> 'elead_courses',
	'type'             	=> 'checkbox',
) );

// courses Section title setting and control.
$wp_customize->add_setting( 'elead_theme_options[courses_title]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['courses_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'elead_theme_options[courses_title]', array(
	'label'            	=> esc_html__( 'Title', 'elead' ),
	'section'          	=> 'elead_courses',
	'type'             	=> 'text',
	'active_callback'	=> 'elead_is_courses_enable',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'elead_theme_options[courses_title]', array(
		'selector'            => '#our-courses .wrapper .entry-header h2.entry-title',
		'settings'            => 'elead_theme_options[courses_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'elead_courses_title',
    ) );
}


// courses Section subtitle setting and control.
$wp_customize->add_setting( 'elead_theme_options[courses_sub_title]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['courses_sub_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'elead_theme_options[courses_sub_title]', array(
	'label'            	=> esc_html__( 'Sub Title', 'elead' ),
	'section'          	=> 'elead_courses',
	'type'             	=> 'text',
	'active_callback'	=> 'elead_is_courses_enable',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'elead_theme_options[courses_sub_title]', array(
		'selector'            => '#our-courses .wrapper .entry-header p.entry-title-desc',
		'settings'            => 'elead_theme_options[courses_sub_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'elead_courses_subtitle',
    ) );
}

// courses Section content type setting and control.
$wp_customize->add_setting( 'elead_theme_options[courses_content_type]', array(
	'default'          	=> $options['courses_content_type'],
	'sanitize_callback'	=> 'elead_sanitize_select',
) );

$wp_customize->add_control( 'elead_theme_options[courses_content_type]', array(
	'label'            	=> esc_html__( 'Courses Content Type', 'elead' ),
	'section'          	=> 'elead_courses',
	'type'             	=> 'select',
	'active_callback'	=> 'elead_is_courses_enable',
	'choices'			=> array(
            'post'      => esc_html__( 'Post', 'elead' ),
			'page'      => esc_html__( 'Page', 'elead' ),
        ),
) );

// courses Section content type post setting and control.
$wp_customize->add_setting( 'elead_theme_options[courses_content_post]', array(
	'validate_callback' => 'elead_validate_post_id',
	'sanitize_callback' => 'elead_sanitize_post_ids',
) );

$wp_customize->add_control( 'elead_theme_options[courses_content_post]', array(
	'active_callback'	=> 'elead_is_courses_enable',
	'label'             => esc_html__( 'Input Content Ids', 'elead' ),
	'description'       => esc_html__( 'Simply hover post title on dashboard to see the Content ID. Max no. of posts allowed is 3. ie: 11, 24, 34', 'elead' ),
	'section'           => 'elead_courses',
	'type'				=> 'text',
) );