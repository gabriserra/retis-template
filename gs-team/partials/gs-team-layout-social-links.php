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

$member_id = get_the_id();

$social_links = get_post_meta( $member_id, 'gs_social', true );

$social_links = apply_filters( 'gs_team_member_social_links', $social_links, $member_id );

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
        } ?>

        <li>
            <?php
                if ( $social['icon']=='envelope' ) {
                    printf(
                        '<a class ="%s" href="%s" itemprop="sameAs"><i class="fa fa-%s"></i></a>',
                        esc_html($social['icon']), $link, esc_html($social['icon'])
                    );
                }
                else 
                {
                    printf(
                        '<a class ="%s" href="%s" target="_blank" itemprop="sameAs"><i class="fa fa-%s"></i></a>',
                        esc_html($social['icon']), esc_url($link), esc_html($social['icon'])
                    );
                } 
            ?>
        </li>

    <?php endforeach; ?>
        
    </ul>

    <?php do_action( 'gs_team_after_member_social_links' ); ?>

<?php endif; ?>