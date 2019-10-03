<?php
/**
 * Core file.
 *
 * This is the template that includes all the other files for core featured of Elead.
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

/**
 * Add structural hooks.
 */
require get_stylesheet_directory() . '/inc/structure.php';

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/customizer/customizer.php';

/**
 * Homepage Section additions.
 */
require get_stylesheet_directory() . '/inc/modules/sections.php';

/**
 * Custom widget additions.
 */
require get_stylesheet_directory() . '/inc/widgets/widgets.php';