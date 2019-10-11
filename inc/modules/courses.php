<?php 
/**
 * Courses section
 *
 * This is the template for the content of courses section
 *
 * @package Theme Palace
 * @subpackage Elead
 * @since Elead 0.1
 */
if ( ! function_exists( 'retis_add_courses_section' ) ) :
    /**
    * Add courses section
    *
    *@since Elead 0.1
    */
    function retis_add_courses_section() {
        $options = elead_get_theme_options();

        // Check if courses is enabled
        $enable_courses = apply_filters( 'elead_section_status', true, 'courses_enable' );

        if ( true !== $enable_courses ) {
            return false;
        }

        // Get courses section details
        $section_details = array();
        $section_details = apply_filters( 'elead_filter_courses_section_details', $section_details );
        if ( empty( $section_details ) ) {
            return;
        }
        // Render courses section now.
        retis_render_courses_section( $section_details );
    }
endif;
add_action( 'elead_primary_content_action', 'retis_add_courses_section', 40 );


if ( ! function_exists( 'retis_get_courses_section_details' ) ) :
    /**
    * courses section details.
    *
    * @since Elead 0.1
    * @param array $input courses section details.
    */
    function retis_get_courses_section_details( $input ) {
        $options = elead_get_theme_options();

        // courses type
        $courses_content_type  = $options['courses_content_type'];
        $no_of_courses = ! empty( $options['no_of_courses'] ) ? $options['no_of_courses'] : 3;

        $content = array();
        switch ( $courses_content_type ) {

            case 'post':
                $ids = array();
                
                if ( ! empty( $options['courses_content_post'] ) )
                    $ids = ( array ) $options['courses_content_post'];

                // Bail if no valid posts are selected.
                if ( empty( $ids ) ) {
                    return $input;
                }

                $args = array(
                    'no_found_rows'  => true,
                    'orderby'        => 'post__in',
                    'post_type'      => 'post',
                    'post__in'       => $ids,
                    'posts_per_page' => 3,
                );  
                
          	break;
				
			case 'page':
                $ids = array();
                
				// The option field is called in the same way as post
                if ( ! empty( $options['courses_content_post'] ) )
                    $ids = ( array ) $options['courses_content_post'];

                // Bail if no valid pages are selected.
                if ( empty( $ids ) ) {
                    return $input;
                }

                $args = array(
                    'no_found_rows'  => true,
                    'orderby'        => 'post__in',
                    'post_type'      => 'page',
                    'post__in'       => $ids,
                    'posts_per_page' => 3,
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
                        $img_array = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'elead-medium' );
                    } else {
                        $img_array[0] =  get_template_directory_uri().'/assets/uploads/no-featured-image-500x500.jpg';
                    }
                    if ( isset( $img_array ) ) {
                        $content[$i]['img_array'] = $img_array;
                    }

                    $content[$i]['id']       = $post_id;
                    $content[$i]['title']    = get_the_title( $post_id );
                    $content[$i]['url']      = get_the_permalink( $post_id );
                    $content[$i]['excerpt']  = elead_trim_content( 15, $post );
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
// courses section content details.
add_filter( 'elead_filter_courses_section_details', 'retis_get_courses_section_details' );


if ( ! function_exists( 'retis_render_courses_section' ) ) :
    /**
    * Start courses section
    *
    * @return string courses content
    * @since Elead 0.1
    *
    */
    function retis_render_courses_section( $content_details ) {
        $options = elead_get_theme_options();
        $title = ! empty( $options['courses_title'] ) ? $options['courses_title'] : '';
        $sub_title = ! empty( $options['courses_sub_title'] ) ? $options['courses_sub_title'] : '';
        $courses_content_type  = $options['courses_content_type'];

        $index = 1;
        if ( empty( $content_details ) ) {
            return;
        }
        ?>
            <section id="our-courses" class="page-section">
                <div class="wrapper">
                    <header class="entry-header align-center">
                        <?php if ( ! empty( $title ) ) : ?>
                            <h2 class="entry-title"><?php echo esc_html( $title ); ?></h2>
                        <?php endif; 
                        if ( ! empty( $sub_title ) ) : ?>
                            <p class="entry-title-desc"><?php echo esc_html( $sub_title ); ?></p>
                        <?php endif; ?>
                    </header>

                    <div class="entry-content col-3">
                        <?php foreach( $content_details as $content_detail ) : 
                            $addclass = '';
                            if ( 1 === $index ) {
                                $addclass = '';
                                $addclass1 = 'right';
                            }
                            elseif ( 2 === $index ) {
                                $addclass = 'course-style';
                                $addclass1 = 'center';
                            }
                            elseif ( 3 === $index ) {
                                $addclass = '';
                                $addclass1 = 'left';
                            } ?>
                            <div class="hentry <?php echo esc_attr( $addclass ); ?>">
                                <div class="featured-course-wrapper">
                                    <?php if ( ! empty( $content_detail['img_array'][0] ) ) : ?>
                                        <a href="<?php echo esc_url( $content_detail['url'] ); ?>" 
                                            class="course-single-link">
                                            <div class="featured-image" style="background-image: url( '<?php echo esc_url( $content_detail['img_array'][0] ); ?>' )">
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                    <div class="entry-container align-<?php echo esc_attr( $addclass1 ); ?>">
                                        <div class="entry-content">
                                            <?php if ( ! empty( $content_detail['title'] ) ) : ?>
                                                <h5 class="featured-title"><a href="<?php echo ! empty( $content_detail['url'] ) ? esc_url( $content_detail['url'] ) : '#'; ?>"><?php echo esc_html( $content_detail['title'] ); ?></a></h5>
                                            <?php endif;
                                            if ( ! empty( $content_detail['excerpt'] ) ) { ?>
                                                <p><?php echo esc_html( $content_detail['excerpt'] ); ?></p>
                                            <?php } ?>
                                        </div><!-- .entry-content -->
                                    </div><!-- .entry-container -->
                                </div><!-- .featured-course-wrapper -->
                            </div><!-- .hentry -->
                        <?php $index++; endforeach; ?>
                    </div><!-- .entry-content -->
                </div><!-- .wrapper -->
                <div class="page-decoration">
                    <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/uploads/decoration.png' ); ?>" alt="<?php esc_attr__( 'Decoration','elead' ); ?>">
                </div><!-- .page-decoration -->
            </section><!-- #featured-courses -->
        <?php }
endif;
