<?php

// **********************************
// REMOVE / RE-ADD PLUGIN ACTIONS
// **********************************

function retis_remove_gs_team_actions()
{
    remove_action( 'add_meta_boxes', 'add_gs_team_metaboxes' );
}

function retis_remove_gs_team_shortcodes()
{
    remove_shortcode( 'gs_team' );
}

function retis_add_gs_team_actions()
{
    add_action( 'add_meta_boxes', 'add_retis_gs_team_metaboxes' );
    add_action( 'save_post', 'save_retis_gs_team_postdata' );
}

function retis_add_gs_team_shortcodes()
{
    add_shortcode( 'gs_team', 'retis_gs_team_shortcode');
}

retis_remove_gs_team_actions();
retis_remove_gs_team_shortcodes();
retis_add_gs_team_actions();
retis_add_gs_team_shortcodes();

// **********************************
// ADD/SAVE NEW METABOXES
// **********************************

function add_retis_gs_team_metaboxes()
{
	add_meta_box('gsTeamSection', 'Member\'s Additional Info' ,'retis_gs_team_cmb_cb', 'gs_team', 'normal', 'high');
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
// DEFINE NEW SHORTCODE BEHAVIOR
// **********************************

function retis_gs_team_shortcode( $atts ) {

    $gs_team_theme = gs_team_getoption('gs_team_theme', 'gs_team_settings', 'gs_tm_theme1');
    $gs_team_cols = gs_team_getoption('gs_team_cols', 'gs_team_settings', 3);

    if ( get_query_var('paged') ) {
        $gs_tm_paged = get_query_var('paged');
    } elseif ( get_query_var('page') ) {
        $gs_tm_paged = get_query_var('page');
    } else {
        $gs_tm_paged = 1;
    }

    extract(shortcode_atts(
        array(
        'num' 		=> -1,
        'order'		=> 'ASC',
        'orderby'	=> 'date',
        'theme'		=> $gs_team_theme,
        'cols'		=> $gs_team_cols,
        'group'		=> '',
        'cats_name'	=> '',
        'panel'		=> 'right'
        ), $atts
    ));

    $GLOBALS['gs_team_loop'] = new WP_Query(
        array(
        'post_type'			=> 'gs_team',
        'order'				=> $order,
        'orderby'			=> $orderby,
        'posts_per_page'	=> $num,
        'team_group'		=> $group,
        'paged'             => $gs_tm_paged,
        'meta_key' 			=> '_gs_termination_year'
    ));
    
    $output = '';
    $output = '<div  class="wrap gs_team_area '.$theme.'">';

    if ( $theme == 'gs_tm_theme1' || $theme == 'gs_tm_theme2') {
        include GSTEAM_FILES_DIR . '/includes/templates/gs_team_structure_one.php';
    }
    if ( $theme == 'gs_tm_theme3' || $theme == 'gs_tm_theme5') {
        include GSTEAM_FILES_DIR . '/includes/templates/gs_team_structure_two.php';
    }
    if ( $theme == 'gs_tm_theme4' || $theme == 'gs_tm_theme6') {
        include GSTEAM_FILES_DIR . '/includes/templates/gs_team_structure_three.php';
    }

    $output .= '</div>'; // end wrap
    return $output;
}

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

function retis_gs_team_cmb_cb( $post )
{

	// Add a nonce field so we can check for it later.
	wp_nonce_field( 'gs_team_nonce_name', 'gs_team_cmb_token' );

	/*
	* Use get_post_meta() to retrieve an existing value
	* from the database and use the value for the form.
	*/
	$gs_des = get_post_meta( $post->ID, '_gs_des', true );
	$gs_ribon = get_post_meta( $post->ID, '_gs_ribon', true );
	$gs_social  = get_post_meta($post->ID, 'gs_social', true);
	$gs_skill = get_post_meta($post->ID, 'gs_skill', true);
	
	$socialicons  = array('envelope', 'link', 'google-plus','facebook', 'instagram', 'whatsapp', 'twitter', 'youtube', 'vimeo-square', 'flickr', 'dribbble', 'behance', 'dropbox', 'wordpress',  'tumblr', 'skype', 'linkedin', 'stack-overflow','pinterest', 'foursquare','github','xing', 'stumbleupon',  'delicious', 'lastfm','hacker-news', 'reddit', 'soundcloud', 'yahoo', 'trello','steam', 'deviantart', 'twitch', 'feed','renren', 'vk', 'vine', 'spotify', 'digg', 'slideshare', 'google-scholar', 'dblp');
	?>

    <div class="gs_team-metafields">
        <div style="height: 20px;"></div>
        <div class="form-group">
            <label for="gsDes">Designation</label>
            <input type="text" id="gsDes" class="form-control" name="gs_des" value="<?php echo isset($gs_des) ? esc_attr($gs_des) : ''; ?>">
        </div>
        <h2>Member's social links</h2>

        <div class="member-details-section">
            <table id="repeatable-fieldset-two" width="100%" class="gstm-sorable-table">
                <thead>
                    <tr>
                        <td width="3%"></td>
                        <td width="45%"><?php _e('Icon','');?></td>
                        <td width="42%"><?php _e('Link','');?></td>
                        <td width="10%"></td>
                    </tr>
                </thead>
                <tbody>

				<?php if ( $gs_social ) : 
	                foreach ( $gs_social as $field ) { ?>
                    <tr>
                        <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                        <td>
                            <?php selectbuilder('gstm-team-icon[]',$socialicons,$field['icon'],__('Select icon',''),'widefat gstm-icon-select');?>
                        </td>
                        <td><input type="text" placeholder="<?php _e('ex: https://twitter.com/gsplugins','');?>" class="widefat" name="gstm-team-link[]" value="<?php if(isset($field['link'])) echo esc_attr( $field['link'] ); ?>"/></td>
                        <td><a class="button remove-row" href="#"><?php _e('Remove','');?></a></td>
                    </tr>	
                    <?php } else: ?> 
                    <tr>
                        <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                        <td>
                            <?php selectbuilder('gstm-team-icon[]',$socialicons,'',__('Select icon',''),'widefat gstm-icon-select');?>
                        </td>
                        <td><input type="text" placeholder="<?php _e('ex: https://twitter.com/gsplugins','');?>" class="widefat" name="gstm-team-link[]" value=""/></td>
                        <td><a class="button remove-row" href="#"><?php _e('Remove','');?></a></td>
                    </tr>	
                    <?php endif; ?>
                    <tr class="empty-row screen-reader-text">
                        <td><i class="fa fa-arrows" aria-hidden="true"></i></td>
                        <td>
                            <?php selectbuilder('gstm-team-icon[]',$socialicons,'',__('Select icon',''),'widefat');?>
                        </td>
                        <td><input type="text" placeholder="<?php _e('ex: https://twitter.com/gsplugins','');?>" class="widefat" name="gstm-team-link[]" value=""/></td>
                        <td><a class="button remove-row" href="#"><?php _e('Remove','');?></a></td>
                    </tr>
                </tbody>
		    </table>
		    <p><a class="button gstm-add-row" href="#" data-table="repeatable-fieldset-two"><?php _e('Add row','');?></a></p>
	    </div>
    </div>
<?php
}

?>