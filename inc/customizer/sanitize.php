<?php
/**
 * Customizer sanitization functions
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

if ( ! function_exists( 'retis_sanitize_cs_input' ) ) :
	/**
	* Sanitizes comma separated strings
	* @param  $input entered value
	* @return sanitized output
	*
	* @since Retis 0.1
	*/
	function retis_sanitize_cs_input( $input ) {

		$values = explode( ',', $input );

		// need something?

		return $values;
	}
endif;

if ( ! function_exists( 'retis_sanitize_cs_textarea' ) ) :
	/**
	* Sanitizes newline separated strings
	* @param  $input entered value
	* @return sanitized output
	*
	* @since Retis 0.1
	*/
	function retis_sanitize_cs_textarea( $input ) {

		$values = explode( ',', $input );

		// need something?

		return $values;
	}
endif;

if ( ! function_exists( 'elead_sanitize_select' ) ) :
	/**
	 * Sanitize select, radio.
	 *
	 * @since Elead 0.1
	 *
	 * @param mixed                $input The value to sanitize.
	 * @param WP_Customize_Setting $setting WP_Customize_Setting instance.
	 * @return mixed Sanitized value.
	 */
	function elead_sanitize_select( $input, $setting ) {
		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
endif;

if ( ! function_exists( 'elead_sanitize_page' ) ) :
	/**
	* Sanitizes page/post
	* @param  $input entered value
	* @return sanitized output
	*
	* @since Elead 0.1
	*/
	function elead_sanitize_page( $input ) {

	  // Ensure $input is an absolute integer.
	  $page_id = absint( $input );

	  // Retrieve all page ids
	  $page_ids = get_all_page_ids();

	  if ( in_array( $page_id, $page_ids ) ) {
	     // If $page_id is an ID of a published page, return it; otherwise, return false
	     return ( 'publish' == get_post_status( $page_id ) ? $page_id : false );
	  }
	}
endif;

if ( ! function_exists( 'elead_sanitize_checkbox' ) ) :
	/**
	 * Sanitize checkbox.
	 *
	 * @since Elead 0.1
	 *
	 * @param bool $checked Whether the checkbox is checked.
	 * @return bool Whether the checkbox is checked.
	 */
	function elead_sanitize_checkbox( $checked ) {

		return ( ( isset( $checked ) && true == $checked ) ? true : false );

	}
endif;

if ( ! function_exists( 'elead_santize_allow_tag' ) ) :
	/**
	 * Text field with allowed tag anchor sanitization callback example.
	 *
	 * @see absint() https://developer.wordpress.org/reference/functions/absint/
	 *
	 * @param string  $input  
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return string The input with only allowed tag i.e. anchor
	 */
	function elead_santize_allow_tag( $input, $setting ) {
		$input = wp_kses( $input, array(
			'br' => array(),
			'a' => array(
				'target' => array(),
				'href' => array(),
				)
			) );

		return $input;
	}
endif;

if ( ! function_exists( 'elead_sanitize_post_ids' ) ) :
	/**
	* Sanitizes post ids
	* @param  $input entered value
	* @return sanitized output
	*
	* @since Elead 0.1
	*/
	function elead_sanitize_post_ids( $input ) {

		$ids = explode( ',', $input );

		// Ensure $input is an absolute integer.
		$posts_ids = array_map( 'absint', $ids );

		$output = array();

		foreach ( $posts_ids as $post_id ) {
			if ( 'publish' == get_post_status( $post_id ) )
				$output[] = $post_id;
		}

		return $output;
	}
endif;

if ( ! function_exists( 'retis_sanitize_category_ids' ) ) :
	/**
	* Sanitizes category ids
	* @param  $input entered value
	* @return sanitized output
	*
	* @since Retis 0.1 (?)
	*/
	function retis_sanitize_category_ids( $input ) {

		$ids = explode( ',', $input );

		// Ensure $input is an absolute integer.
		$category_ids = array_map( 'absint', $ids );

		$output = array();

		foreach ( $category_ids as $category_id ) {
			$category = get_category( $category_id );
			
			if ( $category != null && !is_wp_error( $category ) )
				$output[] = $category_id;
		}

		return $output;
	}
endif;