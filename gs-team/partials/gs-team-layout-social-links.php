<?php
/**
 * GS Team - Layout Social Links
 * @author GS Plugins <hello@gsplugins.com>
 * 
 * Overridden
 * 
 * @package GS_Team/Templates
 * @version 1.0.0
 */

$social_links = gs_team_get_social_links( get_the_id() );

if ( 'on' == $gs_member_connect && !empty($social_links) ): ?>

    <ul class="gs-team-social">

    <?php foreach ( $social_links as $social ): ?>
        
        <?php if ( $social['icon']=='envelope' ) {
            if (empty($social['link'])) {
               $link = "#";
            } else { 
                $name = strstr($social['link'], '@', true);
                $domain = substr(strstr($social['link'], '@'), 1);
                $link = "javascript:if(window.confirm('Send an email to: $name \'at\' $domain ')) { var at = '@'; window.location.href='mailto:$name' + at + '$domain'; }";
            }
        } else {
            $link = !empty($social['link']) ? $social['link'] : '#';
            $link = esc_url($link);
        } ?>

        <li>
            <?php printf( '<a class="%1$s" href="%2$s" target="_blank" itemprop="sameAs"><i class="fa fa-%1$s"></i></a>', esc_attr($social['icon']), $link ); ?>
        </li>

    <?php endforeach; ?>
        
    </ul>

    <?php do_action( 'gs_team_after_member_social_links' ); ?>

<?php endif; ?>