<?php

// **********************************
// REMOVE / RE-ADD WIDGETS ACTIONS
// **********************************

function retis_add_widgets_actions()
{
    add_filter( 'widget_tag_cloud_args', 'limit_widget_tag_data' );
    add_filter( 'widget_text', 'do_shortcode' );
}

function retis_add_widgets_shortcodes()
{
    add_shortcode( 'wpb_custom_archives', 'retis_wpb_custom_archives_shortcode' ); 
}

retis_add_widgets_actions();
retis_add_widgets_shortcodes();

// **********************************
// EXECUTE NEW ACTIONS
// **********************************

function limit_widget_tag_data( $args )
{
 
    if( isset($args['taxonomy']) && $args['taxonomy'] == 'post_tag' )
    {
        $args['number'] = 10;
    }

    return $args;
}

// **********************************
// DEFINE NEW SHORTCODE BEHAVIOR
// **********************************

function retis_wpb_custom_archives_shortcode() 
{ 
    $my_archives = wp_get_archives(array(
        'type'  => 'monthly', 
        'limit' => 6,
        'echo'  => 0
    ));
         
    return $my_archives; 
}

?>