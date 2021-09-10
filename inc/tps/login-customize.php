<?php
/*
 * Customize logo
 */
function tps_login_image() { ?>
    <style type="text/css">
    #login h1 a, .login h1 a {
        background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/img/tps-login.png);
        width:261px;
        height:68px;
        background-size: 261px 68px;
        background-repeat: no-repeat;
    }
    #login h1 a, .login h1 a:focus,
    #login h1 a, .login h1 a:hover {
        border: none;
        outline: 0 !important;
    }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'tps_login_image' );

/*
 * Customize URL
 */
function tps_login_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'tps_login_url' );

/*
 * Customize URL title
 */
function tps_login_url_title() {
    $title_description = get_bloginfo('name') . ' - ' . get_bloginfo('description');
    return $title_description;
}
add_filter( 'login_headertext', 'tps_login_url_title' );
