<?php
/**
 * ReTiS functions and definitions.
 * 
 * @see Elead
 */

add_action( 'init', 'remove_parent_actions');
add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );
add_action( 'wp_enqueue_scripts', 'enqueue_custom_styles' );
add_action( 'admin_enqueue_scripts', 'admin_style' );
add_action( 'wp_enqueue_scripts', 'enqueue_child_scripts' );
add_action( 'save_post', 'retis_save_postdata' );
add_action( 'add_meta_boxes', 'retis_add_custom_box' );
add_action( 'add_meta_boxes', 'add_retis_team_metaboxes' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

function enqueue_custom_styles() {
	wp_enqueue_style( 'academic-icons', get_stylesheet_directory_uri().'/assets/css/academicons.min.css' );
}

function admin_style() {
	wp_enqueue_style( 'academic-icons-admin', get_stylesheet_directory_uri().'/assets/css/academicons.min.css' );
	wp_enqueue_style( 'retis-admin-style', get_stylesheet_directory_uri().'/admin.css');
}

function enqueue_child_scripts() {
	wp_enqueue_script( 'retis-js', get_stylesheet_directory_uri() . '/script.js', array('jquery'), '', true );
}

function remove_parent_actions() {
	remove_action( 'widgets_init', 'elead_widgets_init' );
	remove_action( 'elead_header_action', 'elead_site_branding', 20 );
	remove_action( 'elead_header_action', 'elead_site_navigation', 30 );
	remove_action( 'customize_register', 'elead_customize_register' );
	
	remove_action( 'elead_primary_content_action', 'elead_add_slider_section', 10 );
	remove_filter( 'elead_filter_slider_section_details', 'elead_get_slider_section_details' );
	remove_action( 'elead_primary_content_action', 'elead_add_courses_section', 40 );
	remove_filter( 'elead_filter_courses_section_details', 'elead_get_courses_section_details' );
	remove_action( 'elead_primary_content_action', 'elead_add_service_section', 30 );
	remove_filter( 'elead_filter_courses_section_details', 'elead_get_service_section_details' );
	
	remove_action('add_meta_boxes', 'add_gs_team_metaboxes');
}

function retis_add_custom_box()
{
	add_meta_box(
		'retis_url_box_id',       	// Unique ID
		'Portfolio URL',  		  	// Box title
		'retis_url_box_html',  		// Content callback, must be of type callable
		'portfolio'               	// Post type
	);
}
function retis_url_box_html( $post )
{
	$value = get_post_meta( $post->ID, '_retis_url_box', true );
    ?>
    <label for="retis_url_field">URL of the element</label>
	<input type="url" name="retis_url_field" id="retis_url_field" class="vp-input" value="<?php echo $value ?>">
    <?php
}
function retis_save_postdata( $post_id )
{
    if (array_key_exists('retis_url_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_retis_url_box',
            $_POST['retis_url_field']
        );
    }
}
function add_retis_team_metaboxes()
{
	add_meta_box('gsTeamSection', 'Member\'s Additional Info' ,'retis_team_cmb_cb', 'gs_team', 'normal', 'high');
}
function retis_team_cmb_cb( $post )
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
	<?php if ( gtm_fs()->is__premium_only() or gtm_fs()->can_use_premium_code() ) { ?>
	<div class="form-group">
		<label for="gsribon">Ribon</label>
		<input type="text" id="gsribon" class="form-control" name="gs_ribon" value="<?php echo isset($gs_ribon) ? esc_attr($gs_ribon) : ''; ?>">
	</div>
	<?php } ?>
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

	<?php if ( gtm_fs()->is__premium_only() or gtm_fs()->can_use_premium_code() ) { ?>	
	<h2>Member's Skills</h2>
	<div class="member-details-section">
		<table id="repeatable-fieldset-skill" width="100%" class="gstm-sorable-table">
			<thead>
				<tr>
					<td width="3%"></td>
					<td width="45%"><?php _e('Title','');?></td>
					<td width="42%"><?php _e('Percent','');?></td>
					<td width="10%"></td>
				</tr>
			</thead>
			<tbody>
				<?php if($gs_skill) :
																				   foreach ( $gs_skill as $field ) { ?>


				<tr>
					<td><i class="fa fa-arrows" aria-hidden="true"></i></td>
					<td>
						<input type="text" placeholder="html" class="widefat" name="gstm-skill-name[]" value="<?php if(isset($field['skill'])) echo esc_attr( $field['skill'] ); ?>"/>
					</td>
					<td><input type="text" placeholder="85" class="widefat" name="gstm-skill-percent[]" value="<?php if(isset($field['percent'])) echo esc_attr( $field['percent'] ); ?>"/></td>
					<td><a class="button remove-row" href="#"><?php _e('Remove','');?></a></td>
				</tr>	
				<?php } else: ?> 
				<tr>
					<td><i class="fa fa-arrows" aria-hidden="true"></i></td>
					<td>
						<input type="text" placeholder="html" class="widefat" name="gstm-skill-name[]" value="<?php if(isset($field['skill'])) echo esc_attr( $field['skill'] ); ?>"/>
					</td>
					<td><input type="text" placeholder="85" class="widefat" name="gstm-skill-percent[]" value="<?php if(isset($field['percent'])) echo esc_attr( $field['percent'] ); ?>"/></td>
					<td><a class="button remove-row" href="#"><?php _e('Remove','');?></a></td>
				</tr>
				<?php endif; ?>	
				<tr class="empty-skill screen-reader-text">
					<td><i class="fa fa-arrows" aria-hidden="true"></i></td>
					<td>
						<input type="text" placeholder="<?php _e('ex: Wordpress','');?>" class="widefat" name="gstm-skill-name[]" value="<?php if(isset($field['link'])) echo esc_attr( $field['link'] ); ?>"/>
					</td>
					<td><input type="text" placeholder="<?php _e('ex: 90','');?>" class="widefat" name="gstm-skill-percent[]" value=""/></td>
					<td><a class="button remove-row" href="#"><?php _e('Remove','');?></a></td>
				</tr>
			</tbody>
		</table>
		<p><a class="button gstm-add-skill" href="#" data-table="repeatable-fieldset-skill"><?php _e('Add row','');?></a></p>
	</div>
	<?php } ?>
</div>

<?php
}

/**
 * Load core file
 */
require get_stylesheet_directory() . '/inc/core.php';

?>
