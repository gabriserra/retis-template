<?php
/**
 * Theme Palace widgets inclusion
 *
 * This is the template that includes all custom widgets of Elead
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */
/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function retis_widgets_init() {
	
    register_sidebar( array(
        'name'          => esc_html__( 'Sidebar', 'elead' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Add widgets here.', 'elead' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Optional Sidebar Widget Area
    register_sidebar( array(
        'name'          => esc_html__( 'Optional Sidebar 1', 'elead' ),
        'id'            => 'elead-optional-sidebar',
        'description'   => esc_html__( 'Add widgets here.', 'elead' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    // Footer Widget Area
    register_sidebars( 4, array(
        'name'          => esc_html__( 'Footer Widget Area %d', 'elead' ),
        'id'            => 'elead-footer-widget-area',
        'description'   => esc_html__( 'This Widget Area is for Footer Section.', 'elead' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    // Menu widget area - For search widget
    register_sidebar( array(
        'name'          => esc_html__( 'Menu Widget Area', 'retis' ),
        'id'            => 'menu-widget',
        'description'   => esc_html__( 'This widget area only supports search widget. Do not place anything else here.', 'retis' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s hentry">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'retis_widgets_init' );