<?php 
/**
 * Service section
 *
 * This is the template for the content of service section
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */
if ( ! function_exists( 'retis_add_service_section' ) ) :
    /**
    * Add service section
    *
    *@since Elead 0.1
    */
    function retis_add_service_section() {
        $options = elead_get_theme_options();

        // Check if service is enabled
        $enable_service = apply_filters( 'elead_section_status', true, 'service_enable' );

        if ( true !== $enable_service ) {
            return false;
        }

        // Get service section details
        $section_details = array();
        $section_details = apply_filters( 'elead_filter_service_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return;
        }
        // Render service section now.
        retis_render_service_section( $section_details );
    }
endif;
add_action( 'elead_primary_content_action', 'retis_add_service_section', 30 );


if ( ! function_exists( 'retis_get_service_section_details' ) ) :
    /**
    * service section details.
    *
    * @since Elead 0.1
    * @param array $input service section details.
    */
    function retis_get_service_section_details( $input ) {
        $options = elead_get_theme_options();
        $content =array();

        // service type
        $service_content_type  = $options['service_content_type'];

        switch ( $service_content_type ) { 
            case 'post':
                $ids = array();
                
                if ( ! empty( $options['service_content_post'] ) )
                    $ids = ( array ) $options['service_content_post'];

                // Bail if no valid pages are selected.
                if ( empty( $ids ) ) {
                    return $input;
                }

                $args = array(
                    'no_found_rows'  => true,
                    'orderby'        => 'post__in',
                    'post_type'      => 'post',
                    'post__in'       => $ids,
                    'posts_per_page' => 4,
                );                             
            break;
            case 'page':
                $ids = array();
                
                if ( ! empty( $options['service_content_post'] ) )
                    $ids = ( array ) $options['service_content_post'];

                // Bail if no valid pages are selected.
                if ( empty( $ids ) ) {
                    return $input;
                }

                $args = array(
                    'no_found_rows'  => true,
                    'orderby'        => 'post__in',
                    'post_type'      => 'page',
                    'post__in'       => $ids,
                    'posts_per_page' => 4,
                );                             
            break;
        } 

        if ( ! empty( $args ) ) {
            $posts = get_posts( $args );
            if ( ! empty( $posts ) ) :
                $i = 0;
                $icon = array ( 'fa-font','fa-gg','fa-book','fa-paper-plane' );
                foreach ( $posts as $post ) :
                    $post_id = $post->ID;
                    $content[$i]['title']   = get_the_title( $post_id );
                    $content[$i]['url']     = get_the_permalink( $post_id );
                    $content[$i]['excerpt'] = elead_trim_content( 20, $post  );
                    $content[$i]['icon']    = $icon[$i];
                    $i++;
                endforeach;
            endif;
        }

        if ( ! empty( $content ) ) {
            $input = $content;
        }
        return $input;
    }
endif;
// service section content details.
add_filter( 'elead_filter_service_section_details', 'retis_get_service_section_details' );


if ( ! function_exists( 'retis_render_service_section' ) ) :
    /**
    * Start service section
    *
    * @return string service content
    * @since Elead 0.1
    *
    */
    function retis_render_service_section( $content_details ) {
        $options    = elead_get_theme_options();
        $service_title      = ! empty( $options['service_section_title'] ) ? $options['service_section_title'] : '';
        $service_subtitle  = ! empty( $options['service_section_subtitle'] ) ? $options['service_section_subtitle'] : '';

        if ( empty( $content_details ) ) {
            return;
        } ?>
        <section id="services" class="page-section">
            <div class="wrapper">
                <?php if( ! empty( $service_title ) || ! empty( $service_subtitle ) ) : ?>
                    <header class="entry-header align-center">
                        <?php if ( ! empty( $service_title ) ) : ?>
                            <h2 class="entry-title"><?php echo esc_html( $service_title ); ?></h2>
                        <?php endif; 
                        if ( ! empty( $service_subtitle ) ) : ?>
                            <p class="entry-title-desc"><?php echo esc_html( $service_subtitle ); ?></p>
                        <?php endif; ?>
                    </header><!-- .entry-header -->
                <?php endif; ?>            
                <div class="entry-content col-2">
                    <div class="row">                
                        <?php foreach ( $content_details as $content_detail ) : ?>
                        <div class="hentry">
                            <div class="services-wrapper">
                                <?php if( ! empty( $content_detail['icon'] ) ) { ?>
								<a href="<?php echo ! empty( $content_detail['url'] ) ? esc_url( $content_detail['url'] ) : '#'; ?>">
									<div class="services-icon">
										<i class="fa <?php echo esc_html( $content_detail['icon'] ); ?>"></i>
									</div><!-- .services-icon -->
								</a>
                                <?php } ?>
                            </div><!-- .services-wrapper -->
                            <div class="services-content">
                                <?php if ( ! empty( $content_detail['title'] ) ) : ?>
                                    <h5 class="featured-title"><a href="<?php echo ! empty( $content_detail['url'] ) ? esc_url( $content_detail['url'] ) : '#'; ?>"><?php echo esc_html( $content_detail['title'] ); ?></a></h5>
                                <?php endif;
                                if( ! empty( $content_detail['excerpt'] ) ) { ?>
                                    <p><?php echo esc_html( $content_detail['excerpt'] ); ?></p>
                                <?php } ?>
                            </div><!-- .services-wrapper -->
                        </div><!-- .hentry -->
                        <?php endforeach; ?>    
                    </div><!-- .row -->
                </div><!-- .entry-content -->
            </div><!-- .wrapper -->
        </section><!-- #featured-services -->
    <?php }
endif;
