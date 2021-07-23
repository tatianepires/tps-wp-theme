<?php
/*
 * Frontend scripts
 *
 * Enqueue theme's CSS and JS
 */

function tps_frontend_scripts() {
  // Parent theme's CSS
  wp_enqueue_style('twentyseventeen', get_template_directory_uri() . '/style.css' );

  $third_party_styles = array(
    'google-fonts' => array(
      'src' => 'https://fonts.googleapis.com/css?family=Dancing+Script|Open+Sans+Condensed:300|Raleway',
    ),
    'font-awesome' => array(
      'src' => get_stylesheet_directory_uri() . '/third-party/font-awesome/css/fontawesome.min.css',
    ),
    'font-awesome-light' => array(
      'src' => get_stylesheet_directory_uri() . '/third-party/font-awesome/css/light.min.css',
    ),
  );

  // Enqueue third party styles
  foreach($third_party_styles as $style_name => $style_data) {
    wp_enqueue_style($style_name, $style_data['src'], array(), null);
  }

  // Theme's CSS
  wp_enqueue_style('tps', get_stylesheet_directory_uri() . '/css/tps.min.css', array('twentyseventeen'));

  if( is_front_page() ) {
    wp_enqueue_script('smooth-scroll', get_stylesheet_directory_uri() . '/js/smooth-scroll.min.js', array('jquery'), false, true);
  }
}
add_action( 'wp_enqueue_scripts', 'tps_frontend_scripts' );
