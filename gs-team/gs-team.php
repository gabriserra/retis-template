<?php

// **********************************
// REMOVE / RE-ADD PLUGIN ACTIONS
// **********************************

function retis_add_gs_team_actions()
{
    add_action( 'add_meta_boxes', 'add_retis_gs_team_metaboxes' );
    add_action( 'save_post', 'save_retis_gs_team_postdata' );
}

retis_add_gs_team_actions();

// **********************************
// ADD/SAVE NEW METABOXES
// **********************************

function add_retis_gs_team_metaboxes()
{
    remove_meta_box('gsTeamSectionSocial', 'gs_team', 'normal');
    add_meta_box('gsTeamSectionSocial', 'Member\'s Social Links' ,'retis_gs_team_cmb_social_cb', 'gs_team', 'normal', 'high');
    add_meta_box('gsTeamYear', 'Member\'s termination date', 'retis_gs_team_cmb_year', 'gs_team', 'normal', 'high');
}

function save_retis_gs_team_postdata( $post_id )
{
	if (array_key_exists('retis_gs_team_cmb_year_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_gs_termination_year',
            $_POST['retis_gs_team_cmb_year_field']
        );
	}
}

// **********************************
// DEFINE NEW LOOP BEHAVIOR
// **********************************

function retis_gs_team_wp_query_args ( $args )
{
    if ( $args['orderby'] == 'menu_order' )
    {
        $args['orderby'] = 'meta_value';
        $args['meta_key'] = '_gs_termination_year';
    }

    return $args;
}

add_filter('gs_team_wp_query_args', 'retis_gs_team_wp_query_args', 10, 1);

// **********************************
// DEFINE NEW META BEHAVIOR
// **********************************

function retis_gs_team_cmb_year( $post )
{
	$value = get_post_meta( $post->ID, '_gs_termination_year', true );
    ?>
    <label for="retis_gs_team_cmb_year_field">Year of termination</label>
	<input type="number" min="1900" max="2099" step="1" name="retis_gs_team_cmb_year_field" id="retis_gs_team_cmb_year_field" class="vp-input" value="<?php echo $value ?>">
	<?php
}

function retis_gs_team_cmb_social_cb( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'gs_team_nonce_name', 'gs_team_cmb_token' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $gs_social  = get_post_meta($post->ID, 'gs_social', true);
    $social_icons  = array('envelope', 'link', 'google-plus','facebook', 'instagram', 'whatsapp', 'twitter', 'youtube', 'vimeo-square', 'flickr', 'dribbble', 'behance', 'dropbox', 'wordpress',  'tumblr', 'skype', 'linkedin', 'stack-overflow','pinterest', 'foursquare','github','xing', 'stumbleupon',  'delicious', 'lastfm','hacker-news', 'reddit', 'soundcloud', 'yahoo', 'trello','steam', 'deviantart', 'twitch', 'feed','renren', 'vk', 'vine', 'spotify', 'digg', 'slideshare', 'google-scholar', 'dblp');
    
    ?>

    <div class="gs_team-metafields">

        <div style="height: 20px;"></div>

        <div class="gs-team-social--section">
            
            <div class="member-details-section">

                <table id="repeatable-fieldset-two" width="100%" class="gstm-sorable-table">
                    <thead>
                        <tr>
                            <td width="3%"></td>
                            <td width="45%"><?php _e( 'Icon', 'gsteam' ); ?></td>
                            <td width="42%"><?php _e( 'Link', 'gsteam' ); ?></td>
                            <td width="10%"></td>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if ( $gs_social ) : foreach ( $gs_social as $field ) : ?>
                            
                            <tr>
                                <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                                <td>
                                    <?php GSTEAM\select_builder('gstm-team-icon[]', $social_icons, $field['icon'], __('Select icon', 'gsteam'), 'widefat gstm-icon-select'); ?>
                                </td>
                                <td><input type="text" placeholder="<?php _e('ex: https://twitter.com/gsplugins', 'gsteam'); ?>" class="widefat" name="gstm-team-link[]" value="<?php if(isset($field['link'])) echo esc_attr( $field['link'] ); ?>"/></td>
                                <td><a class="button remove-row" href="#"><?php _e('Remove', 'gsteam'); ?></a></td>
                            </tr>

                        <?php endforeach; else: ?> 

                            <tr>
                                <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                                <td>
                                    <?php GSTEAM\select_builder('gstm-team-icon[]', $social_icons, '', __('Select icon', 'gsteam'), 'widefat gstm-icon-select'); ?>
                                </td>
                                <td><input type="text" placeholder="<?php _e('ex: https://twitter.com/gsplugins', 'gsteam'); ?>" class="widefat" name="gstm-team-link[]" value=""/></td>
                                <td><a class="button remove-row" href="#"><?php _e('Remove', 'gsteam'); ?></a></td>
                            </tr>

                        <?php endif; ?>

                        <tr class="empty-row screen-reader-text">
                            <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                            <td>
                                <?php GSTEAM\select_builder('gstm-team-icon[]', $social_icons, '', __('Select icon', 'gsteam'), 'widefat'); ?>
                            </td>
                            <td><input type="text" placeholder="<?php _e('ex: https://twitter.com/gsplugins', 'gsteam'); ?>" class="widefat" name="gstm-team-link[]" value=""/></td>
                            <td><a class="button remove-row" href="#"><?php _e('Remove', 'gsteam'); ?></a></td>
                        </tr>

                    </tbody>
                </table>

                <p><a class="button gstm-add-row" href="#" data-table="repeatable-fieldset-two"><?php _e('Add Row', 'gsteam'); ?></a></p>

            </div>

        </div>

    </div>

    <?php
}

?>