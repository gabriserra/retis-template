<?php
/**
 * Elead basic theme structure hooks
 *
 * This file contains structural hooks.
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */

if ( ! function_exists( 'retis_site_branding' ) ) :
	/**
	 * Site branding codes
	 *
	 * @since Elead 0.1
	 *
	 */
	function retis_site_branding() {

		$options = elead_get_theme_options();
		$enable_headline = $options['headline_enable'];
		// Get headline section details
        $section_details = array();
        $section_details = apply_filters( 'elead_filter_headline_section_details', $section_details );
		
		$headline_exits = ( empty( $section_details ) || ( true !== $enable_headline ) ) ? 'no-headline-section' : 'headline-section';
		?>
		<div class="wrapper">
			<div class="site-branding <?php echo esc_attr( $headline_exits ); ?> pull-left">
				<?php if ( has_custom_logo() ) : ?>
					<div class="site-logo">
            			<?php echo get_custom_logo(); ?>
          			</div>
      			<?php endif; ?>
				<div id="site-details">
					<?php
					if ( is_front_page() && is_home() ) : ?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
					endif;

					$description = get_bloginfo( 'description', 'display' );
					if ( $description || is_customize_preview() ) : ?>
						<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
					<?php
					endif; ?>
				</div><!-- #site-details -->
			</div><!-- .site-branding -->
			<div class="widget-area col-2"><a class="topbar-toggle topbar-search-toggle"><i class="fa fa-search"></i></a></div><!-- .widget-area -->

		</div><!-- .wrapper -->
		<?php
}
endif;
add_action( 'elead_header_action', 'retis_site_branding', 20 );

if ( ! function_exists( 'retis_site_navigation' ) ) :
	/**
	 * Site navigation codes
	 *
	 * @since Elead 0.1
	 *
	 */
	function retis_site_navigation() {
		?>
			<nav id="site-navigation" class="main-navigation" role="navigation">
				<div class="wrapper">
					<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
					<?php dynamic_sidebar ( 'menu-widget' ); ?>
				</div>
			</nav><!-- #site-navigation -->
		<?php
	}
endif;
add_action( 'elead_header_action', 'retis_site_navigation', 30 );
