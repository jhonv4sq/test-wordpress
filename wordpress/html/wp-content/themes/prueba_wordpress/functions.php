<?php
/**
 * Prueba WordPress theme functions
 *
 * @package Prueba_Wordpress
 */

namespace Prueba_Wordpress;

add_action( 'after_setup_theme', __NAMESPACE__ . '\setup' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_theme_style' );
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_add_ajax' );
add_action( 'wp', __NAMESPACE__ . '\load_json_data' );

add_action( 'wp_ajax_filter_user_data', __NAMESPACE__ . '\filter_data' );
add_action( 'wp_ajax_nopriv_filter_user_data', __NAMESPACE__ . '\filter_data' );

add_action( 'wp_ajax_get_all_data', __NAMESPACE__ . '\get_all_data' );
add_action( 'wp_ajax_nopriv_get_all_data', __NAMESPACE__ . '\get_all_data' );

/**
 * Sets up the theme functionalities.
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
 * Registers and enqueues ajax.
 */
function enqueue_add_ajax() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('prueba-wordpress-ajax', get_stylesheet_directory_uri() . '/assets/js/prueba_wordpress.js', array('jquery'), null, true);

    wp_localize_script('prueba-wordpress-ajax', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
}

/**
 * Loads user data from JSON file and passes it to the view.
 */
function load_json_data() {
    $json_file  = get_template_directory() . '/assets/json/users.json';
    $users_data = array();

    if ( file_exists( $json_file ) ) {
        $json_content = file_get_contents( $json_file );
        $users_data   = json_decode( $json_content, true )['users'];
    }

    set_query_var( 'users_data', $users_data );
}

/**
 * Get all users data from JSON file.
 */
function get_all_data() {
    load_json_data();
    $users_data = get_query_var( 'users_data' );
    wp_send_json_success( $users_data );
}

/**
 * Filter data that we request from the form.
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

            $data_count = count( $data );

            load_json_data();
            $users_data = get_query_var( 'users_data' );

            // Filter the users based on the form input.
            $filter_data = array_filter( $users_data, function( $user ) use ( $data, $data_count ) {
                $turns = 0;
                foreach ( $data as $key => $value ) {
                    if ( 'surname' === $key ) {
                        if ( stripos( $user['surname1'], $value ) !== false || stripos( $user['surname2'], $value ) !== false ) {
                            $turns++;
                        }
                    } else {
                        if ( stripos( $user[$key], $value ) !== false ) {
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
                wp_send_json_success( $filter_data );
            } else {
                wp_send_json_success( $users_data );
            }
        }
    }
}
