<?php
/**
 * The header for our theme
 *
 * @package Prueba_Wordpress
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title><?php wp_title(); ?></title> -->
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <header>
        
    <div class="prueba-wordpress__container">
        <h1><?php bloginfo( 'name' ); ?></h1>
    </div>

    </header>