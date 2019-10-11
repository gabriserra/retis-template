<?php

// **********************************
// REMOVE / RE-ADD PLUGIN ACTIONS
// **********************************

function retis_add_visual_portfolio_actions()
{
    add_action( 'add_meta_boxes', 'add_retis_visual_portfolio_metaboxes' );
    add_action( 'save_post', 'save_retis_visual_portfolio_postdata' );
}

retis_add_visual_portfolio_actions();

// **********************************
// ADD/SAVE NEW METABOXES
// **********************************

function add_retis_visual_portfolio_metaboxes()
{
    add_meta_box( 'visualPortfolioURL', 'Portfolio URL', 'retis_visual_portfolio_cmb_url', 'portfolio' );
}

function save_retis_visual_portfolio_postdata( $post_id )
{
    if (array_key_exists('retis_visual_portfolio_cmb_url_field', $_POST)) {
        update_post_meta(
            $post_id,
            '_portfolio_url_box',
            $_POST['retis_visual_portfolio_cmb_url_field']
        );
	}
}

// **********************************
// DEFINE NEW SHORTCODE BEHAVIOR
// **********************************

function retis_visual_portfolio_cmb_url( $post )
{
	$value = get_post_meta( $post->ID, '_portfolio_url_box', true );
    ?>
    <label for="retis_visual_portfolio_cmb_url_field">URL of the element</label>
	<input type="url" name="retis_visual_portfolio_cmb_url_field" id="retis_visual_portfolio_cmb_url_field" class="vp-input" value="<?php echo $value ?>">
    <?php
}