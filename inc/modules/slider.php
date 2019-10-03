<?php 
/**
 * Slider section
 *
 * This is the template for the content of slider section
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */
if ( ! function_exists( 'retis_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since Elead 0.1
    */
    function retis_add_slider_section() {
        $options = elead_get_theme_options();

        // Check if slider is enabled
        $enable_slider = apply_filters( 'elead_section_status', true, 'slider_enable' );

        if ( true !== $enable_slider ) {
            return false;
        }

        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'elead_filter_slider_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return;
        }
        // Render slider section now.
        retis_render_slider_section( $section_details );
    }
endif;
add_action( 'elead_primary_content_action', 'retis_add_slider_section', 10 );


if ( ! function_exists( 'retis_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since Elead 0.1
    * @param array $input slider section details.
    */
    function retis_get_slider_section_details( $input ) {
        $options = elead_get_theme_options();

        // slider type
        $slider_content_type  = $options['slider_content_type'];

        $content = array();
        switch ( $slider_content_type ) {

              case 'page':
              
                $ids = array();
                    
                if ( ! empty( $options['slider_content_post'] ) )
                    $ids = ( array ) $options['slider_content_post'];

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
            case 'post':
                $ids = array();
                        
                if ( ! empty( $options['slider_content_post'] ) )
                    $ids = ( array ) $options['slider_content_post'];

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
			case 'category':
                $ids = array();
                        
                if ( ! empty( $options['slider_content_category'] ) )
                    $ids = ( array ) $options['slider_content_category'];

                // Bail if no valid categories are selected.
                if ( empty( $ids ) ) {
                    return $input;
                }

                $args = array(
                    'no_found_rows'  => true,
                    'orderby'        => 'date',
                    'post_type'      => 'post',
                    'category__in'   => $ids,
                    'posts_per_page' => 4,
                );
            break;
        }

        if ( ! empty( $args ) ) {
            $posts = get_posts( $args );
            if ( ! empty( $posts ) ) :
                $i = 1;
                foreach ( $posts as $post ) :
                    $post_id = $post->ID;
                    $img_array = null;
                    if ( has_post_thumbnail( $post_id ) ) {
                        $img_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
                    } else {
                        $img_array[0] =  get_template_directory_uri().'/assets/uploads/no-featured-image-1920x1080.jpg';
                    }

                    if ( isset( $img_array ) ) {
                        $content[$i]['img_array'] = $img_array;
                    }
                    $content[$i]['title']   = get_the_title( $post_id );
                    $content[$i]['url']     = get_the_permalink( $post_id );
                    $content[$i]['excerpt'] = elead_trim_content( 20, $post  );

                    if( ! empty( $options['slider_btn_label' ] ) ) {
                        $content[$i]['btn_label'] = $options['slider_btn_label'];      
                    }
                    if ( 'category' != $slider_content_type ) {
                        $content[$i]['subtitle']    = ! empty( $options['slider_custom_subtitle_'.$i ] ) ? $options['slider_custom_subtitle_'.$i ] : '';
                    }
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
// slider section content details.
add_filter( 'elead_filter_slider_section_details', 'retis_get_slider_section_details' );


if ( ! function_exists( 'retis_render_slider_section' ) ) :
    /**
    * Start slider section
    *
    * @return string slider content
    * @since Elead 0.1
    *
    */
    function retis_render_slider_section( $content_details ) {
        $options = elead_get_theme_options();

        if ( empty( $content_details ) ) {
            return;
        } ?>
        <section id="main-slider" data-effect="linear" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1000, "dots": true, "arrows":true, "autoplay": true, "fade": true, "draggable": false, "pauseOnHover": true }'>
            
            <?php foreach ( $content_details as $content_detail ) : ?>
                <div class="slick-item" style="background-image:url('<?php echo esc_url( $content_detail['img_array'][0] ); ?>')">
                    <div class="wrapper">
                        <div class="main-slider-contents animated animatedFadeInUp">
                            <?php if ( ! empty( $content_detail['subtitle'] ) ) {
                                echo '<span>' . esc_html( $content_detail['subtitle'] ) . '</span>';
                            } 
                            if ( ! empty( $content_detail['title'] ) ) { ?>
                                <h2 class="page-title"><?php echo esc_html( $content_detail['title'] ); ?></h2>
                            <?php } 
                            if ( ! empty( $content_detail['excerpt'] ) ) {
                                echo '<p>' . esc_html( $content_detail['excerpt'] ) . '</p>';
                            }
                            if ( ! empty( $content_detail['btn_label'] ) ) { ?>
                                <a href="<?php echo ! empty( $content_detail['url'] ) ? esc_url( $content_detail['url'] ) : '#'; ?>" class="btn btn-fill"><?php echo esc_html( $content_detail['btn_label'] ); ?></a>
                           <?php } ?>
                        </div><!-- .slider-content -->
                    </div><!-- .wrapper -->
                </div><!-- .slick-item -->
            <?php endforeach; ?>
        </section><!-- #main-slider -->
    <?php }
endif;