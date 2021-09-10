<?php
/*
 * Change RSS /feed template
 */
remove_all_actions( 'do_feed_rss2' );

function tps_rss_template( $for_comments ) {
    $rss_template = get_stylesheet_directory() . '/feed/rss2.php';
    if( file_exists( $rss_template ) ) load_template( $rss_template );
    else do_feed_rss2( $for_comments ); // Call default function
}
add_action( 'do_feed_rss2', 'tps_rss_template', 10, 1 );


/*
 * Add /feed/en
 * For custom post type post_en
 */
function tps_rss_en(){
  add_feed('en', 'tps_en_feed');
}
add_action('init', 'tps_rss_en');

function tps_en_feed(){
  get_template_part('feed/rss2', 'en');
}
