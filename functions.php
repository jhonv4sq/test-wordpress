<?php
/**
 * Prueba WordPress theme functions
 *
 * @package Test_Wordpress
 */

namespace Test_Wordpress;

add_action( 'init', __NAMESPACE__ . '\start_session' );
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_theme_style' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_add_ajax' );

add_action( 'wp_ajax_filter_user_data', __NAMESPACE__ . '\filter_data' );
add_action( 'wp_ajax_nopriv_filter_user_data', __NAMESPACE__ . '\filter_data' );

add_action( 'wp_ajax_get_all_data', __NAMESPACE__ . '\get_all_data' );
add_action( 'wp_ajax_nopriv_get_all_data', __NAMESPACE__ . '\get_all_data' );

add_action( 'wp_ajax_change_page', __NAMESPACE__ . '\change_page' );
add_action( 'wp_ajax_nopriv_change_page', __NAMESPACE__ . '\change_page' );

/**
 * Starts the session if not already started.
 */
function start_session() {
    if ( ! session_id() ) {
        session_start();
    }
}

/**
 * Sets up theme functionalities.
 */
function setup() {
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'title-tag' );
}

/**
 * Registers and enqueues the theme assets.
 */
function enqueue_theme_style() {
    wp_register_style( 'prueba_wordpress', get_stylesheet_uri(), array(), wp_get_theme()->Version );
    wp_enqueue_style( 'prueba_wordpress' );
}

/**
 * Registers and enqueues AJAX.
 */
function enqueue_add_ajax() {
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'test-wordpress-ajax', get_stylesheet_directory_uri() . '/assets/js/test_wordpress.js', array( 'jquery' ), null, true );

    wp_localize_script( 'test-wordpress-ajax', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

/**
 * Loads user data from JSON file and returns it.
 *
 * @return array
 */
function load_json_data() {
    $json_file  = get_template_directory() . '/assets/json/users.json';
    $users_data = array();

    if ( file_exists( $json_file ) ) {
        $json_content = file_get_contents( $json_file );
        $users_data   = json_decode( $json_content, true )['users'];
    }

    return $users_data;
}

/**
 * Paginates user data.
 *
 * @param array $users_data User data array.
 * @param int   $page       Current page number.
 * @param int   $per_page   Number of items per page.
 *
 * @return array Paged data.
 */
function paginate_data( $users_data = array(), $page = 1, $per_page = 5 ) {
    $offset     = ( $page - 1 ) * $per_page;
    $paged_data = array_slice( $users_data, $offset, $per_page );

    return $paged_data;
}

/**
 * Gets all users data from JSON file and returns paginated data.
 */
function get_all_data() {
    $users_data = load_json_data();
    $paged_data = paginate_data( $users_data );

    $_SESSION['local_data'] = $users_data;

    wp_send_json_success( array(
        'users'        => $paged_data,
        'total_pages'  => ceil( count( $users_data ) / 5 ),
        'current_page' => 1,
    ) );
}

/**
 * Filters user data from the form submission.
 */
function filter_data() {
    if ( isset( $_POST['search_nonce'] ) && wp_verify_nonce( $_POST['search_nonce'], 'search_form_nonce' ) ) {
        if ( isset( $_POST['name'], $_POST['surname'], $_POST['email'] ) ) {

            // Sanitize and filter the form data.
            $data = array(
                'name'    => sanitize_text_field( $_POST['name'] ),
                'surname' => sanitize_text_field( $_POST['surname'] ),
                'email'   => sanitize_email( $_POST['email'] ),
            );

            $data = array_filter( $data, function( $value ) {
                return $value !== '';
            });

            $data_count  = count( $data );
            $users_data  = load_json_data();

            // Filter the users based on the form input.
            $filter_data = array_filter( $users_data, function( $user ) use ( $data, $data_count ) {
                $turns = 0;
                foreach ( $data as $key => $value ) {
                    if ( 'surname' === $key ) {
                        if ( stripos( $user['surname1'], $value ) !== false || stripos( $user['surname2'], $value ) !== false ) {
                            $turns++;
                        }
                    } else {
                        if ( stripos( $user[ $key ], $value ) !== false ) {
                            $turns++;
                        }
                    }

                    if ( $turns === $data_count ) {
                        return true;
                    }
                }
                return false;
            });

            if ( $data_count !== 0 ) {
                $_SESSION['local_data'] = $filter_data;

                $paged_data = paginate_data( $filter_data );

                wp_send_json_success( array(
                    'users'        => $paged_data,
                    'total_pages'  => ceil( count( $filter_data ) / 5 ),
                    'current_page' => 1,
                ) );
            } else {
                get_all_data();
            }
        }
    }
}

/**
 * Changes the page of the user table via AJAX.
 */
function change_page() {
    $page       = isset( $_POST['page'] ) ? sanitize_text_field( $_POST['page'] ) : 1;
    $local_data = isset( $_SESSION['local_data'] ) ? $_SESSION['local_data'] : load_json_data();

    $paged_data  = paginate_data( $local_data, $page );
    $total_pages = ceil( count( $local_data ) / 5 );

    wp_send_json_success( array(
        'users'        => $paged_data,
        'total_pages'  => $total_pages,
        'current_page' => $page,
    ) );
}
